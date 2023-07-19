<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Offer;
use App\Jobs\OfferNotPostedJob;
use App\Jobs\OfferNotSharedJob;
use Illuminate\Console\Command;

class OfferNotSharedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:offernotshared';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the business that there offer is posted and they should start sharing.';

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
        $offers = Offer::with(['user', 'subscriptions'])->has('user')->where('start_date', $today)->whereNull('stop_date')->get();

        if(!empty($offers)){
            foreach($offers as $offer){
                
                if(count($offer->subscriptions) == 0){
                    dispatch(new OfferNotSharedJob($offer));
                }
            }
        }
    }
}
