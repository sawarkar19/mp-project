<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\InstantTask;
use Illuminate\Bus\Queueable;
use App\Models\OfferSubscription;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DeleteExpiredOfferInstantTaskJob implements ShouldQueue
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
        /* Expire Instant Task */
        $instantTasks = InstantTask::with('getDeletingOfferDetail')
                                ->has('getDeletingOfferDetail')
                                ->whereNull('deleted_at')
                                ->groupBy('offer_id')->pluck('offer_id')->toArray();
        if(!empty($instantTasks)){
            InstantTask::whereIn('offer_id', $instantTasks)->update(['deleted_at' => \Carbon\Carbon::now()]);
        }

        /* Expire All Subscription */
        $instantSubscriptions = OfferSubscription::with('getDeletingOfferDetail')
                                            ->has('getDeletingOfferDetail')
                                            ->where('status', '1')
                                            ->where('channel_id', 2)
                                            ->pluck('id')->toArray();
        if(!empty($instantSubscriptions)){
            OfferSubscription::whereIn('id', $instantSubscriptions)->update(['status' => '3']);
        }

        $shareSubscriptions = OfferSubscription::with('getDeletingOfferDetail')
                                            ->has('getDeletingOfferDetail')
                                            ->where('status', '1')
                                            ->where('channel_id', 3)
                                            ->pluck('id')->toArray();
        if(!empty($shareSubscriptions)){
            OfferSubscription::whereIn('id', $shareSubscriptions)->update(['status' => '3']);
        }

        //Delete all subscriptions which does not belongs to any business
        $subUsers = OfferSubscription::groupBy('user_id')->pluck('user_id')->toArray();
        if(!empty($subUsers)){
            foreach($subUsers as $subUser){
                $user = User::where('id', $subUser)->where('status', 1)->first();
                if($user == null){
                    $userSubsIds = OfferSubscription::where('user_id', $subUser)->pluck('id')->toArray();
                    OfferSubscription::destroy($userSubsIds);
                }
            }
        }

    }
}
