<?php

namespace App\Jobs;

use App\Models\Email;
use App\Models\EmailJob;
use App\Models\AdminMessage;
use Illuminate\Bus\Queueable;
use App\Mail\OfferToExpiredEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DoNotHaveUpcomingOfferJob implements ShouldQueue
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

        $email_info = Email::where('id', 10)->first();
        
        $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->user->name."</b>", $email_info['content']);
        $data['subject'] = $email_info['subject'];

        $email = new OfferToExpiredEmail($data);
        Mail::to($this->user->email)->send($email);

        /* Save in email_jobs */
        $emailjob = new EmailJob();
        $emailjob->user_id = $this->user->id;
        $emailjob->email_id = $email_info['id'];
        $emailjob->email = $this->user->email;
        $emailjob->subject = $data['subject'];
        $emailjob->message = $data['message'];
        $emailjob->save();

        /* Share link */
        $long_link = URL::to('/').'/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "dont_have_upcoming_offer");
        
        if($shortLinkData->original["success"] != false){
            $payload = \App\Http\Controllers\WACloudApiController::mp_offer_expire_soon('91'.$this->user->mobile, $this->user->name, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_offer_expire_soon';
            $addmin_history->message_sent_to = $this->user->mobile;
            $addmin_history->save();
            /* Admin Message History end */
        }
    }
}
