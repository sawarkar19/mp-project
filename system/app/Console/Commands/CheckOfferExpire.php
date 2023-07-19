<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Offer;
use App\Models\OfferSubscription;
use Carbon\Carbon;
use DB;

class CheckOfferExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:offerexpire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check the users subscription plan expiry date and match to offer subscription and status is pending.';

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
        dispatch(new \App\Jobs\OfferExpireJob());
    }
}
