<?php

namespace App\Jobs;

use App\Models\Offer;
use Illuminate\Bus\Queueable;
use App\Models\OfferSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class MarkSubscriptionExpiredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $activeUsersIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($activeUsersIds)
    {
        $this->activeUsersIds = $activeUsersIds;
    }

    /** 
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $today = date("Y-m-d");
        $expiredOfferIds = Offer::whereIn('user_id', $this->activeUsersIds)->where('end_date', '<', $today)->pluck('id')->toArray();

        $subscriptions = OfferSubscription::whereIn('offer_id', $expiredOfferIds)->update(['status' => '3']);
        
    }
}
