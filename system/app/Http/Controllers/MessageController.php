<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\User;
use DeductionHelper;
use App\Models\Option;

use App\Models\Customer;
use App\Models\Userplan;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\ContactGroup;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\MessageHistory;
use App\Models\WhatsappSession;

use App\Models\BusinessCustomer;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\Business\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

class MessageController extends Controller
{
    private $smsusername;
    private $smspassword;
    private $smsoptions;
    private $smsurl;
    private $waoptions;
    private $waurl;

    public function __construct()
    {
        //
        $this->smsoptions=Option::where('key','sms_gateway')->first();
        $this->smsurl=json_decode($this->smsoptions->value)->url."/SMS_API/sendsms.php";

        $this->smsusername = json_decode($this->smsoptions->value)->username;
        $this->smspassword = json_decode($this->smsoptions->value)->password;
        $this->sendername = json_decode($this->smsoptions->value)->sendername;

        // dd(json_decode($this->smsoptions->value)->url);
        // $this->waoptions=Option::where('key','oddek_url')->first();
        // $this->waurl=$this->waoptions->value."/api/send.php";

    }

    public function validateParams($params){
       
        $dataArr = array();

        if(!is_numeric($params['mobile']) || strlen($params['mobile']) != 12 || $params['mobile'] == ''){
            return ['status'=> false, 'data' => [], 'message'=> 'Number is invalid.'];
        }

        if(!isset($params['message']) || $params['message'] == ''){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get message.']; 
        }    

        $userData = User::where('id', $params['user_id'])->orderBy('id', 'desc')->first();

        if($userData == null){
            return ['status'=> false, 'data' => [], 'message'=> 'WhatsApp Access Token not found.'];
        }

        // if($userData->wa_access_token == null){ return ['status'=> false, 'data' => [], 'message'=> 'WhatsApp Access Token not found.']; }

        $access_token = $userData->wa_access_token;
        $wa_session = WhatsappSession::where('user_id', $params['user_id'])->orderBy('id', 'desc')
        ->select('id', 'instance_id', 'user_id', 'status')->first();

        // dd($params);

        $whatsapp_msg = $params['message'];
        if(isset($params['whatsapp_msg'])){
            $whatsapp_msg = $params['whatsapp_msg'];
        }

        $sms_msg = $params['message'];
        if(isset($params['sms_msg'])){
            $sms_msg = $params['sms_msg'];
        }

        $dataArr = [
            'user_id' => $userData->id,
            'wa_session' => $wa_session,
            'access_token' => $access_token,
            'mobile' => $params['mobile'],
            'message' => $params['message'],
            'whatsapp_msg' => $whatsapp_msg,
            'sms_msg' => $sms_msg,
            'channel_id' => $params['channel_id'],
            'status' => true
        ];
// dd($dataArr);
        return $dataArr;
    }

    public function sendMsg($params){
        
        $dataArr = $this->validateParams($params);

        if($dataArr['status'] === false){
            return response()->json(
                [
                    'wa' => [
                        'status' => $dataArr['status'],
                        'message' => $dataArr['message'],
                        'data' => []
                    ], 
                    'sms' => [
                        'status' => $dataArr['status'],
                        'message' => $dataArr['message'],
                        'data' => []
                    ]
                ]);
        }

        $route = \App\Http\Controllers\Business\RouteToggleContoller::routeDetail($dataArr['channel_id'], $dataArr['user_id']);

        $wa = $sms = 0; $wa_res = array(); $sms_res = array();
        $sms_res = $wa_res = ['status'=> false, 'message' => 'Route not active.'];

        // CHECK WHATSAPP's DEDUCT AMT
        // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
        // $checkWaWalletBalance = DeductionHelper::checkWalletBalance($dataArr['user_id'], $deductionWaDetail->id ?? 0);

        if($route->wa){
            $wa = 1;
            $wa_res = $this->sendWhatsappMsg($dataArr);
        }else{ $wa_res = ['status'=> false, 'message' => 'Route not active.']; }

        // CHECK SMS DEDUCT AMT
        $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
        $checkSmsWalletBalance = DeductionHelper::checkWalletBalance($dataArr['user_id'], $deductionSmsDetail->id ?? 0);

        if($route->sms==1 && $checkSmsWalletBalance['status'] == true){
            $checkWallet = DeductionHelper::getUserWalletBalance($dataArr['user_id']);
            if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
            }
            else{
                $sms = 1;
                $string = $this->sendSmsMsg($dataArr);
                $semicolon = ';';
                $colon = ':';

                if(strpos($string, $semicolon) !== false){
                    $array = explode($semicolon,$string);
                    $sms_res = array();
                    $arrayMult = array();
                    foreach ($array as $ary ) {
                        $val = explode($colon,$ary);
                        $arrayMult[] =  [$val[0] => $val[1]];
                    }
                    $sms_res = call_user_func_array('array_merge', $arrayMult);
                }else{
                    $array = explode($colon,$string);
                    $sms_res = [$array[0] => $array[1]];
                }
            }
        }else{ $sms_res = ['status'=> false, 'message' => 'Route not active.']; }

        return response()->json(['wa' => $wa_res, 'sms' => $sms_res]);
    }

    public function sendSmsMsg($dataArr){
        if(strlen($dataArr['mobile'])==12){
            $dataArr['mobile'] = substr($dataArr['mobile'], '2'); 
        }

        $postData = array(
            'username' => $this->smsusername,
            'password' => $this->smspassword,
            'mobile' => $dataArr['mobile'],
            'sendername' => $this->sendername,
            'message' => $dataArr['message'],
            'routetype' => 1
        );

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->smsurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch)) { 
            return curl_error($ch); 
        }
        curl_close($ch);
        return $output;

    }

    /*
    public function sendWhatsappMsg($dataArr){
        
        if($dataArr['wa_session'] != null && isset($dataArr['wa_session']->instance_id) && $dataArr['wa_session']->instance_id != ''){

            $dataArr['message'] = str_replace("OPNLNK", "MouthPublicity.io", $dataArr['message']);

                $paramDataArray = [
                    'number' => $dataArr['mobile'],
                    'type' => 'text',
                    'message' => $dataArr['whatsapp_msg'],
                    'instance_id' => $dataArr['wa_session']->instance_id,
                    'access_token' => $dataArr['access_token']
                ];        
                     
                $paramData = http_build_query($paramDataArray);
                $ch = curl_init();              
                $getUrl = $this->waurl."?".$paramData;
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                $response = curl_exec($ch);
                $output = json_decode($response);
                $err = curl_error($ch);

                if ($err) { 
                    return ['status'=> false, 'data' => $err, 'message'=> 'Something went wrong. Please try again.']; 
                } else { 
                    if($output == null || $output->status == 'error'){
                        return ['status'=> false, 'data' => $response, 'message'=> 'Something went wrong. Please try again.']; 
                    }else{

                        $mob_number = substr($dataArr['mobile'], '2');
                        $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();

                        if($customer == null){

                            $customer= new Customer;
                            $customer->mobile = (int)$mob_number;
                            $customer->user_id = $dataArr['user_id'];
                            $customer->created_by = $dataArr['user_id'];
                            $customer->save();

                            $customer->uuid = $user->id.'CUST'.date("Ymd");
                            $customer->save();
                            
                            $business_customer = new BusinessCustomer;
                            $business_customer->customer_id = $customer->id;
                            $business_customer->user_id = $dataArr['user_id'];
                            $business_customer->save();

                        }else{

                            $checkBCustomer = BusinessCustomer::where('customer_id', $customer->id)
                            ->where('user_id', $dataArr['user_id'])
                            ->orderBy('id', 'desc')->first();

                            if($checkBCustomer == null){
                                $business_customer = new BusinessCustomer;
                                $business_customer->customer_id = $customer->id;
                                $business_customer->user_id = $dataArr['user_id'];
                                $business_customer->save();
                            }
                        }

                        //  Add to Instant Contacts start 
                            $contactGroup = ContactGroup::where('user_id', $dataArr['user_id'])->where('channel_id', 2)->first();
                            $contact = GroupCustomer::where('user_id', $dataArr['user_id'])->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
                            if($contact == null){
                                $contact = new GroupCustomer;
                                $contact->user_id = $dataArr['user_id'];
                                $contact->contact_group_id = $contactGroup->id;
                                $contact->customer_id = $customer->id;
                                $contact->save();
                            }
                        //  Add to Instant Contacts end 

                        return json_decode($response, true); 
                    }
                    
                }

        }else{

            return ['status'=> false, 'data' => [], 'message'=> 'Your business account is not linked to Whatsapp.'];
        }
    }
    */

    public function sendOnlyWhatsappMsg($params){
        
        $dataArr = $this->validateParams($params);

        if($dataArr['status'] === false){
            return response()->json(
                [
                    'wa' => [
                        'status' => $dataArr['status'],
                        'message' => $dataArr['message'],
                        'data' => []
                    ]
                ]);
        }

        $route = \App\Http\Controllers\Business\RouteToggleContoller::routeDetail($dataArr['channel_id'], $dataArr['user_id']);

        $wa = 0; $wa_res = array();
        $wa_res = ['status'=> false, 'message' => 'Route not active.'];

        if($route->wa || $dataArr['channel_id'] == 0){
            $wa = 1;
            $wa_res = $this->sendWhatsappMsg($dataArr);
        }else{ $wa_res = ['status'=> false, 'message' => 'Route not active.']; }

        return response()->json(['wa' => $wa_res]);
    }


    public function validateSMSParams($params){
       
        $dataArr = array();

        if(!is_numeric($params['mobile']) || strlen($params['mobile']) != 12 || $params['mobile'] == ''){
            return ['status'=> false, 'data' => [], 'message'=> 'Number is invalid.'];
        }

        if(!isset($params['message']) || $params['message'] == ''){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get message.']; 
        }    

        $dataArr = [
            'user_id' => $params['user_id'],
            'mobile' => $params['mobile'],
            'message' => $params['message'],
            'channel_id' => $params['channel_id'],
            'status' => true
        ];

        return $dataArr;
    }


    public function sendOnlyMsg($params){
        
        $dataArr = $this->validateSMSParams($params);

        if($dataArr['status'] === false){
            return response()->json(
                [
                    'sms' => [
                        'status' => $dataArr['status'],
                        'message' => $dataArr['message'],
                        'data' => []
                    ]
                ]);
        }

        $sms = 0; 
        $sms_res = array();
        $sms_res = ['status'=> false, 'message' => 'Route not active.'];

        if(strlen($dataArr['mobile'])==12){
            $dataArr['mobile'] = substr($dataArr['mobile'], '2'); 
        }

        $postData = array(
            'username' => $this->smsusername,
            'password' => $this->smspassword,
            'mobile' => $dataArr['mobile'],
            'sendername' => $this->sendername,
            'message' => $dataArr['message'],
            'routetype' => 1
        );

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->smsurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $string = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch)) { 
            $sms_res = ['status'=> false, 'message' => curl_error($ch)]; 
        }else{
            $sms = 1;
            $semicolon = ';';
            $colon = ':';

            if(strpos($string, $semicolon) !== false){
                $array = explode($semicolon,$string);
                $sms_res = array();
                $arrayMult = array();
                foreach ($array as $ary ) {
                    $val = explode($colon,$ary);
                    $arrayMult[] =  [$val[0] => $val[1]];
                }
                $sms_res = call_user_func_array('array_merge', $arrayMult);
            }else{
                $array = explode($colon,$string);
                $sms_res = [$array[0] => $array[1]];
            }
        }
        curl_close($ch);

        return response()->json(['sms' => $sms_res]);
    }



    /* WA API send text message start */

    public function sendWhatsappMsg($dataArr){
        
        if($dataArr['wa_session'] != null && isset($dataArr['wa_session']->instance_id) && $dataArr['wa_session']->instance_id != ''){

            $dataArr['message'] = str_replace("OPNLNK", "MouthPublicity.io", $dataArr['message']);

            $wa_send_message = app('App\Http\Controllers\WaApiController')->sendWaTextMsg($dataArr);

            if ($wa_send_message["status"] == false) { 
                // return ['status'=> false, 'data' => $err, 'message'=> 'Something went wrong. Please try again.']; 
                return ['status'=> false, 'data' => [], 'message'=> 'Something went wrong. Please try again.']; 
            } else { 
                $mob_number = substr($dataArr['mobile'], '2');
                $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();

                if($customer == null){

                    $customer= new Customer;
                    $customer->mobile = (int)$mob_number;
                    $customer->user_id = $dataArr['user_id'];
                    $customer->created_by = $dataArr['user_id'];
                    $customer->save();

                    $customer->uuid = $user->id.'CUST'.date("Ymd");
                    $customer->save();
                    
                    $business_customer = new BusinessCustomer;
                    $business_customer->customer_id = $customer->id;
                    $business_customer->user_id = $dataArr['user_id'];
                    $business_customer->save();

                }else{

                    $checkBCustomer = BusinessCustomer::where('customer_id', $customer->id)
                    ->where('user_id', $dataArr['user_id'])
                    ->orderBy('id', 'desc')->first();

                    if($checkBCustomer == null){
                        $business_customer = new BusinessCustomer;
                        $business_customer->customer_id = $customer->id;
                        $business_customer->user_id = $dataArr['user_id'];
                        $business_customer->save();
                    }
                }

                return ['status'=> $wa_send_message["status"], 'data' => $wa_send_message["data"], 'message'=> $wa_send_message["message"]];
            }

        }else{

            return ['status'=> false, 'data' => [], 'message'=> 'Your business account is not linked to Whatsapp.'];
        }
    }

    /* WA API send text message end */

}