<?php

namespace App\Jobs;

use App\Models\UserChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendOtherWaMessageJob implements ShouldQueue
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
        // Log::debug("run check:otherswa WA SMS => SendOtherWaMessageJob => handle datetime: ".date('d-m-Y H:s:i'));


        set_time_limit(0);

        $category_type='other';
        $todays_date = date('Y-m-d');

        $users = UserChannel::where('channel_id', 5)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();
        $messageSchedule = MessageTemplateSchedule::whereIn('user_id', $users)
                        ->whereChannelId(5)
                        ->whereNotNull('scheduled')
                        ->whereDate('scheduled', $todays_date)
                        ->where('is_cron_schedule', 0)
                        // ->whereNotIn('message_template_category_id', [7, 8])
                        ->get();

        // dd($messageSchedule);        
        if($messageSchedule!=Null){
            foreach ($messageSchedule as $key => $scheduleMsg){
                $schedule = MessageTemplateSchedule::find($scheduleMsg->id);
                $schedule->is_cron_schedule = 1;
                $schedule->save();

                dispatch(new \App\Jobs\SendWaMessageJob($category_type, $scheduleMsg));
            }
        }
        
    }
}
