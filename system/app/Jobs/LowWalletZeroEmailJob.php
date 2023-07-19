<?php

namespace App\Jobs;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\EmailJob;
use App\Models\UserChannel;
use App\Models\AdminMessage;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Mail\LowWalletZeroEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class LowWalletZeroEmailJob implements ShouldQueue
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

        $email_info = Email::where('id', 31)->first();
        $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->user->name."</b>", $email_info['content']);
        $data['subject'] = $email_info['subject'];

        $email = new LowWalletZeroEmail($data);
        Mail::to($this->user->email)->send($email);

        /* Admin Message History start */
        $addmin_history = new AdminMessage();
        $addmin_history->template_name = 'mp_you_have_consumed_credits';
        $addmin_history->message_sent_to = $this->user->mobile;
        $addmin_history->save();
        /* Admin Message History end */

        /* Share link */
        $long_link = URL::to('/').'/pricing';
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->user->id ?? 0, "zero_wallet_balance");

        $payload = \App\Http\Controllers\WACloudApiController::mp_you_have_consumed_credits('91'.$this->user->mobile, $this->user->name, $shortLinkData->original["code"]);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Add entry to email_jobs table */
        $save_emailjob = new EmailJob();
        $save_emailjob->user_id = $this->user->id;
        $save_emailjob->email_id = $email_info['id'];
        $save_emailjob->email = $this->user->email;
        $save_emailjob->subject = $data['subject'];
        $save_emailjob->message = $data['message'];
        $save_emailjob->save();
    }
}
