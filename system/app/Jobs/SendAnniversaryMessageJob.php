<?php

namespace App\Jobs;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\EmailJob;
use App\Models\Userplan;

use App\Models\UserChannel;
use App\Models\MessageRoute;
use App\Models\UserRecharge;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\WhatsappSession;
use App\Models\BusinessCustomer;
use App\Models\WhatsappTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Business\CommonSettingController;

class SendAnniversaryMessageJob implements ShouldQueue
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
        // Log::debug("run check:anniversaries sms => SendAnniversaryMessageJob => handle  datetime: ".date('d-m-Y H:s:i'));

        $todays_date = date('Y-m-d');
        $users = UserChannel::where('channel_id', 5)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();

        $messageSchedule = MessageTemplateSchedule::whereIn('user_id', $users)->whereChannelId(5)->whereMessageTemplateCategoryId(8)->whereIsScheduled(1)->get();
        
        // Log::debug("run check:anniversaries sms => SendAnniversaryMessageJob => get schedule message  datetime: ".date('d-m-Y H:s:i'));

        if($messageSchedule!=Null){
            app('App\Http\Controllers\Business\PersonalisedMessageController')->sendMessage($messageSchedule, 'aniversary');
        }
    }

    
	
}
