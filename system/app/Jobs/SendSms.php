<?php

namespace App\Jobs;

use App\Models\Wish;
use App\Models\User;
use DeductionHelper;
use App\Models\Option;
use App\Models\Deduction;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use App\Jobs\PersonaliseSMSFailedJob;

use App\Models\MessageHistory;
use App\Models\BusinessCustomer;
use App\Models\DeductionHistory;
use Illuminate\Support\Facades\Log;
use App\Models\MessageScheduleContact;

use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendSms implements ShouldQueue
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
    public $cond;

    public function __construct($data)
    { 
        $this->data = $data;

        $this->smsoptions=Option::where('key','sms_gateway')->first();
        $this->smsurl=json_decode($this->smsoptions->value)->url."/SMS_API/sendsms.php";

        $this->smsusername = json_decode($this->smsoptions->value)->username;
        $this->smspassword = json_decode($this->smsoptions->value)->password;
        $this->sendername = json_decode($this->smsoptions->value)->sendername;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $postData = [];
        $postDaVal = $postDaFailVal = $postDataVal = [];   
        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

        if($deductionDetail != NULL){
            foreach ($this->data as $key => $value) {
                $businessCustomer = BusinessCustomer::where('user_id', $value['user_id'])->where('customer_id', $value['customer_id'])->first();

                if($businessCustomer == null){
                    $businessCustomerId = 0;
                }else{
                    $businessCustomerId = $businessCustomer->id;
                }

                $postData[] = array(
                    'username' => $this->smsusername,
                    'password' => $this->smspassword,
                    'customer_id'=>$value['customer_id'],
                    'mobile' => $value['mobile'],
                    'sendername' => $this->sendername,
                    'message' => $value['message'],
                    'routetype' => 1,
                    'user_id'=>$value['user_id'],
                    'channel_id'=>$value['channel_id'],
                    'schedule_id'=>$value['schedule_id'],
                    'status'=>$value['status'],
                    'type'=>$value['type'],
                    'wish_id'=>(isset($value['wish_id']))?$value['wish_id']:0,
                    'business_customer_id' => $businessCustomerId,
                );

                if(isset($value['cond']) && $value['cond'] == 'resend') {
                    $this->cond = $value['cond'];
                }else{
                    $this->cond = 'send';
                }
                    
            }
        }

        
        
        $mobiles  = [];
        foreach ($postData as $key => $postDa) {
            /* Message Check */
            $checkWalletBalance = DeductionHelper::checkWalletBalance($postDa['user_id'], $deductionDetail->id ?? 0);
            $checkWallet = DeductionHelper::getUserWalletBalance($postDa['user_id']);

            if ($checkWalletBalance['status'] == false && $checkWallet['status']==true && $checkWallet['wallet_balance'] < $deductionDetail->amount) {    
                // SMS Not Sent 
                
                $postDaFailVal[] = $postDa;
            }
            else{ 
                if(empty($mobiles[$postDa['user_id']])){
                    $mobiles[$postDa['user_id']] = $postDa['mobile'];
                }else{
                    $mobiles[$postDa['user_id']] = $mobiles[$postDa['user_id']].",".$postDa['mobile'];
                }

                $postDaVal[$postDa['user_id']] = [
                    'username' => $this->smsusername,
                    'password' => $this->smspassword,
                    'mobile' => $mobiles[$postDa['user_id']],
                    'customer_id' => $postDa['customer_id'],
                    'user_id' => $postDa['user_id'],
                    'sendername' => $this->sendername,
                    'message' => $postDa['message'],
                    'routetype' => 1,
                    'key'       => $key
                ];
                $postDataVal[] = $postDa;

                
                if($postDa['type']=="dob"){
                    $related_to = 'Personalised DOB Messages';
                }
                else if($postDa['type']=="aniversary"){
                    $related_to = 'Personalised Aniversary Messages';
                }
                else {
                    $related_to = 'Personalised Other Messages';
                }

                $messageHistory_id = DeductionHelper::setMessageHistory($postDa['user_id'], $postDa['channel_id'], $postDa['mobile'], $postDa['message'], $related_to, 'sms', 1);
                //**  Insert in Deduction History Table */
                DeductionHelper::deductWalletBalance($postDa['user_id'], $deductionDetail->id ?? 0, $postDa['channel_id'], $messageHistory_id, $postDa['customer_id'], 0);
            }
        }

        $this->sendBulkSMS($postDaVal, $postDataVal, $postData);
        $this->failSMS($postDaFailVal);
    }

    public function failSMS($postDa = []){
        $check = 0;
        // Not Send SMS
        foreach($postDa as $fkey => $fval)
        {
            $messageTemplateSchedule = MessageTemplateSchedule::where('id', $fval['schedule_id'])->first();
            if($fval['type']=="otherMsg"){

                if($this->cond != 'resend') 
                {
                    $messageTemplateSchedule->sms_failed = $messageTemplateSchedule->sms_failed + 1;
                }
                $messageTemplateSchedule->save();
                
            }else{
                $fval['sms_send'] = 0; 
                /* Update Or Create Wish Entry */
                $this->saveCustomerWishEntry($fval, $messageTemplateSchedule);    
            }
            $check = 1;
            /* Store Customer Entry */
            $this->saveCustomerEntry($fval['customer_id'], $messageTemplateSchedule->id, $messageTemplateSchedule->user_id,'0', $this->cond);
        }
        
        if(!empty($check))
        {
            $user = User::find($postDa[0]['user_id']);
            dispatch(new PersonaliseSMSFailedJob($user));
        }
    }

    public function sendBulkSMS($postDa = [], $successDa = [], $postData = []){
        
        if(!empty(count($postDa)))
        {

            foreach($successDa as $skey => $sval)
            {

                //init the resource
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $this->smsurl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postDa[$sval['user_id']]
                    //,CURLOPT_FOLLOWLOCATION => true
                ));

                //Ignore SSL certificate verification
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                //Get response
                $output = curl_exec($ch);
                
                $messageTemplateSchedule = MessageTemplateSchedule::where('id', $sval['schedule_id'])->first();
                
                /** Print error if any **/

                if(curl_errno($ch)) {  
                    // Update SMS_SEND
                    if($this->cond != 'resend') 
                    {
                        $messageTemplateSchedule->sms_failed = $messageTemplateSchedule->sms_failed + 1;
                    }

                    if($sval['type'] != "otherMsg"){
                        
                        $sval['sms_send'] = 0; 
                        /* Store Customer Wish  Entry */
                        $this->saveCustomerWishEntry($sval, $messageTemplateSchedule);

                        /* Store Customer Entry */
                        $this->saveCustomerEntry($sval['customer_id'], $messageTemplateSchedule->id, $messageTemplateSchedule->user_id,'1');
                    }else{
                        
                        /* Store Customer Entry */
                        $this->saveCustomerEntry($sval['customer_id'], $messageTemplateSchedule->id, $messageTemplateSchedule->user_id,'1',$this->cond);
                    }
                    // return curl_error($ch);
                     
                }else{    
                    
                    
                    $messageTemplateSchedule->sms_send = $messageTemplateSchedule->sms_send + 1;
                    if($this->cond == 'resend'){ 
                        $messageTemplateSchedule->sms_failed = $messageTemplateSchedule->sms_failed - 1;
        
                    
                        if($sval['type']=="dob"){
                            $related_to = 'Personalised DOB Messages';
                        }
                        else if($sval['type']=="aniversary"){
                            $related_to = 'Personalised Aniversary Messages';
                        }
                        else {
                            $related_to = 'Personalised Other Messages';
                        }
                    }
                    
                    if($sval['type']=="otherMsg"){

                        
                        if($messageTemplateSchedule!=NULL){

                            /* Update Customer IDS */
                            if(@$messageTemplateSchedule->customer_ids==NULL){ 
                                $messageTemplateSchedule->customer_ids = $sval['customer_id'];
                            }
                            else{ 
                                if(!strpos($messageTemplateSchedule->customer_ids, $sval['customer_id'])){
                                    $messageTemplateSchedule->customer_ids = $messageTemplateSchedule->customer_ids.", ".$sval['customer_id'];
                                }  
                            }

                            //* messageTemplateSchedule is not delivered when some sms fail */

                            if(count($postData) == ($postDa[$sval['user_id']]['key'] + 1)){
                                $messageTemplateSchedule->sms_status = 'delivered';
                            }
                    
                            $messageTemplateSchedule->save();
                        }
                        
                        /* Store Customer Entry */
                        $this->saveCustomerEntry($sval['customer_id'], $messageTemplateSchedule->id, $messageTemplateSchedule->user_id,'1',$this->cond);

                        
                    }
                    else{
                        
                        $sval['sms_send'] = 1; 
                        /* Store Customer Wish  Entry */
                        $this->saveCustomerWishEntry($sval, $messageTemplateSchedule);
                        
                        /* Store Customer Entry */
                        $this->saveCustomerEntry($sval['customer_id'], $messageTemplateSchedule->id, $messageTemplateSchedule->user_id,'1');

                        
                    }
                }
                $messageTemplateSchedule->save();
            }
            curl_close($ch);

            
        }
    }

    /**
     * Save Customer Wish Entry
     */
    public function saveCustomerWishEntry($data, $messageTemplateSchedule){
        if($this->cond == 'resend')
            $wish_entry = Wish::find($data['wish_id']);
        else
            $wish_entry = new Wish;
        
        $wish_entry->user_id = $data['user_id'];
        $wish_entry->message_template_schedule_id = $data['schedule_id'];
        $wish_entry->message_template_category_id = $messageTemplateSchedule->message_template_category_id;
        $wish_entry->business_customer_id = $data['business_customer_id'];
        $wish_entry->template_id = $messageTemplateSchedule->template_id;
        $wish_entry->sent_via = "sms";
        $wish_entry->sms_send = $data['sms_send'];
        $wish_entry->save();
    }

    /**
     * Save Customer Entry
     */
    public function saveCustomerEntry($customer_id = '', $message_id = '', $user_id = '', $status = '1', $cond = '' ){
        
        $customer_entry = MessageScheduleContact::where('user_id', $user_id)->where('message_template_schedule_id', $message_id)->where('customer_id', $customer_id)->first();
        
        if($customer_entry == null){
            $customer_entry = new MessageScheduleContact;
            $customer_entry->user_id = $user_id;
            $customer_entry->status = $status;
            $customer_entry->message_template_schedule_id = $message_id;
            $customer_entry->customer_id = $customer_id;
            $customer_entry->save();
        }else{
            if($cond == 'resend')
            {
                $customer_entry->user_id = $user_id;
                $customer_entry->status = $status;
                $customer_entry->message_template_schedule_id = $message_id;
                $customer_entry->customer_id = $customer_id;
                $customer_entry->save();
            }
        }
    }
}
