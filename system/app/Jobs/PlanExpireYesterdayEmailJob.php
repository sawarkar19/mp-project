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
use App\Models\BusinessCustomer;
use App\Mail\PlanExpireTodayEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\PlanExpireTodayYesterdayEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PlanExpireYesterdayEmailJob
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug("run check:planexpireyesterday => Job file => PlanExpireYesterdayEmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $yesterday = Carbon::now()->subDays(1);

        $userIds = UserChannel::whereDate('will_expire_on', '=', $yesterday)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();    

        $users = User::whereIn('id', $userIds)->where('status', 1)->get();
        // Log::debug("run check:planexpireyesterday => Job file => PlanExpireYesterdayEmailJob => handle => check user exist or not datetime: ".date('d-m-Y H:s:i'));

        if (!empty($users)) {
            // Log::debug("run check:planexpireyesterday => Job file => PlanExpireYesterdayEmailJob => handle => user exist and go to foreach loop datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {
                $data = [
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                ];

                $email_info = Email::where('id', 17)->first();
                
                $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $user->name."</b>", $email_info['content']);
                $data['subject'] = $email_info['subject'];

                $email = new PlanExpireTodayYesterdayEmail($data);
                Mail::to($user->email)->send($email);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_sub_expired_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Share link */
                $long_link = URL::to('/').'/pricing';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "plan_expire_yesterday");

                $payload = \App\Http\Controllers\WACloudApiController::mp_sub_expired_alert('91'.$user->mobile, $user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Add entry to email_jobs table */
                $save_emailjob = new EmailJob();
                $save_emailjob->user_id = $user->id;
                $save_emailjob->email_id = 17;
                $save_emailjob->email = $user->email;
                $save_emailjob->subject = $data['subject'];
                $save_emailjob->message = $data['message'];
                $save_emailjob->save();
            }
        }
    }
}
