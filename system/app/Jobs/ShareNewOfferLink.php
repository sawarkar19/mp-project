<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\Userplan;
use App\Models\UserChannel;
use App\Models\GroupCustomer;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use App\Models\InstantTask;
use App\Models\OfferTemplate;

class ShareNewOfferLink implements ShouldQueue
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
        // Log::debug("run check:newoffer => ShareNewOfferLink => handle datetime: ".date('d-m-Y H:s:i'));

        // share today datewise new offer
        $todays_date = date('Y-m-d');
        $users = UserChannel::where('channel_id', 3)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();
        $usersWithAutoSend = BusinessDetail::whereIn('user_id', $users)->where('send_when_start', 1)->pluck('user_id')->toArray();
        $currentOffers = Offer::whereIn('user_id', $usersWithAutoSend)->where('start_date', $todays_date)->get();

        if(!empty($currentOffers)){
            foreach($currentOffers as $offer){
                // update modify task for youtube if video url available
                $offerTemplate = OfferTemplate::where('offer_id', $offer->id)->first();
                if($offerTemplate != null && $offerTemplate->video_url!=NULL){
                    // youtube task Id's for Like(11) and Comments(12)
                    $taskIds = [11, 12];
                    foreach ($taskIds as $taskKey => $task){
                        $youtubeInstantTask = InstantTask::where('user_id', $offer->user_id)->where('task_id', $task)->whereNull('deleted_at')->first();
                        if($youtubeInstantTask == NULL){
                            $youtubeInstantTask = new InstantTask;
                            $youtubeInstantTask->user_id = $offer->user_id;
                            $youtubeInstantTask->offer_id = $offer->id;
                            $youtubeInstantTask->task_id = $task;
                            $youtubeInstantTask->task_value = $offerTemplate->video_url;
                            $youtubeInstantTask->save();
                        }else if($youtubeInstantTask != NULL && $youtubeInstantTask->offer_id != $offer->id){
                            $youtubeInstantTask->deleted_at = Carbon::now();
                            $youtubeInstantTask->save();

                            $youtubeInstantTask = new InstantTask;
                            $youtubeInstantTask->user_id = $offer->user_id;
                            $youtubeInstantTask->offer_id = $offer->id;
                            $youtubeInstantTask->task_id = $task;
                            $youtubeInstantTask->task_value = $offerTemplate->video_url;
                            $youtubeInstantTask->save();
                        }
                        
                    }
                }
                // echo "<br/> offer <pre>"; print_r($offer);
                dispatch(new \App\Jobs\ShareToCustomerJob($offer));
            }
        }

        // echo "finish";
        // Log::debug($users);
    }
}
