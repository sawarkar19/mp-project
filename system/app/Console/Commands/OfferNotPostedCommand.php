<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Offer;
use App\Jobs\OfferNotPostedJob;
use Illuminate\Console\Command;

class OfferNotPostedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:offernotposted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the business that there offer is not posted to social media';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now()->format('Y-m-d');

        /* Offer Started Today */
        $offers = Offer::with(['user', 'instant_tasks'])->has('user')->where('start_date', $today)->whereNull('stop_date')->get();

        if(!empty($offers)){
            foreach($offers as $offer){
                
                if(count($offer->instant_tasks) == 0){
                    dispatch(new OfferNotPostedJob($offer));
                }
            }
        }


        /* Offer started 7 days ago but still not posted */

        $six_days_before = Carbon::now()->subDay(6)->format('Y-m-d');

        $oldOffers = Offer::with(['user', 'instant_tasks'])->has('user')->where('start_date', $six_days_before)->where('end_date', '>=', $today)->whereNull('stop_date')->get();

        if(!empty($oldOffers)){
            foreach($oldOffers as $oldOffer){
                
                if(count($oldOffer->instant_tasks) == 0){
                    dispatch(new OfferNotPostedJob($oldOffer));
                }
            }
        }

        // dd($oldOffers);
    }
}
