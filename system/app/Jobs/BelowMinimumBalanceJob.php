<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\Email;
use App\Models\EmailJob;
use App\Models\AdminMessage;
use App\Mail\LowWalletEmail;
use App\Http\Controllers\ShortLinkController;

class BelowMinimumBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $emailJobData;
    public $user;
    public $day;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailJobData)
    {
        $this->user = $emailJobData['user'];
        $this->day = $emailJobData['day'];
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

        $email_info = Email::where('id', 11)->first();
        $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->user->name."</b>", $email_info['content']);
        $data['subject'] = $email_info['subject'];

        /* Send Email */
        $email = new LowWalletEmail($data);
        Mail::to($this->user->email)->send($email);

        /* Short link */
        $long_link = URL::to('/').'/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "low_minimum_balance");

        /* Add entry in email_jobs table */
        $save_emailjob = new EmailJob();
        $save_emailjob->user_id = $this->user->id;
        $save_emailjob->email_id = $email_info['id'];
        $save_emailjob->email = $this->user->email;
        $save_emailjob->subject = $data['subject'];
        $save_emailjob->message = $data['message'];
        $save_emailjob->notification_day = $this->day;
        $save_emailjob->save();

        if($shortLinkData->original["success"] != false){
            /* Send Whatsapp Notification */
            $payload = \App\Http\Controllers\WACloudApiController::mp_account_credits_are_low1('91'.$this->user->mobile, $this->user->name, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);


            /* Admin Message History start */
            $admin_history = new AdminMessage();
            $admin_history->template_name = 'mp_account_credits_are_low1';
            $admin_history->message_sent_to = $this->user->mobile;
            $admin_history->save();
            /* Admin Message History end */
        }
    }
}
