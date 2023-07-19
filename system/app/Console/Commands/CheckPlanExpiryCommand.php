<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\UserChannel;
use App\Jobs\TodayExpiryJob;
use App\Jobs\OneDayExpiryJob;
use App\Jobs\FiveDayExpiryJob;
use App\Jobs\SevenDayExpiryJob;
use App\Jobs\ThreeDayExpiryJob;
use Illuminate\Console\Command;
use App\Jobs\YesterdayExpiryJob;

class CheckPlanExpiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:planexpiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform all checks for Plan Expiry.';

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
        $after_seven_day = Carbon::now()->addDay(7)->format('Y-m-d');
        $before_one_day = Carbon::now()->subDay(1)->format('Y-m-d');

        /* Active Plan User IDs */
        $usersPlans = UserChannel::with('userDetail')->has('userDetail')->where('channel_id', 2)->whereBetween('will_expire_on', [$before_one_day, $after_seven_day])->get();

        if(!empty($usersPlans)){
            
            foreach($usersPlans as $plan){

                /* 7 Days pending */
                if($plan->will_expire_on == $after_seven_day){
                    dispatch(new SevenDayExpiryJob($plan->userDetail));
                }

                /* 5 Days pending */
                $after_five_day = Carbon::now()->addDay(5)->format('Y-m-d');
                if($plan->will_expire_on == $after_five_day){
                    dispatch(new FiveDayExpiryJob($plan->userDetail));
                }

                /* 3 Days pending */
                $after_three_day = Carbon::now()->addDay(3)->format('Y-m-d');
                if($plan->will_expire_on == $after_three_day){
                    dispatch(new ThreeDayExpiryJob($plan->userDetail));
                }

                /* 1 Days pending */
                $after_one_day = Carbon::now()->addDay(1)->format('Y-m-d');
                if($plan->will_expire_on == $after_one_day){
                    dispatch(new OneDayExpiryJob($plan->userDetail));
                }

                /* Today */
                $today = Carbon::now()->format('Y-m-d');
                if($plan->will_expire_on == $today){
                    dispatch(new TodayExpiryJob($plan->userDetail));
                }

                /* Yesterday */
                if($plan->will_expire_on == $before_one_day){
                    dispatch(new YesterdayExpiryJob($plan->userDetail));
                }

            }
        }
    }
}
