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
use DB;

class SendOtherMessageJob implements ShouldQueue
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
        // Log::debug("run check:othermsgs SMS => SendOtherMessageJob => handle datetime: ".date('d-m-Y H:s:i'));

        $todays_date = date('Y-m-d');

        $todays_datetime = \Carbon\Carbon::now();
        $todays_datetime = $todays_datetime->addMinutes(15)->format('Y-m-d H:i:s');

        $users = UserChannel::where('channel_id', 5)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();
        
        // DB::enableQueryLog();
        $messageSchedule = MessageTemplateSchedule::whereIn('user_id',$users)
                            ->whereChannelId(5)
                            ->whereNotNull('scheduled')
                            ->whereDate('scheduled', $todays_date)
                            ->where('scheduled', '<', $todays_datetime)
                            ->whereNotIn('message_template_category_id', [7, 8]
                            )->where('sms_status', 'queued')->get();

        // dd(DB::getQueryLog(), $messageSchedule, $todays_date, $todays_datetime);
        
        if($messageSchedule!=Null){
            app('App\Http\Controllers\Business\PersonalisedMessageController')->sendMessage($messageSchedule, 'otherMsg');
        }
    }
}
