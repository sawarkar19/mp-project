<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Wish;
use DeductionHelper;
use App\Models\Option;
use App\Models\Deduction;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Models\MessageHistory;

use App\Models\BusinessCustomer;
use App\Models\DeductionHistory;
use Illuminate\Support\Facades\Log;
use App\Jobs\PersonaliseSMSFailedJob;
use App\Jobs\PersonaliseWalletLowJob;

use App\Models\MessageScheduleContact;
use Illuminate\Queue\SerializesModels;

use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendCustomSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;
    public $smsusername;
    public $smspassword;
    public $sendername;
    public $smsurl;
    public $smsoptions;
    public $customerIds;
    public $businessCustomerIds;
    public $mobileNos;
    public $mobileSuccessNos;
    public $mobileFailedNos;
    public $mobileSuccessIds;
    public $mobileFailedIds;
    public $contact;
    public $messageTemplateSchedule;
    public $deductionDetail;
    public $contactIds;

    public function __construct($data)
    { 
        $this->data = $data;

        $this->smsoptions=Option::where('key','sms_gateway')->first();
        $this->smsurl=json_decode($this->smsoptions->value)->url."/SMS_API/sendsms.php";

        $this->smsusername = json_decode($this->smsoptions->value)->username;
        $this->smspassword = json_decode($this->smsoptions->value)->password;
        $this->sendername = json_decode($this->smsoptions->value)->sendername;

        $this->customerIds = $this->businessCustomerIds = $this->mobileNos = $this->mobileSuccessNos = $this->mobileFailedNos = $this->mobileSuccessIds = $this->mobileFailedIds = $this->contact = $this->contactIds = [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $this->deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

        if($this->deductionDetail != NULL){

            $this->contact = [
                'username' => $this->smsusername,
                'password' => $this->smspassword,
                'sendername' => $this->sendername,
                'message' => $this->data[0]['message'],
                'routetype' => 1,
                'user_id'=> $this->data[0]['user_id'],
                'channel_id'=> $this->data[0]['channel_id'],
                'schedule_id'=> $this->data[0]['schedule_id'],
                'status'=> $this->data[0]['status'],
                'type' => $this->data[0]['type']
            ];

            $this->messageTemplateSchedule = MessageTemplateSchedule::where('id', $this->contact['schedule_id'])->first();

            $checkWalletBalance = DeductionHelper::checkWalletBalance($this->contact['user_id'], $this->deductionDetail->id ?? 0);
            $checkWallet = DeductionHelper::getUserWalletBalance($this->contact['user_id']);
    
            $balance = $checkWallet['wallet_balance'];

            $mobiles = '';
            foreach ($this->data as $key => $value) {

                $businessCustomer = BusinessCustomer::where('user_id', $value['user_id'])->where('customer_id', $value['customer_id'])->first();

                if($businessCustomer == null){
                    $businessCustomerId = 0;
                }else{
                    $businessCustomerId = $businessCustomer->id;
                }

                if(($balance - $this->deductionDetail->amount) > 0){
                    if($mobiles == ''){
                        $mobiles = $value['mobile'];
                    }else{
                        $mobiles .= ','.$value['mobile'];
                    }   

                    $balance = $balance - $this->deductionDetail->amount;

                    $this->mobileSuccessIds[$value['mobile']] = $value['customer_id'];
                    $this->mobileSuccessNos[$value['customer_id']] = $value['mobile'];
                }else{
                    $this->mobileFailedIds[$value['mobile']] = $value['customer_id'];
                    $this->mobileFailedNos[$value['customer_id']] = $value['mobile'];
                }

                $this->mobileNos[$value['customer_id']] = $value['mobile'];
                $this->contactIds[$value['customer_id']] = isset($value['contact_id']) ? $value['contact_id'] : '';
                $this->customerIds[$value['mobile']] = $value['customer_id'];

                $this->businessCustomerIds[$value['customer_id']] = $businessCustomerId;
                    
            }

            $this->contact['mobile'] = $mobiles;

            if(!empty($this->mobileFailedIds)){
                $user = User::find($this->contact['user_id']);
                dispatch(new PersonaliseWalletLowJob($user));
            }
        }
        
        $this->sendBulkSMS($this->contact);

    }

    public function sendBulkSMS($contactData = []){

        if(!empty($this->mobileNos)){
            if(!empty($contactData))
            {
                
                //init the resource
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $this->smsurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $contactData
                    //,CURLOPT_FOLLOWLOCATION => true
                ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //Get response
                $output = curl_exec($ch);

                if(curl_errno($ch)) {  

                    //Message not sent
                    foreach($this->mobileSuccessIds as $customerId){
                        $contactDataData = [
                            'user_id' => $contactData['user_id'],
                            'customer_id' => $customerId,
                            'schedule_id' => $contactData['schedule_id'],
                            'business_customer_id' => $this->businessCustomerIds[$customerId],
                            'sms_send' => '0',
                            'contact_id' => isset($this->contactIds[$customerId]) ? $this->contactIds[$customerId] : '',
                        ];

                        /* Store Customer Message  Entry */
                        $this->saveCustomerEntry($contactDataData, $this->messageTemplateSchedule);
                    }
                        
                }else{    

                    foreach($this->mobileSuccessIds as $customerId){
                        $contactDataData = [
                            'user_id' => $contactData['user_id'],
                            'customer_id' => $customerId,
                            'schedule_id' => $contactData['schedule_id'],
                            'business_customer_id' => $this->businessCustomerIds[$customerId],
                            'sms_send' => '1',
                            'contact_id' => isset($this->contactIds[$customerId]) ? $this->contactIds[$customerId] : '',
                        ];

                        /* Store Customer contact  Entry */
                        $this->saveCustomerEntry($contactDataData, $this->messageTemplateSchedule);

                        $related_to = 'Personalised Message';
                        
                        if($this->messageTemplateSchedule->message_template_category_id == 7){
                            $related_to = 'Personalised DOB Messages';
                        }
                        
                        if($this->messageTemplateSchedule->message_template_category_id == 8){
                            $related_to = 'Personalised Aniversary Messages';
                        }
                
                        $messageHistory_id = DeductionHelper::setMessageHistory($contactData['user_id'], $contactData['channel_id'], $this->mobileNos[$customerId], $contactData['message'], $related_to, 'sms', 1);
                        
                        DeductionHelper::deductWalletBalance($contactData['user_id'], $this->deductionDetail->id ?? 0, $contactData['channel_id'], $messageHistory_id, $customerId, 0);

                        /* Update Message Schedule */
                        if(@$this->messageTemplateSchedule->customer_ids == NULL){ 
                            $this->messageTemplateSchedule->customer_ids = $customerId;
                        }
                        else{ 
                            if(!strpos($this->messageTemplateSchedule->customer_ids, $customerId)){
                                $this->messageTemplateSchedule->customer_ids = $this->messageTemplateSchedule->customer_ids.", ".$customerId;
                            }  
                        }
                    }

                    if(!empty($this->mobileSuccessNos)){
                        $this->messageTemplateSchedule->sms_status = 'delivered';
                    }

                    $this->messageTemplateSchedule->save();
                }
                
                curl_close($ch);
            }
        }

        if(!empty($this->mobileFailedIds)){
            foreach($this->mobileFailedIds as $customerId){
                $contactDataData = [
                    'user_id' => $contactData['user_id'],
                    'customer_id' => $customerId,
                    'schedule_id' => $contactData['schedule_id'],
                    'business_customer_id' => $this->businessCustomerIds[$customerId],
                    'sms_send' => '0',
                    'contact_id' => isset($this->contactIds[$customerId]) ? $this->contactIds[$customerId] : '',
                ];

                /* Store Customer contact  Entry */
                $this->saveCustomerEntry($contactDataData, $this->messageTemplateSchedule);
            }
        }
        
    }

    /**
     * Save Customer contact Entry
     */
    public function saveCustomerEntry($data, $messageTemplateSchedule){
        
        if(isset($data['contact_id']) && $data['contact_id'] != ''){
            $customer_entry = MessageScheduleContact::find($data['contact_id']);
        }else{
            $customer_entry = new MessageScheduleContact;
        }
        
        $customer_entry->user_id = $data['user_id'];
        $customer_entry->status = $data['sms_send'];
        $customer_entry->message_template_schedule_id = $messageTemplateSchedule->id;
        $customer_entry->customer_id = $data['customer_id'];
        $customer_entry->save();
    }

}
