<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\EmailJob;
use App\Mail\WaLogoutEmail;
use App\Models\AdminMessage;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use App\Models\WhatsappSession;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\WACloudApiController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NotifyWhatsappDisconnectedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $wa_session = WhatsappSession::where('user_id', $this->data['user']->id)->first();
        if ($wa_session == null) {
            $wa_session = new WhatsappSession();
            $wa_session->user_id = $this->data['user']->id;
        }
        $wa_session->save();
        
        /* Send Email */
        $email_info = Email::where('id', 16)->first();
        
        $subject = str_replace("[mobile_no]", substr($wa_session->wa_number, 2), $email_info->subject);

        $data = [
            'name' => $this->data['user']->name,
            'email' => $this->data['user']->email,
            'message' => $email_info->content,
            'subject' => $subject
        ];
        $user_notification_info = UserNotification::where('notification_id', 8)->where('user_id',$this->data['user']->id)->first();
        if($user_notification_info->email==1){
            $email = new WaLogoutEmail($data);
            Mail::to($data['email'])->send($email);
            
            $job = new EmailJob;
            $job->user_id = $this->data['user']->id;
            $job->email_id = $email_info->id;
            $job->email = $this->data['user']->email;
            $job->email_id = $email_info->id;
            $job->subject = $subject;
            $job->notification_day = $this->data['day'];           
            $job->message = $email_info->content;
            $job->save();
        }
        if($user_notification_info->wa==1){   
            $long_link = URL::to('/').'/business/settings';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->data['user']->id ?? 0, "whatsapp_disconnected");

            if($shortLinkData->original["success"] != false){
                /* Send Notification */
                $payload = WACloudApiController::mp_wa_disconnected('91'.$this->data['user']->mobile, $shortLinkData->original["code"]);
                $res = WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_wa_disconnected';
                $addmin_history->message_sent_to = $this->data['user']->mobile;
                $addmin_history->save();
                /* Admin Message History end */
                
            }
        }       
    }
}
