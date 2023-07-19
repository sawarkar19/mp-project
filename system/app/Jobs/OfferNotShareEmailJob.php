<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OfferNotShareEmailJob implements ShouldQueue
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

        $today = date('Y-m-d');
        $userIds = UserChannel::where('channel_id', 2)->where('will_expire_on', '>=', $today)->pluck('user_id')->toArray();
        
        $yesterday = Carbon::now()->subDays(1);
        $offers = Offer::with('users')
                        ->whereIn('user_id', $userIds)
                        ->whereDate('start_date', '=', $yesterday)
                        ->whereDate('end_date', '>=', $today)
                        ->get();
                        
                    
        $userIdsWithoffer = array();
        foreach($offers as $offer){
            if(empty($offe->users)){
                $userIdsWithoffer[] = $offer->user_id;
            }
        }
        
        $users = User::where('id', $userIdsWithoffer)->where('status', 1)->get();

        if (!empty($users)) {

            foreach ($users as $key => $user) {
                $data = [
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                ];

                $email_info = Email::where('id', 12)->first();
                $data['message'] = $email_info['content'];
                $data['subject'] = $email_info['subject'];

                $email = new OfferNotShareEmail($data);
                Mail::to($user->email)->send($email);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_offer_notshared_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Short link */
                $long_link = URL::to('/').'/signin';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "offer_not_shared");

                $payload = \App\Http\Controllers\WACloudApiController::mp_offer_notshared_alert('91'.$user->mobile, $user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

               /* Add entry in email_jobs table */
                $save_emailjob = new EmailJob();
                $save_emailjob->user_id = $user->id;
                $save_emailjob->email = $user->email;
                $save_emailjob->email_id = $email_info['id'];
                $save_emailjob->subject = $data['subject'];
                $save_emailjob->message = $data['message'];
                $save_emailjob->save();
            }
        }
    }
}