<?php

namespace App\Jobs;

use App\Models\User;
use DateTimeImmutable;
use App\Models\Customer;
use App\Models\TimeSlot;
use App\Models\Userplan;
use App\Models\WhatsappPost;

use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\WhatsappSession;
use App\Models\BusinessCustomer;
use Illuminate\Support\Facades\Log;
use App\Models\MessageScheduleContact;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use DeductionHelper;

class SendWaMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $category_type;
    public $waScheduleMsg;
    // public $customer;
    // public $bus_customer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($category_type, $waScheduleMsg)
    {
        $this->category_type = $category_type;
        $this->waScheduleMsg = $waScheduleMsg;
        // $this->customer = $customer;
        // $this->bus_customer = $bus_customer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $manual = "";
        $response = $customer_ids = [];
        $shared_to = [];

        $last_scheduled_id = $this->waScheduleMsg->id;
        $attachmentUrl = '';

        $user_id = $this->waScheduleMsg->user_id;
        $userData = User::where('id', $user_id)->where('status', 1)->first();
        $access_token = $userData->wa_access_token ?? null;

        $businessDetail = BusinessDetail::where('user_id', $user_id)->first();
        $whatsappSession = WhatsappSession::where('user_id', $user_id)->first();

        $busniess_name = $schedule_date = '';
        
        if($userData != null && (isset($userData->wa_access_token) && $userData->wa_access_token != null)){
            if($businessDetail->business_name){
                $busniess_name = $businessDetail->business_name;
            }

            if($whatsappSession != null && (isset($whatsappSession->instance_id) && $whatsappSession->instance_id != '')){
                /* Birthday */
                if($this->category_type == 7){
                    $todays_date = date('j F');
                    $customer_ids = BusinessCustomer::where('user_id', $user_id)->where('dob', $todays_date)->pluck('customer_id')->toArray();
                    $manual = date('Y-m-d');
                    $manual .= " 09:00";
                    // dd($manual);
                    $schedule_date = date('Y-m-d H:i', strtotime($manual));
                }
                
                /* Anniversary */
                if($this->category_type == 8){
                    $todays_date = date('j F');
                    $customer_ids = BusinessCustomer::where('user_id', $user_id)->where('anniversary_date', $todays_date)->pluck('customer_id')->toArray();
                    $manual = date('Y-m-d');
                    $manual .= " 09:00";
                    
                    $schedule_date = date('Y-m-d H:i', strtotime($manual));
                }

                /* Custom Message */
                if($this->category_type=="other"){
                    $todays_date = date('j F');
                    $manual = date('Y-m-d');
                    $manual .= " ".date('H:i');
        
                    $s_time = '12:00:00';
                    $time_slot = TimeSlot::find($this->waScheduleMsg->time_slot_id);
                    if($time_slot != null){
                        $s_time = $time_slot->value;
                    }
                    $time_arr = explode(':', $time_slot->value);
        
                    $new_datetime = new DateTimeImmutable($this->waScheduleMsg->scheduled);
                    $scheduled_datetime = $new_datetime->setTime($time_arr[0], $time_arr[1], $time_arr[2]);
                    
                    $schedule_date = $scheduled_datetime->format("Y-m-d H:i:s");
        
                    $groups = explode(',', $this->waScheduleMsg->groups_id);
                    $grpCustomers = GroupCustomer::whereIn('contact_group_id', $groups)->groupBy('customer_id')->pluck('customer_id')->toArray();
                    $customer_ids = BusinessCustomer::with('getCustomerInfo')->whereIN('customer_id', $grpCustomers)->groupBy('customer_id')->pluck('customer_id')->toArray();
                }
                
                if(empty($customer_ids)){
                    if($this->category_type=="other"){
                        $currentScheduleMsg = MessageTemplateSchedule::where('id', $last_scheduled_id)->first();
                        $currentScheduleMsg->status = "route_inactive";
                        $currentScheduleMsg->save();
                    }
                }else{
                    $busniess_name = $busniess_name ?? 'business owner';
                    if(strlen($busniess_name) > 28){
                        $busniess_name = substr($busniess_name,0,28).'..';
                    }
                    
                    $message = $this->waScheduleMsg->template->message;
                    $message = str_replace("[business_name]", $busniess_name, $message);
                    $message = str_replace("{#var#}", $busniess_name, $message);
                    
                    $totalCustomers = count($customer_ids);
                    
                    $mobile_numbers = Customer::whereIn('id',$customer_ids)->pluck('mobile')->toArray();

                    $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                    $checkWalletBalance = DeductionHelper::checkWalletBalance($user_id, $deductionDetail->id ?? 0);

                    if($checkWalletBalance['status']==true){
                        if($businessDetail != null && $whatsappSession != NULL){
                            $today = date("YmdHis");
                            $contact_grp_id = $businessDetail->uuid.$today.$this->waScheduleMsg->id;
                            $whatsappPostModel = new WhatsappPost;
                            $contactGroup = $whatsappPostModel->createContactGroup($whatsappSession->instance_id, $contact_grp_id);
                            
                            if($contactGroup->status){
                                $team_id = $contactGroup->data->team_id;
                                $group_id = $contactGroup->data->group_id;
    
                                $updateContact = $whatsappPostModel->updateContact($team_id,$group_id,$mobile_numbers);
                                
                                if($updateContact->status){
                                    // $oneDialWhatsappPostSchedule =  $whatsappPostModel->checkProcessed($whatsappSession->instance_id);
    
                                    if($this->waScheduleMsg->oddek_schedule_id == NULL || in_array($this->waScheduleMsg->message_template_category_id, [7,8])){
                                        
                                        $scheduleCampaign = $whatsappPostModel->scheduleCampaign($team_id, $group_id, $whatsappSession->instance_id, $schedule_date, $message, 'd2c', $attachmentUrl);

                                        // dd($scheduleCampaign);
                                    
                                        if($scheduleCampaign->status==1){
                                            $messageTemplateSchedule = MessageTemplateSchedule::find($last_scheduled_id);
                                            $messageTemplateSchedule->oddek_schedule_id = $scheduleCampaign->data->last_schedule_id;
                                            $messageTemplateSchedule->save();
    
                                            // Manage History
                                            $this->saveMessageHistory($mobile_numbers, $user_id, $message);

                                            /* Store Customer Entry */
                                            foreach($customer_ids as $cust_id){
                                                $this->saveCustomerEntry($cust_id, $messageTemplateSchedule->id, $messageTemplateSchedule->user_id);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    else{
                        if($this->category_type=="other"){
                            $currentScheduleMsg = MessageTemplateSchedule::where('id', $last_scheduled_id)->first();
                            $currentScheduleMsg->status = "cancelled";
                            $currentScheduleMsg->customer_ids = implode(", ", $customer_ids);
                            $currentScheduleMsg->save();
                        }
                    }
                }
            }else{
                if($this->category_type=="other"){
                    $currentScheduleMsg = MessageTemplateSchedule::where('id', $last_scheduled_id)->first();
                    $currentScheduleMsg->status = "cancelled";
                    $currentScheduleMsg->save();
                }
            }
        }
    }


    public function saveCustomerEntry($customer_id = '', $message_id = '', $user_id = ''){
        $customer_entry = MessageScheduleContact::where('user_id', $user_id)->where('message_template_schedule_id', $message_id)->where('customer_id', $customer_id)->first();
        if($customer_entry == null){
            $customer_entry = new MessageScheduleContact;
            $customer_entry->user_id = $user_id;
            $customer_entry->message_template_schedule_id = $message_id;
            $customer_entry->customer_id = $customer_id;
            $customer_entry->save();
        }
    }


    public function saveMessageHistory($mobile_numbers = [], $user_id = '', $message = ''){
        if(!empty($mobile_numbers)){
            $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');

            foreach ($mobile_numbers as $mobileKey => $mobile) {
                if($this->category_type==7){
                    $related_to = 'Personalised DOB Messages';
                }
                else if($this->category_type==8){
                    $related_to = 'Personalised Aniversary Messages';
                }
                else{
                    $related_to = 'Personalised Other Messages';
                }

                $channel_id = 5;
                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, "91".$mobile, $message, $related_to, 'wa', 1);

                // Insert in Deduction History Table

                $customer = Customer::where('mobile', $mobile)->orderBy('id', 'desc')->first();
                
                // DeductionHelper::deductWalletBalance($user_id, $deductionDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
            }
        }
        
    }
}
