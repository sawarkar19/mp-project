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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\DailyReportsToBussinessEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;


class DailyReportsToBussinessEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
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
        // Log::debug("run check:dailyreportstobussiness => Job file => DailyReportsToBussinessEmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $today_date = date('Y-m-d');

        $userIds = UserChannel::whereDate('will_expire_on', '>', $today_date)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();

        $users = User::withCount('getBusCustomers','getInstantSubscriptions', 'getShareSubscriptions','getRedeemedCustomers','getUniqueClicks', 'getExtraClicks', 'getCompletedTasks')
                ->whereIn('id', $userIds)
                ->where('status', 1)
                ->get();

        // Log::debug("run check:dailyreportstobussiness => Job file => DailyReportsToBussinessEmailJob => handle => check user exist or not datetime: ".date('d-m-Y H:s:i'));

        // dd($users);
        if (!empty($users)) {
            // Log::debug("run check:dailyreportstobussiness => Job file => DailyReportsToBussinessEmailJob => handle => user exist and go to foreach loop datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {

                $added_customers = $user->get_bus_customers_count;
                $received_instant_challenge = $user->get_instant_subscriptions_count;
                $received_share_challenge = $user->get_share_subscriptions_count;
                $redeemed_customers = $user->get_redeemed_customers_count;
                $unique_clicks = $user->get_unique_clicks_count;
                $extra_clicks = $user->get_extra_clicks_count;
                $completed_tasks = $user->get_completed_tasks_count;

                $data = [
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                    'added_customers' => $added_customers,
                    'received_instant_challenge' => $received_instant_challenge,
                    'received_share_challenge' => $received_share_challenge,
                    'redeemed_customers' => $redeemed_customers,
                    'unique_clicks' => $unique_clicks,
                    'extra_clicks' => $extra_clicks,
                    'completed_tasks' => $completed_tasks
                ];
                
                $email_info = Email::where('id', 7)->first();
                
                $data['message'] = $email_info['content']. "\n\n<br> 1) Total Contacts added to your business = ".$added_customers."\n <br> 2) Total Contacts who received Instant Challenge = ".$received_instant_challenge."\n <br> 3) Total Contacts who received Share Challenge = ".$received_share_challenge."\n <br> 4) Total Contacts who come to redeem the Challenge = ".$redeemed_customers."\n <br> 5) Total Completed Instant Challenge tasks by your contacts = ".$completed_tasks."\n <br> 6) Total Unique Clicks on your Offer Pages = ".$unique_clicks."\n <br> 7) Total Extra Clicks on your Offer Pages = ".$extra_clicks;

                $data['subject'] = $email_info['subject'];

                

                $email = new DailyReportsToBussinessEmail($data);
                Mail::to($user->email)->send($email);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_daily_reports_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Share link */
                $long_link = URL::to('/').'/pricing';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "daily_report");

                $payload = \App\Http\Controllers\WACloudApiController::mp_daily_reports_alert('91'.$user->mobile, $user->name, $added_customers, $received_customers, $redeemed_customers, $unique_clicks, $extra_clicks, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);
                
                /* Add entry to email_jobs table */
                $save_emailjob = new EmailJob();
                $save_emailjob->user_id = $user->id;
                $save_emailjob->email_id = $email_info['id'];
                $save_emailjob->email = $user->email;
                $save_emailjob->subject = $data['subject'];
                $save_emailjob->message = $data['message'];
                $save_emailjob->save();
            }
        }
    }
}
