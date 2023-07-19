<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\EmailJob;
use App\Mail\OfferNotSEmail;
use App\Models\AdminMessage;
use App\Models\UserNotification;
use Illuminate\Bus\Queueable;
use App\Mail\OfferNotShareEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OfferNotSharedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $useroffer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($useroffer)
    {
        $this->useroffer = $useroffer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'name' => $this->useroffer->user->name,
            'mobile' => $this->useroffer->user->mobile,
            'email' => $this->useroffer->user->email,
        ];
        $user_notification_info = UserNotification::where('notification_id', 7)->where('user_id',$this->useroffer->user->id)->first();
        if($user_notification_info->email==1){
            $email_info = Email::where('id', 26)->first();
            
            $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->useroffer->user->name."</b>", $email_info['content']);
            $data['subject'] = $email_info['subject'];

            /* Send email */
            $email = new OfferNotShareEmail($data);
            Mail::to($this->useroffer->user->email)->send($email);

            /* Add entry in email_jobs table */
            $save_emailjob = new EmailJob();
            $save_emailjob->user_id = $this->useroffer->user->id;
            $save_emailjob->email_id = $email_info['id'];
            $save_emailjob->email = $this->useroffer->user->email;
            $save_emailjob->subject = $data['subject'];
            $save_emailjob->message = $data['message'];
            $save_emailjob->save();
        }
        if($user_notification_info->wa==1){
        /* Short link */
            $long_link = URL::to('/').'/signin';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->useroffer->user->id ?? 0, "offer_not_shared");

            if($shortLinkData->original["success"] != false){
                /* Send whatsapp notification */
                $payload = \App\Http\Controllers\WACloudApiController::mp_offer_not_shared('91'.$this->useroffer->user->mobile, $this->useroffer->user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_offer_not_shared';
                $addmin_history->message_sent_to = $this->useroffer->user->mobile;
                $addmin_history->save();
                /* Admin Message History end */
            }
        }
    }
}
