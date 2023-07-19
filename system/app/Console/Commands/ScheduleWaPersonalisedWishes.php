<?php

namespace App\Console\Commands;

use App\Models\Wish;
use App\Models\UserChannel;
use App\Models\MessageWallet;
use App\Jobs\SendWaMessageJob;
use Illuminate\Console\Command;
use App\Models\MessageTemplateSchedule;

class ScheduleWaPersonalisedWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:wapersonalisedwishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule whatsapp personalised wishes to whatsapp.';

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
        set_time_limit(0);
        
        $todays_date = date('Y-m-d');
        // $users = UserChannel::where('channel_id', 5)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();

        $users = MessageWallet::where('wallet_balance', '>', 0)->pluck('user_id')->toArray();

        /* Custom Messages */
        $cus_messageSchedules = MessageTemplateSchedule::whereNotIn('message_template_category_id', [7,8])->where('scheduled', date("Y-m-d"))->whereIn('user_id', $users)->where('status', 'queued')->get();
        // dd($cus_messageSchedules);
        // if(!empty($cus_messageSchedules)){
        //     foreach ($cus_messageSchedules as $key => $scheduleMsg){
                
        //         dispatch(new SendWaMessageJob('other', $scheduleMsg));

        //         /* Custom Messages */
        //         $schedule = MessageTemplateSchedule::find($scheduleMsg->id);
        //         $schedule->is_cron_schedule = 1;
        //         $schedule->save();
        //     }
        // }
// dd("End");
        /* Date Of Birth and Anniversary */

        $wishSendTodayIds = Wish::whereDate('created_at', date("Y-m-d"))->where('sent_via', 'wa')->groupBy('user_id')->pluck('user_id')->toArray();
        
        $users = array_diff($users,$wishSendTodayIds);
        
        $messageSchedules = MessageTemplateSchedule::whereIn('message_template_category_id', [7,8])->whereIn('user_id', $users)->get();
        
        if(!empty($messageSchedules)){
            // dd($messageSchedules);
            foreach ($messageSchedules as $key => $scheduleMsg){
                dispatch(new SendWaMessageJob($scheduleMsg->message_template_category_id, $scheduleMsg));
            }
        }

    }
}
