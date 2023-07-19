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
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\BusinessCustomer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use App\Mail\AutoSettingLowWalletEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AutoSettingLowWalletEmailJob implements ShouldQueue
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
        // Log::debug("run check:autosettinglowwallet => Job file => AutoSettingLowWalletEmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $today_date = date('Y-m-d');

        $userIds = UserChannel::whereDate('will_expire_on', '>', $today_date)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();

        $users = User::with('autoShareOnBusiness')
                    ->has('autoShareOnBusiness')
                    ->whereIn('id', $userIds)
                    ->where('status', 1)
                    ->get();
                
        // Log::debug("run check:autosettinglowwallet => Job file => AutoSettingLowWalletEmailJob => handle => check user to set auto wallet amount zero datetime: ".date('d-m-Y H:s:i'));

        if (!empty($users)) {
            // Log::debug("run check:autosettinglowwallet => Job file => AutoSettingLowWalletEmailJob => handle => get user to set auto wallet amount zero datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {
                $sendMail = false;
                if ($user->autoShareOnBusiness != null) {
                    if ($user->autoShareOnBusiness->send_when_start == 1) {
                        $select_group = explode(',', $user->autoShareOnBusiness->selected_groups);

                        $group_customer = GroupCustomer::whereIn('contact_group_id', $select_group)->count();
                        

                        $message_wallet = MessageWallet::where('user_id', $user->id)
                            ->select('total_messages')
                            ->first();

                        if ($group_customer > $message_wallet->total_messages) {
                            $sendMail = true;
                        }
                    }

                    if ($user->autoShareOnBusiness->share_to_subscribed_customers == 1) {
                        $message_wallet = MessageWallet::where('user_id', $user->id)
                            ->select('total_messages')
                            ->first();

                        if ($message_wallet->total_messages < 100) {
                            $sendMail = true;
                        }
                    }
                }

                if ($sendMail == true) {
                    $data = [
                        'name' => $user->name,
                        'mobile' => $user->mobile,
                        'email' => $user->email,
                    ];

                    $email_info = Email::where('id', 12)->first();
                    $data['message'] = $email_info['content'];
                    $data['subject'] = $email_info['subject'];

                    $email = new AutoSettingLowWalletEmail($data);
                    Mail::to($user->email)->send($email);

                    /* Admin Message History start */
                    $addmin_history = new AdminMessage();
                    $addmin_history->template_name = 'mp_auto_sr_offer_notsmpt';
                    $addmin_history->message_sent_to = $user->mobile;
                    $addmin_history->save();
                    /* Admin Message History end */

                    /* Share link */
                    $long_link = URL::to('/') . '/pricing';
                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "low_wallet_mail");

                    $payload = \App\Http\Controllers\WACloudApiController::mp_auto_sr_offer_notsent('91' . $user->mobile, $user->name, $shortLinkData->original['code']);
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
}
