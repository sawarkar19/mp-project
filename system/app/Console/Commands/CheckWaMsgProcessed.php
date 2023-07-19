<?php

namespace App\Console\Commands;

use Carbon\Carbon;

use App\Models\User;

use App\Models\Option;
use App\Models\WhatsappPost;
use App\Models\WhatsappSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\WACloudApiController;

use App\Models\Wish;
use App\Models\Customer;
use App\Models\BusinessCustomer;

class CheckWaMsgProcessed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:wamsgprocessed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check status of schedule whatsapp messages.';

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
    public function handle(WhatsappPost $whatsappPost)
    {

        $checkProcessed = $whatsappPost->checkProcessed();
        // dd($checkProcessed);

        if($checkProcessed->status){
            $totalSent = 0;
            $totalFailed = 0;
		    $statistics = [];

            if(isset($checkProcessed->data) && !empty($checkProcessed->data)){
                $sr=1;
                foreach($checkProcessed->data as $data){
                    
                    $messageTemplateSchedule = MessageTemplateSchedule::where('oddek_schedule_id', $data->id)->first();

                    if($messageTemplateSchedule == null){
                        continue;
                    }else{

                        if($data->status == '2'){
                            $messageTemplateSchedule::where('oddek_schedule_id', $data->id)->update([
                                'send'=> $data->sent,
                                'failed'=> $data->failed,
                                'status'=> 'delivered',
                                'delivered_numbers' => $data->result,
                            ]);
                        }else{

                            $time_post = $data->time_post;
                            $startTime = Carbon::now();
                            $endTime = Carbon::parse(date('Y-m-d h:i a',$time_post));
                            $totalDurationRemains = $endTime->diffInMinutes($startTime);

                            if($totalDurationRemains <= 2){

                                $user = User::where('id', $messageTemplateSchedule->user_id)->where('status', 1)->first(); 
                                $instance = WhatsappSession::where('user_id', $messageTemplateSchedule->user_id)->select('instance_id')->orderBy('id', 'desc')->first(); 

                                if($user != null && $instance != null && $instance->instance_id == null){
                                    $messageTemplateSchedule::where('oddek_schedule_id', $data->id)->update([
                                        'send'=> $data->sent,
                                        'failed'=> $data->failed,
                                        'status'=> 'failed',
                                        'delivered_numbers' => $data->result,
                                    ]);
                                }
                            }else{
                                $messageTemplateSchedule::where('oddek_schedule_id', $data->id)->update([
                                    'send'=> $data->sent,
                                    'failed'=> $data->failed,
                                    'status'=> 'processing',
                                    'delivered_numbers' => $data->result,
                                ]);
                            }
                        }



                        /* Birthday and Anniversary */
                        $message_template_category_id = $messageTemplateSchedule->message_template_category_id;
                        if($message_template_category_id==7 || $message_template_category_id==8){

                            $customerWaMobileNos = json_decode($data->result);
                            // $checkFailed = (int)$data->failed;
                            
                            foreach ($customerWaMobileNos as $cusKey => $custMobile) {
                                $this->updateDobAndAnniversaryContacts($custMobile, $message_template_category_id, $messageTemplateSchedule, 1);
                            }
                        }else{
                            if($data->result != null){
                                $customerWaMobileNos = json_decode($data->result);
                                // $checkFailed = (int)$data->failed;
                                $customerIds = '';
                                foreach ($customerWaMobileNos as $cusKey => $custMobile) {
                                    $mobile = substr($custMobile, 2);
                                    $customer = Customer::where('mobile', $mobile)->first();
                                    if($customer != null){
                                        if($customerIds != ''){
                                            $customerIds .= ','.$customer->id;
                                        }else{
                                            $customerIds = $customer->id;
                                        }
                                    }
                                }

                                $messageTemplateSchedule::where('oddek_schedule_id', $data->id)->update([
                                    'customer_ids_wa'=> $customerIds
                                ]);
                            }
                            
                        }
                    }
                    
                }
            }
        }

        // return 0;
    }

    public function updateDobAndAnniversaryContacts($mobile, $msg_temp_cat_id, $messageTemplateSchedule, $is_sms_send=0)
    {

        $todayDate = Carbon::now()->format("Y-m-d");
        $mobile = substr($mobile, 2);
        $customerDetail = Customer::where('mobile', $mobile)->latest()->first();
        // dd($customerDetail);
        if($customerDetail!=NULL){
            $businessCustomer=BusinessCustomer::where('user_id', $messageTemplateSchedule->user_id)->where('customer_id', $customerDetail->id)->first();

            $wishDobAndAnn = Wish::whereDate('created_at', $todayDate)->where('message_template_category_id', $msg_temp_cat_id)->where('business_customer_id', $businessCustomer->id)->where('sent_via', 'wa')->first();
            // dd($wishDobAndAnn);
            
            if($wishDobAndAnn==NULL && $businessCustomer != null){

                $wishDobAndAnn = new Wish;
                $wishDobAndAnn->user_id = $messageTemplateSchedule->user_id;
                $wishDobAndAnn->message_template_schedule_id = $messageTemplateSchedule->id;
                $wishDobAndAnn->oddek_schedule_id = $messageTemplateSchedule->oddek_schedule_id;
                $wishDobAndAnn->message_template_category_id = $messageTemplateSchedule->message_template_category_id;
                $wishDobAndAnn->business_customer_id = $businessCustomer->id;
                $wishDobAndAnn->template_id = $messageTemplateSchedule->template_id;
                $wishDobAndAnn->sent_via = "wa";
                $wishDobAndAnn->sms_send = $is_sms_send;
                $wishDobAndAnn->save();
            }
        }
    }
}
