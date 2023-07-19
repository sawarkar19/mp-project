<?php

namespace App\Jobs;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\EmailJob;
use App\Models\UserChannel;
use App\Mail\LowWalletEmail;
use App\Models\AdminMessage;
use App\Models\GroupCustomer;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class LowWalletEmailJob implements ShouldQueue
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
        // Log::debug("run check:lowwallet => Job file => LowWalletEmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $today_date = date('Y-m-d');

        $userIds = UserChannel::whereDate('will_expire_on', '>', $today_date)
            ->groupBy('user_id')
            ->pluck('user_id')
            ->toArray();   
            
        $users = User::with('wallet')
                    ->whereIn('id', $userIds)
                    ->where('status', 1)
                    ->get();
                    
        // Log::debug("run check:lowwallet => Job file => LowWalletEmailJob => handle => check users who wallet amount low datetime: ".date('d-m-Y H:s:i'));

        if (!empty($users)) {  
            // Log::debug("run check:lowwallet => Job file => LowWalletEmailJob => handle => get users who wallet amount low datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {
                
                $upcomingMessage = MessageTemplateSchedule::whereDate('scheduled', '>', $today_date)
                ->where('user_id', $user->id)
                ->first();
                // dd($upcomingMessage);
                
                
                $select_group = explode(",", $upcomingMessage->groups_id);
                
                $group_customer = GroupCustomer::whereIn('contact_group_id', $select_group)->count();

                if($group_customer > $user->wallet->total_messages){
                    $data = [
                        'name' => $user->name,
                        'mobile' => $user->mobile,
                        'email' => $user->email,
                    ];
    
                    $email_info = Email::where('id', 13)->first();
                    
                    $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $user->name."</b>", $email_info['content']);
                    $data['subject'] = $email_info['subject'];
    
                    $email = new LowWalletEmail($data);
                    Mail::to($user->email)->send($email);

                    /* Admin Message History start */
                    $addmin_history = new AdminMessage();
                    $addmin_history->template_name = 'mp_low_messages';
                    $addmin_history->message_sent_to = $user->mobile;
                    $addmin_history->save();
                    /* Admin Message History end */

                    /* Share link */
                    $long_link = URL::to('/').'/pricing';
                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "low_balance");

                    $payload = \App\Http\Controllers\WACloudApiController::mp_low_messages('91'.$user->mobile, $user->name, $shortLinkData->original["code"]);
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
