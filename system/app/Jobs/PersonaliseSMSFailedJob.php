<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\EmailJob;
use App\Models\AdminMessage;
use Illuminate\Bus\Queueable;
use App\Mail\PersonaliseSMSFailed;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PersonaliseSMSFailedJob implements ShouldQueue
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

        $email_info = Email::where('id', 32)->first();
        $data['message'] = $email_info['content'];
        $data['subject'] = $email_info['subject'];

        /* Send email */
        $email = new PersonaliseSMSFailed($data);
        Mail::to($this->user->email)->send($email);
        
        /* Add entry in email_jobs table */
        $save_emailjob = new EmailJob();
        $save_emailjob->user_id = $this->user->id;
        $save_emailjob->email_id = $email_info['id'];
        $save_emailjob->email = $this->user->email;
        $save_emailjob->subject = $data['subject'];
        $save_emailjob->message = $data['message'];
        $save_emailjob->save();

        /* Short link */
        $long_link = URL::to('/').'/signin';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "personalised_msg_failed");

        if($shortLinkData->original["success"] != false){
            /* Send whatsapp notification */
            $payload = \App\Http\Controllers\WACloudApiController::mp_personalised_message_alert('91'.$this->user->mobile, $this->user->name, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_personalised_message_alert';
            $addmin_history->message_sent_to = $this->user->mobile;
            $addmin_history->save();
            /* Admin Message History end */
        }
    }
}
