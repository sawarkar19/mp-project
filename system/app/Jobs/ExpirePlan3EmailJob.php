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
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\BusinessPlanExpireInThreeDay;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ExpirePlan3EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug("run check:expireplanthreeday => Job file => ExpirePlan3EmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $three_day_before = Carbon::now()->addDay(3);

        $userIds = UserChannel::whereDate('will_expire_on', '=', $three_day_before)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();

        $users = User::whereIn('id', $userIds)->where('status', 1)->get();

        // Log::debug("run check:expireplanthreeday => Job file => ExpirePlan3EmailJob => handle => check user exist or not datetime: ".date('d-m-Y H:s:i'));

        if (!empty($users)) {
            // Log::debug("run check:expireplanthreeday => Job file => ExpirePlan3EmailJob => handle => user exist and go to foreach loop datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {
                $data = [
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                ];

                $email_info = Email::where('id', 5)->first();
                $data['message'] = $email_info['content'];
                $data['subject'] = $email_info['subject'];

                $email = new BusinessPlanExpireInThreeDay($data);
                // dd($email);
                Mail::to($user->email)->send($email);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_will_753_expire_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Share link */
                $long_link = URL::to('/').'/pricing';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "plan_expire");
                $day = 3;

               $payload = \App\Http\Controllers\WACloudApiController::mp_will_753_expire_alert('91'.$user->mobile, $user->name, $day, $shortLinkData->original["code"]);
               $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

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
