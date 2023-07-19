<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OfferNotPostEmailJob
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

        




        $today = date('Y-m-d');
        $userIds = UserChannel::where('channel_id', 2)->where('will_expire_on', '>=', $today)->pluck('user_id')->toArray();

        $offers = Offer::with('user')
                        ->has('user')
                        ->whereIn('user_id', $userIds)
                        ->where('start_date', '<=', $today)
                        ->where('end_date', '>=', $today)
                        ->where('status', 1)
                        ->get();
                     

        $notPostedOffers = array();
        foreach($offers as $offer){
            $task = InstantTask::where('offer_id', $offer->id)->where('user_id', $offer->user_id)->first();
            if($task == null){
                $notPostedOffers[] = $offer;
            }
        }
        
        // dd($notPostedOffers);
        // Log::debug("run check:offernotpost => Job file => OfferNotPostEmailJob => handle => check offers not post available or not datetime: ".date('d-m-Y H:s:i'));

        if(!empty($notPostedOffers)) {
            // Log::debug("run check:offernotpost => Job file => OfferNotPostEmailJob => handle => not posted offers found datetime: ".date('d-m-Y H:s:i'));

            foreach ($notPostedOffers as $key => $notPostedOffer) {
                $data = [
                    'name' => $notPostedOffer->user->name,
                    'mobile' => $notPostedOffer->user->mobile,
                    'email' => $notPostedOffer->user->email,
                ];

                $email_info = Email::where('id', 8)->first();
                
                $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $notPostedOffer->user->name."</b>", $email_info['content']);
                $data['subject'] = $email_info['subject'];

                $email = new OfferNotPostEmail($data);
                Mail::to($notPostedOffer->user->email)->send($email);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_dont_posted_offer';
                $addmin_history->message_sent_to = $notPostedOffer->user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Share link */
                $long_link = URL::to('/').'/signin';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $notPostedOffer->user->id ?? 0, "offer_not_posted");


                $payload = \App\Http\Controllers\WACloudApiController::mp_dont_posted_offer('91'.$notPostedOffer->user->mobile, $notPostedOffer->user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Add entry in email_jobs table */
                $save_emailjob = new EmailJob();
                $save_emailjob->user_id = $notPostedOffer->user->id;
                $save_emailjob->email_id = $email_info['id'];
                $save_emailjob->email = $notPostedOffer->user->email;
                $save_emailjob->subject = $data['subject'];
                $save_emailjob->message = $data['message'];
                $save_emailjob->save();
            }
        }
    }
}
