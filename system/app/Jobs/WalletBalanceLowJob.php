<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\EmailJob;
use App\Mail\LowWalletEmail;
use App\Models\AdminMessage;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class WalletBalanceLowJob implements ShouldQueue
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
        $data = [
            'name' => $this->user->name,
            'mobile' => $this->user->mobile,
            'email' => $this->user->email,
        ];
        $user_notification_info = UserNotification::where('notification_id', 1)->where('user_id',$this->user->id)->first();

        if($user_notification_info->email==1){
            $email_info = Email::where('id', 13)->first();
            $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->user->name."</b>", $email_info['content']);
            $data['message'] = $email_info['content'];
            $data['subject'] = $email_info['subject'];

            $email = new LowWalletEmail($data);
            Mail::to($this->user->email)->send($email);

            /* Add entry to email_jobs table */
            $save_emailjob = new EmailJob();
            $save_emailjob->user_id = $this->user->id;
            $save_emailjob->email_id = $email_info['id'];
            $save_emailjob->email = $this->user->email;
            $save_emailjob->subject = $data['subject'];
            $save_emailjob->message = $data['message'];
            $save_emailjob->save();
        }
        
        if($user_notification_info->wa==1){
            /* Short link */
            $long_link = URL::to('/').'/pricing';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "low_balance");

            if($shortLinkData->original["success"] != false){
                /* Send Notification on whatsapp */
                $payload = \App\Http\Controllers\WACloudApiController::mp_low_messages('91'.$this->user->mobile, $this->user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_low_messages';
                $addmin_history->message_sent_to = $this->user->mobile;
                $addmin_history->save();
                /* Admin Message History end */
            }
        }
    }
}
