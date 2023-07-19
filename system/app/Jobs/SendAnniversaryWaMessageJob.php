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

class SendAnniversaryWaMessageJob implements ShouldQueue
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
        // Log::debug("run check:anniversarieswa WA SMS => handle datetime: ".date('d-m-Y H:s:i'));

        set_time_limit(0);
        $category_type = 8;

        $todays_date = date('Y-m-d');
        $users = UserChannel::where('channel_id', 5)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();

        $messageSchedule = MessageTemplateSchedule::whereIn('user_id', $users)->whereChannelId(5)->whereMessageTemplateCategoryId($category_type)->whereIsScheduled(1)->where('status', 'queued')->get();
        
        // Log::debug("run check:anniversarieswa WA SMS => get message schedule datetime: ".date('d-m-Y H:s:i'));
        
        if($messageSchedule!=Null){
            foreach ($messageSchedule as $key => $scheduleMsg){
                // echo "\n ".$scheduleMsg->user_id."\n customer "; print_r(@$scheduleMsg->getUserDetails->getCustomers);
                // foreach (@$scheduleMsg->getUserDetails->getCustomers as $cusKey => $customer){
                //     $busCustomer = $customer->getDobBusinessCustomer;
                    // dispatch(new \App\Jobs\SendWaMessageJob($category_type, $scheduleMsg, $customer, $busCustomer));
                    dispatch(new \App\Jobs\SendWaMessageJob($category_type, $scheduleMsg));
                // }
            }
        }
    }
}
