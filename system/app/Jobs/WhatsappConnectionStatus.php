<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\Option;
use App\Models\EmailJob;
use App\Mail\WaLogoutEmail;
use App\Models\AdminMessage;
use App\Models\MessageRoute;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class WhatsappConnectionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        $wa_session = WhatsappSession::where('user_id', $this->user->id)->first();
        $wa_url = Option::where('key','oddek_url')->first();
        $access_token = $this->user->wa_access_token;
        $instance_id = $wa_session->instance_id;
        
        $postDataArray = [
            'instance_id' => $instance_id,
            'access_token' => $access_token
        ];
        
        $dataQuery = http_build_query($postDataArray);
        $ch = curl_init();

        $url=$wa_url->value."/api/reconnect.php";
        
        $getUrl = $url."?".$dataQuery;
        
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
            
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);
        */

        /* WA API info check start */
        $wa_session = WhatsappSession::where('user_id', $this->user->id)->first();
        
        $wa_instance_info = app('App\Http\Controllers\WaApiController')->waInstanceInfo($wa_session->instance_id);
        if(isset($wa_instance_info['data']) && isset($wa_instance_info['data']['instance_data']) && isset($wa_instance_info['data']['instance_data']['user']) && empty($wa_instance_info['data']['instance_data']['user'])){

        /* WA API info check end */

        // if(isset($output->status) && $output->status != 'success'){
            
            $wa_session->instance_id = '';
            $wa_session->status = 'lost';
            $wa_session->save();
            
            /* Update Business Whatsapp Number */
            $businessDetail = BusinessDetail::where('user_id',$this->user->id)->first();
            $businessDetail->whatsapp_number = '';
            $businessDetail->save();

            /* Disable whatsapp routes */
            MessageRoute::where('user_id', $this->user->id)->update(['wa' => 0]);


            /* Send Email */
            $email_info = Email::where('id', 16)->first();
            
            $subject = str_replace("[mobile_no]", substr($wa_session->wa_number, 2), $email_info->subject);

            $data = [
                'name' => $this->user->name,
                'email' => $this->user->email,
                'message' => $email_info->content,
                'subject' => $subject
            ];
            
            $email = new WaLogoutEmail($data);
            Mail::to($data['email'])->send($email);
            
            $job = new EmailJob;
            $job->user_id = $this->user->id;
            $job->email_id = $email_info->id;
            $job->email = $this->user->email;
            $job->email_id = $email_info->id;
            $job->subject = $subject;
            $job->notification_day = 'today';           
            $job->message = $email_info->content;
            $job->save();

            $long_link = URL::to('/').'/business/settings';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "whatsapp_connection_status");

            if($shortLinkData->original["success"] != false){
                /* Send Notification */
                $payload = \App\Http\Controllers\WACloudApiController::mp_wa_disconnected('91'.$this->user->mobile, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_wa_disconnected';
                $addmin_history->message_sent_to = $this->user->mobile;
                $addmin_history->save();
                /* Admin Message History end */
                
            }
        }
    }
}
