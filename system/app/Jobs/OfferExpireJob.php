<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Offer;
use App\Models\OfferSubscription;
use Carbon\Carbon;
use DB;


class OfferExpireJob implements ShouldQueue
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
        // Log::debug("run check:offerexpire => OfferExpireJob => handle datetime: ".date('d-m-Y H:s:i'));

        $todays_date = date('Y-m-d');
        $offers = Offer::where('end_date', '<', $todays_date)->pluck('id')->toArray();
        
        foreach ($offers as $key => $offer) {
            
            $offer_subscription = OfferSubscription::where('offer_id', $offer)->where('status', '1')->pluck('id')->toArray();
            if (count($offer_subscription) > 0) { 
                $update_offer_subscription = OfferSubscription::whereIn('id', $offer_subscription)
                ->update(['status' => '3']);
            }
        }
    }  
}
