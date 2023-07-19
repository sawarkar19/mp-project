<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Customer;
use App\Models\EmailJob;
use App\Models\Userplan;
use App\Models\UserRecharge;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\WhatsappSession;
use App\Models\BusinessCustomer;
use App\Models\WhatsappTemplate;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Controllers\Business\CommonSettingController;

class SendFestivalMessageJob implements ShouldQueue
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
        // Log::debug("run check:festivals => SendFestivalMessageJob => handle datetime: ".date('d-m-Y H:s:i'));

        $templates = WhatsappTemplate::where('template_type','festival')->where('send_wish','1')->where('festival_date',Carbon::now()->format('Y-m-d'))->get();
		
        $data = array();

        if(!empty($templates)){

            foreach ($templates as $template) { //echo ' User => '.$template->user_id .' ';
                $session = WhatsappSession::where('user_id', $template->user_id)->orderBy('id', 'desc')->select('instance_id')->first();
                $user = User::where('id', $template->user_id)->select('wa_access_token')->where('status', 1)->orderBy('id', 'desc')->first();

                if($session != '' && $user != ''){

                    $customer_ids =  BusinessCustomer::where('business_customers.business_id',$template->user_id)->pluck('business_customers.customer_id')->toArray();
					
					$data = CommonSettingController::checkSendFlag($template->user_id,8);
					$data['template'] = $template;
					$data['session'] = $session;
					$data['user'] = $user;
					
					if($data['sendFlag']){
						CommonSettingController::proceedMessages($customer_ids,$data);
					}

                }
                
            }

        }

    }
}
