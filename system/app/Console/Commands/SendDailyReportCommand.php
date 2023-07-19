<?php

namespace App\Console\Commands;

use App\Models\UserChannel;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use Illuminate\Console\Command;
use App\Jobs\SendDailyReportJob;

class SendDailyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:dailyreportstobussiness';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily statistics to business.';

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

        $today = date("Y-m-d");

        $currentHour = \Carbon\Carbon::now()->format('G');


        $usersIds = BusinessDetail::where('daily_reporting_time', $currentHour.'.00')->pluck('user_id')->toArray();

        if(!empty($usersIds)){
            foreach($usersIds as $usersId){
                dispatch(new SendDailyReportJob($usersId));
            }
        }
    }
}
