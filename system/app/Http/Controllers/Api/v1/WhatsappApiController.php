<?php

namespace App\Http\Controllers\Api\v1;

use Config;
use Carbon\Carbon;
use App\Models\User;
use DeductionHelper;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Customer;
use App\Models\Userplan;
use App\Models\Deduction;
use App\Models\ApiMessage;
use App\Models\Enterprise;
use App\Models\OfferReward;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\AdminMessage;
use App\Models\ContactGroup;

use App\Models\MessageRoute;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BusinessVcard;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\WhatsappSession;
use App\Jobs\ImportFreeUsersJob;
use App\Models\BusinessCustomer;
use App\Models\DeductionHistory;
use App\Models\UserNotification;
use App\Models\SocialAccountCount;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Jobs\CreateFreeBusinessUserJob;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\WACloudApiController;
use App\Http\Controllers\Business\ChannelController;
use App\Http\Controllers\Business\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

class WhatsappApiController extends Controller
{
    //
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

    public function validateParams($req){
        $dataArr = array();
        $dataArr = [
            'user_id' => '', 'wa_session' => '', 'access_token' => '', 'username' => '', 'password' => '', 'sendername' => '', 'routetype' => '', 'mobile' => '', 'message' => ''];

        $params = $req->all();

        if(!isset($params['username'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get username.']; } 

        if(!isset($params['password'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get password.']; } 

        if(!isset($params['mobile'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get mobile.']; } 

        if(!isset($params['sendername'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get sendername.']; } 

        if(!isset($params['message'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get message.']; } 

        if(!isset($params['routetype'])){ $routetype = 1; }else{ $routetype = $req->routetype; }

        $username = $req->username;
        $password = $req->password;
        $mobile = $req->mobile;
        $sendername = $req->sendername;
        $message = $req->message;

        if(!is_numeric($mobile) || strlen($mobile) != 12 || $mobile == null){
            return ['status'=> false, 'data' => [], 'message'=> 'Number is invalid.'];
        }

        $apiData = WhatsappApi::where('username',$username)->where('password',$password)->where('status','1')->orderBy('id', 'desc')->first();

        if($apiData == null){ return ['status'=> false, 'data' => [], 'message'=> 'Api data not found.']; }

        $isChannelActive = UserChannel::whereChannelId(4)->whereUserId($apiData->user_id)->first('status');

        if($isChannelActive->status == 0){
            return ['status'=> false, 'data' => [], 'message'=> Config::get('constants.messaging_api_status')];
        }

        /*  Check with sender name */
        $apiData = WhatsappApi::where('username',$username)->where('password',$password)->where('sendername',$sendername)->where('status','1')->orderBy('id', 'desc')->first();
        if($apiData == null){ return ['status'=> false, 'data' => [], 'message'=> 'Sendername is invalid.']; }


        /*Per Day Message Limit Check*/
        $freeMessagesLimit=Option::where('key','=','messaging_api_limit')->first();
        $messagewallet=MessageWallet::where('user_id',$apiData->user_id)->first();
        $messages = MessageHistory::where('user_id',$apiData->user_id)->where('channel_id','4')->where('sent_via','=','wa')
        ->whereDate('created_at', Carbon::today())->where('status',1)->count();
        //if($messages >= $messagewallet->messaging_api_daily_limit){ return ['status'=> false, 'data' => [], 'message'=> 'You have exceeded Today\'s API message limit.']; }

        $userData = User::where('id', $apiData->user_id)->orderBy('id', 'desc')->first();

        $access_token = $userData->wa_access_token;
        $wa_session = WhatsappSession::where('user_id', $apiData->user_id)->orderBy('id', 'desc')
        ->select('id', 'instance_id', 'user_id', 'status')->first();

        $dataArr = [
            'user_id' => $userData->id,
            'enterprise_id' => $userData->enterprise_id,
            'wa_session' => $wa_session,
            'access_token' => $access_token,
            'username' => $username,
            'password' => $password,
            'sendername' => $sendername,
            'routetype' => $routetype,
            'mobile' => $mobile,
            'message' => $message,
            'status' => true
        ];

        return $dataArr;
    }

    public function sendApiMsg(Request $request){

        $dataArr = $this->validateParams($request);

        if($dataArr['status'] === false){
            return response()->json([
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
        $userData = User::where('id', $dataArr['user_id'])->first();
        $messagewallet=MessageWallet::where('user_id',$dataArr['user_id'])->first();
        $WAmsghistorydata=MessageHistory::where('user_id',$dataArr['user_id'])->where('channel_id',4)->where('sent_via','=','wa')->whereDate('created_at', Carbon::today())->where('status',1)->pluck('id')->toArray();
        $WAmsghistory=count($WAmsghistorydata);
        $deductionhistory=DeductionHelper::checkDeductionHistory($dataArr['user_id'], 4,7);
        
        /*if($deductionhistory['status'] !=true){
            $res = [
                'status' => false,
                'message' => "Messaging API charges per day not paid, Please recharge",
                'data' => []
            ];

            return response()->json([
                'wa' => $res, 
                'sms' => $res
            ]);
        }*/
        
        // Check Wallet using Route
        $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($dataArr['user_id'], 4, ['send_sms', 'send_whatsapp']);
        $route = \App\Http\Controllers\Business\RouteToggleContoller::routeDetail('4', $dataArr['user_id']);
        if($userData->current_account_status=='paid'){
                if($checkWalletBalance['status'] != true){
                    
                    $sms_res = [
                        'status' => false,
                        'message' => $checkWalletBalance['message'],
                        'data' => []
                    ];
                    if($route->wa){
                        if($messagewallet->messaging_api_daily_free_limit > $WAmsghistory){
                            $wa_res = $this->sendWhatsappMsg($dataArr);
                        }else{
                               $wa_res = [
                                        'status' => false,
                                        'message' => 'Daily free whatsapp limit exceeded',
                                        'data' => []
                                    ];
                        }
                    }else{
                        $wa_res = [
                                    'status' => false,
                                    'message' => 'Route not active.'
                                ];
                    }

                    return response()->json([ 
                        'sms' => $sms_res,
                        'wa'=> $wa_res
                    ]);
                }else{

                    $wa = $sms = 0; $wa_res = array(); $sms_res = array();
                    $sms_res = $wa_res = ['status'=> false, 'message' => 'Route not active.'];
                    if($route->wa){
                         if($deductionhistory['status'] !=true){
                            
                            if($messagewallet->messaging_api_daily_free_limit > $WAmsghistory){
                                $wa = 1;
                                $wa_res = $this->sendWhatsappMsg($dataArr);
                            }else{
                                   $wa_res = [
                                            'status' => false,
                                            'message' => 'Daily free whatsapp limit exceeded',
                                            'data' => []
                                        ];
                            }

                         }else{
                            $messages = MessageHistory::where('user_id',$dataArr['user_id'])->where('channel_id','4')->where('sent_via','=','wa')->whereDate('created_at', Carbon::today())->where('status',1)->count();
                            if($messages >= $messagewallet->messaging_api_daily_limit)
                            {
                                $wa_res = [
                                            'status' => false,
                                            'message' => 'You have exceeded Today\'s API whatsapp message limit.',
                                            'data' => []
                                        ]; 
                            }else{
                                $wa = 1;
                                $wa_res = $this->sendWhatsappMsg($dataArr);
                            }
                             
                         }
                        

                    }else{ $wa_res = ['status'=> false, 'message' => 'Route not active.']; }

                    if($route->sms){
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
                    }else{ $sms_res = ['status'=> false, 'message' => 'Route not active.']; }

                }
        }
        if($userData->current_account_status=='free'){
                
                if($route->wa){
                    if($messagewallet->messaging_api_daily_free_limit > $WAmsghistory){
                        $wa_res = $this->sendWhatsappMsg($dataArr);
                        
                    }else{
                       $wa_res = [
                                'status' => false,
                                'message' => 'Daily free whatsapp limit exceeded',
                                'data' => []
                            ];
                    }

                }else{
                    $wa_res = [
                                'status' => false,
                                'message' => 'Route not active',
                            ];
                }
                $sms_res = [
                        'status' => false,
                        'message' => 'Your wallet balance is low, please recharge!',
                        'data' => []
                ];
                return response()->json([ 
                            'sms' => $sms_res,
                            'wa'=> $wa_res
                        ]);

        }
        // if($messageWallet->will_expire_on < $todays_date){
        //     $res = [
        //         'status' => false,
        //         'message' => "Your message plan has expired.",
        //         'data' => []
        //     ];

        //     return response()->json([
        //         'wa' => $res, 
        //         'sms' => $res
        //     ]);
        // }
        
        
            $businessDetails = BusinessDetail::where('user_id', $dataArr['user_id'])->first();
        
        // $dataArr['message'] = "Thanks for visiting and choosing ".$businessDetails->business_name."\nWe would be pleased to serve you again.\nOPNLNK";
                $mob_number = substr($dataArr['mobile'], '2');
                $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();
            
                if($customer == null){

                    $customer= new Customer;
                    $customer->mobile = (int)$mob_number;
                    $customer->user_id = $dataArr['user_id'];
                    $customer->created_by = $dataArr['user_id'];
                    $customer->save();

                    $customer->uuid = $dataArr['user_id'].'CUST'.date("Ymd");
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

                /* Add to Instant Contacts */
                $contactGroup = ContactGroup::where('user_id', $dataArr['user_id'])->where('channel_id', 4)->first();
                $contact = GroupCustomer::where('user_id', $dataArr['user_id'])->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
                if($contact == null){
                    $contact = new GroupCustomer;
                    $contact->user_id = $dataArr['user_id'];
                    $contact->contact_group_id = $contactGroup->id;
                    $contact->customer_id = $customer->id;
                    $contact->save();
                }
        
            return response()->json(['wa' => $wa_res, 'sms' => $sms_res]);
        
    }

    public function sendSmsMsg($dataArr){
                
        $postData = array(
            'username' => $this->smsusername,
            'password' => $this->smspassword,
            'mobile' => $dataArr['mobile'],
            'sendername' => $this->sendername,
            'message' => $dataArr['message'],
            'routetype' => $dataArr['routetype']
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
        }else{
            $messageHistory_id = DeductionHelper::setMessageHistory($dataArr['user_id'], 4, $dataArr['mobile'], $dataArr['message'], "Messaging API", 'sms', 1);

            // Insert in Deduction History Table
            $checkWallet = DeductionHelper::getUserWalletBalance($dataArr['user_id']);
            if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
            }
            else{
                $mob_number = substr($dataArr['mobile'], '2');
                $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();

                $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                DeductionHelper::deductWalletBalance($dataArr['user_id'], $deductionDetail->id ?? 0, 4, $messageHistory_id, $customer->id ?? 0, 0);
            }
        }
        curl_close($ch);
        return $output;
    }

     
    /*public function sendWhatsappMsg($dataArr){
        
        if($dataArr['wa_session'] != null && isset($dataArr['wa_session']->instance_id) && $dataArr['wa_session']->instance_id != ''){

            $dataArr['message'] = str_replace("OPNLNK", "MouthPublicity.io", $dataArr['message']);

                $paramDataArray = [
                    'number' => $dataArr['mobile'],
                    'type' => 'text',
                    'message' => $dataArr['message'],
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
                        $messageHistory_id = DeductionHelper::setMessageHistory($dataArr['user_id'], 4, $dataArr['mobile'], $dataArr['message'], "Messaging API", 'wa', 1);

                        // Insert in Deduction History Table
                        $mob_number = substr($dataArr['mobile'], '2');
                        $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();

                        // $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                        // DeductionHelper::deductWalletBalance($dataArr['user_id'], $deductionDetail->id ?? 0, 4, $messageHistory_id, $customer->id ?? 0, 0);

                        return json_decode($response); 
                    }
                    
                }

        }else{
            return ['status'=> false, 'data' => [], 'message'=> 'Your business account is not linked to Whatsapp.'];
        }
    }*/
    


    /* Send Messaging API message with new WA API Start */
    public function sendWhatsappMsg($dataArr){
        
        if($dataArr['wa_session'] != null && isset($dataArr['wa_session']->instance_id) && $dataArr['wa_session']->instance_id != ''){

            $dataArr['message'] = str_replace("OPNLNK", "MouthPublicity.io", $dataArr['message']);

            $wa_send_message = app('App\Http\Controllers\WaApiController')->sendWaTextMsg($dataArr);

            if ($wa_send_message["status"] == false) { 
                $messageHistoryParams=[
                    'user_id' => $dataArr['user_id'],
                    'channel_id' => 4,
                    'mobile' => $dataArr['mobile'],
                    'content' => $dataArr['message'],
                    'related_to' => "Messaging API",
                    'sent_via' => "wa",
                    'status' => 0,
                ];
                $this->_addMessageHistory($messageHistoryParams); 
            } else { 
                $messageHistoryParams=[
                    'user_id' => $dataArr['user_id'],
                    'channel_id' => 4,
                    'mobile' => $dataArr['mobile'],
                    'content' => $dataArr['message'],
                    'related_to' => "Messaging API",
                    'sent_via' => "wa",
                    'status' => 1,
                ];
                $this->_addMessageHistory($messageHistoryParams);

                $messageWallet = MessageWallet::where('user_id',$dataArr['user_id'])
                ->orderBy('id','desc')->first();
                $messageWallet->total_messages = $messageWallet->total_messages - 1;
                $messageWallet->save();
            }

            return ['status'=> $wa_send_message["status"], 'data' => $wa_send_message["data"], 'message'=> $wa_send_message["message"]];

        }else{

            $messageHistoryParams=[
                'user_id' => $dataArr['user_id'],
                'channel_id' => 4,
                'mobile' => $dataArr['mobile'],
                'content' => $dataArr['message'],
                'related_to' => "Messaging API",
                'sent_via' => "wa",
                'status' => 0,
            ];
            $this->_addMessageHistory($messageHistoryParams);

            return ['status'=> false, 'data' => [], 'message'=> 'Your business account is not linked to Whatsapp.'];
        }
    }
    /* Send Messaging API message with new WA API End */

    private function _addMessageHistory($params)
    {

        /* Customer ID */
        $customer_id = 0;
        $enterprise_user_mobile = substr($params['mobile'], 2);
        $customer = Customer::where('mobile', $enterprise_user_mobile)->first();
        if($customer != null){
            $customer_id = $customer->id;
        }

        $offer_id = 'NULL';
        if(isset($params['offer_id'])){
            $offer_id = $params['offer_id'];
        }


        $message = new MessageHistory;
        $message->user_id = $params['user_id'];
        $message->channel_id = $params['channel_id'];
        $message->customer_id = $customer_id;
        $message->offer_id = $offer_id;
        $message->mobile = $params['mobile'];
        $message->content = $params['content'];
        $message->related_to = $params['related_to'];
        $message->sent_via = $params['sent_via'];
        $message->status = $params['status'];
        $message->save();

        $messageWallet = MessageWallet::where('user_id',$params['user_id'])
                        ->orderBy('id','desc')->first();
        $messageWallet->total_messages = $messageWallet->total_messages - 1;
        $messageWallet->save();
    }

    public function sendDocumentApiMsg(Request $request){
        $dataArr = $this->validateMessageParams($request);

        if($dataArr['status'] === false){
            return response()->json([
                'status' => 'error',
                'message' => $dataArr['message'],
                'data' => []
            ]);
        }
        
        $userData = User::where('id', $dataArr['user_id'])->first();

        if($userData->is_registration_complete == 0){
            $redirectURL = route('enterpriseUserDetail', $userData->enterprise_info_token);
            $data['redirect_url'] = $redirectURL;

            return response()->json([
                'status' => 'error',
                'message' => 'Please first complete the registration by visiting the redirect url.',
                'data' => $data
            ]);
        }
        
        if($dataArr['wa_session'] != null && isset($dataArr['wa_session']->instance_id) && $dataArr['wa_session']->instance_id != ''){

            $messageWallet = MessageWallet::where('user_id', $dataArr['user_id'])->first();
            $enterprise_api_wa_limit = $messageWallet->enterprise_api_wa_limit ?? 0;

            $monthStartDate = Carbon::now()->startOfMonth();
            $monthEndDate = Carbon::now()->endOfMonth();

            $apiMsgMonthlyCount = ApiMessage::where('user_id', $dataArr['user_id'])
                                            ->whereDate('created_at', ">=", $monthStartDate)
                                            ->whereDate('created_at', "<=", $monthEndDate)
                                            ->count();

            $deductionCostDetail = DeductionHelper::getActiveDeductionDetail('slug', 'msg_api_wa_cost');
            $deductionDetail = Deduction::where('id', $deductionCostDetail->id ?? 0)->where('status', 1)->first();
            $deductionAmout = (float) $deductionDetail->amount ?? 0;

            //check balance
            if($apiMsgMonthlyCount >= $enterprise_api_wa_limit &&  $messageWallet->wallet_balance < $deductionAmout){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your free limit exhausted and you do not have enough balance to send message. Please recharge.',
                    'data' => []
                ]);
            }


            $dataArr['message'] = str_replace("OPNLNK", "MouthPublicity.io", $dataArr['message']);
            $country_code = 91;
            $dataArr['mobile'] = $country_code.$dataArr['mobile'];

            if($request->hasFile('pdf')){
                $dataArr['pdf'] = $request->pdf;
                $dataArr['filename'] = $request->pdf->getClientOriginalName();
    
                $wa_send_message = app('App\Http\Controllers\WaApiController')->sendWaTextDocMsg($dataArr);
            }else{
                $dataArr['pdf'] = $dataArr['filename'] = '';
                $wa_send_message = app('App\Http\Controllers\WaApiController')->sendWaTextMsg($dataArr);
            }
            

            if ($wa_send_message["status"] == true && isset($wa_send_message['data']['error']) && $wa_send_message['data']['error']==false){ 

                $deduction_history_id = 0;
                if($apiMsgMonthlyCount >= $enterprise_api_wa_limit){
                    
                    $channel_id = 4;
                    $message_history_id = $customer_id = $employee_id = 0;

                    // get Customer OR save if mobile number not exits.
                    $customer_id = $this->checkAndGetCustomer($dataArr['mobile'], $dataArr['user_id']);

                    $deductionHistory = new DeductionHistory;
                    $deductionHistory->user_id = $dataArr['user_id'];
                    $deductionHistory->channel_id = $channel_id;
                    $deductionHistory->message_history_id = $message_history_id;
                    $deductionHistory->deduction_id = $deductionDetail->id ?? 0;
                    $deductionHistory->deduction_amount = $deductionAmout;
                    $deductionHistory->customer_id = $customer_id;
                    $deductionHistory->employee_id = $employee_id;
                    
                    if($deductionHistory->save()){
                        $deduction_history_id = $deductionHistory->id;
                    }

                    //Deduct amount
                    $messageWallet = MessageWallet::find($messageWallet->id);
                    $messageWallet->wallet_balance = $messageWallet->wallet_balance - $deductionAmout;
                    $messageWallet->save();
                }

                $status = 2;
                if($wa_send_message["status"] == true && isset($wa_send_message['data']['error']) && $wa_send_message['data']['error']==false){
                    $status = 1;
                }

                $apiMessage = new ApiMessage;
                $apiMessage->user_id = $dataArr['user_id'];
                $apiMessage->enterprise_id = $dataArr['enterprise_id'];
                $apiMessage->deduction_history_id = $deduction_history_id;
                $apiMessage->mobile = $dataArr['mobile'];
                $apiMessage->message = $dataArr['message'];
                $apiMessage->invoice_number = $dataArr['invoice_number'];
                $apiMessage->invoice_amount = $dataArr['invoice_amount'];
                $apiMessage->pdf = $dataArr['filename'];
                $apiMessage->status = $status;
                $apiMessage->sent_via = 'wa';
                $apiMessage->save();
                
                // dd("hi", $apiMsgMonthlyCount, $enterprise_api_wa_limit);
                
                return ['status'=> 'success', 'data' => [], 'message'=> 'Message sent successfully!'];
            }
            else{
                $user = User::find($dataArr['user_id']);
                $redirectURL = route('enterpriseUserDetail', $user->enterprise_info_token);

                $data['redirect_url'] = $redirectURL;
                $data['enterprise_user_id'] = $dataArr['enterprise_user_id'];
                $data['enterprise_id'] = $dataArr['enterprise_id'];

                return ['status'=> 'error', 'data' => $data, 'message'=> "Disconnected with Whatsapp please scan QR again by clicking the redirect url."];
            }
        }else{
            $user = User::find($dataArr['user_id']);
            $redirectURL = route('enterpriseUserDetail', $user->enterprise_info_token);

            $data['redirect_url'] = $redirectURL;
            $data['enterprise_user_id'] = $dataArr['enterprise_user_id'];
            $data['enterprise_id'] = $dataArr['enterprise_id'];

            return ['status'=> 'error', 'data' => $data, 'message'=> "Disconnected with Whatsapp please scan QR again by clicking the redirect url."];
        }
    }

    public function checkAndGetCustomer($enterprise_user_mobile="", $user_id=0){
        $mob_number = substr($enterprise_user_mobile, '2');
        $customer = Customer::where('mobile',(int)$mob_number)->orderBy('id', 'desc')->first();
    
        if($customer == null){

            $customer= new Customer;
            $customer->mobile = (int)$mob_number;
            $customer->user_id = $user_id;
            $customer->created_by = $user_id;
            $customer->save();

            $customer->uuid = $user_id.'CUST'.date("Ymd");
            $customer->save();
            
            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = $user_id;
            $business_customer->save();

        }else{
            $checkBCustomer = BusinessCustomer::where('customer_id', $customer->id)
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')->first();

            if($checkBCustomer == null){
                $business_customer = new BusinessCustomer;
                $business_customer->customer_id = $customer->id;
                $business_customer->user_id = $user_id;
                $business_customer->save();
            }
        }

        /* Add to Instant Contacts */
        $contactGroup = ContactGroup::where('user_id', $user_id)->where('channel_id', 4)->first();
        $contact = GroupCustomer::where('user_id', $user_id)->where('contact_group_id', $contactGroup->id ?? 0)->where('customer_id', $customer->id)->first();
        if($contact == null){
            $contact = new GroupCustomer;
            $contact->user_id = $user_id;
            $contact->contact_group_id = $contactGroup->id ?? 0;
            $contact->customer_id = $customer->id;
            $contact->save();
        }

        return $customer->id;
    }

    public function validateMessageParams($req){
        $dataArr = array();
        $dataArr = [
            'enterprise_id' => '', 'enterprise_user_id' => '', 'customer_mobile' => '', 'message' => '', 'invoice_amount' => '', 'invoice_number' => ''];

        $params = $req->all();

        if(!isset($params['enterprise_id'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get channel partner id.']; } 

        if(!isset($params['enterprise_user_id'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get unique number.']; }

        if(!isset($params['customer_mobile'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get customer mobile number.']; }

        if(!isset($params['message'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get message.']; }

        if(!isset($params['invoice_number'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get invoice number.']; }

        if(!isset($params['invoice_amount'])){ return ['status'=> false, 'data' => [], 'message'=> 'Didn\'t get invoice amount.']; }

        $strLenLimit = 200;
        if(strlen($params['message']) > $strLenLimit){
            return ['status'=> false, 'data' => [], 'Message character length more then given limit'];
        }

        // Validate file with PDF and filesize 2MB
        if(isset($params['pdf'])){ 
            $extension = $params['pdf']->clientExtension();
            if($extension!="pdf"){
                return ['status'=> false, 'data' => [], 'message'=> 'Please select PDF file']; 
            }

            // Validate file size here
            // 1024 [1MB] * 2 = 2048;
            $validator = \Validator::make($params, [
                    'pdf' => 'max:2048',
                ],
                [
                    'pdf.max' => "The pdf must not be greater than 2MB."
                ]
            );
            if ( $validator->fails() ){
                return ['status'=> false, 'data' => [], 'message'=> $validator->errors()->first()];
            }
        } 

        $enterprise_id = $req->enterprise_id;
        $enterprise_user_mobile = $req->enterprise_user_mobile;
        $enterprise_user_id = $req->enterprise_user_id;
        $mobile = $req->customer_mobile;
        $message = $req->message;

        if(!is_numeric($mobile) || strlen($mobile) != 10 || $mobile == null){
            return ['status'=> false, 'data' => [], 'message'=> 'Number is invalid.'];
        }

        $enterprise = Enterprise::find($enterprise_id);
        $userData = '';
        if($enterprise != ''){
            $userData = User::where('enterprise_user_id', $enterprise_user_id)->where('enterprise_id', $enterprise->id)->orderBy('id', 'desc')->where('status', 1)->first();
        }else{
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise ID is invalid.'];
        }

        if($userData == ''){
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise user ID is invalid.'];
        }

        $wa_session = WhatsappSession::where('user_id', $userData->id)->orderBy('id', 'desc')
        ->select('id', 'instance_id', 'user_id', 'status')->first();

        $dataArr = [
            'user_id' => $userData->id,
            'enterprise_id' => $userData->enterprise_id,
            'wa_session' => $wa_session,
            'access_token' => '',
            'enterprise_id' => $enterprise_id,
            'enterprise_user_id' => $enterprise_user_id,
            'mobile' => $mobile,
            'message' => $message,
            'invoice_amount' => $params['invoice_amount'],
            'invoice_number' => $params['invoice_number'],
            'status' => true
        ];

        return $dataArr;
    }

    public function registerEnterpriseUser(Request $request){

        $dataArr = $this->validateEnterpriseUserParams($request);
        
        if($dataArr['status'] === true){
            $requestData = $request->all();
        }

        if($dataArr['status'] === false){
            return response()->json([
                'status' => 'error',
                'message' => $dataArr['message'],
                'data' => []
            ]);
        }

        /* Check if credentials exist  */
        $responseData = [];
        $uniqueNoExist = User::where('enterprise_user_id', $requestData['enterprise_user_id'])->first();

        $mobile = $email = $name = '';

        //mobile number
        if(isset($requestData['enterprise_user_mobile']) && $requestData['enterprise_user_mobile'] != ''){
            $existMobileNo = User::where('mobile', $requestData['enterprise_user_mobile'])->first();
            $mobile = $requestData['enterprise_user_mobile'];
        }else{
            $mobile = app('App\Http\Controllers\UuidTokenController')->getDummyMobileNo(); 
            $existMobileNo = '';
        }

        //name
        if(isset($requestData['enterprise_user_name']) && $requestData['enterprise_user_name'] != ''){
            $name = $requestData['enterprise_user_name'];
        }else{
            $name = app('App\Http\Controllers\UuidTokenController')->getDummyName();
        }

        //email
        if(isset($requestData['enterprise_user_email']) && $requestData['enterprise_user_email'] != ''){
            $existEmail = User::where('email', $requestData['enterprise_user_email'])->first();
            $email = $requestData['enterprise_user_email'];
        }else{
            $email = app('App\Http\Controllers\UuidTokenController')->getDummyEmail(); 
            $existEmail = '';
        }

        if ($existEmail == null && $existMobileNo == null && $uniqueNoExist == null) {
            $password = 'mouthpublicity@password';

            $userData = [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'password' => $password,
                'partner_key' => 'PRT-0IDR245P',
                'partner_id' => 3,
            ];
        
            /* Register user with new WA API Start */
            $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($userData);
            
            // Create Managemedia Account
            $socialPostAuthToken = app('App\Http\Controllers\Auth\RegisterController')->socialPostAuth($userData);

            /* Enterprise Details */
            $enterprise = Enterprise::find($requestData['enterprise_id']);
            $enterpriseUser = User::where('id', $enterprise->user_id)->first();

            $date = \Carbon\Carbon::now()->format('YmdHis');
            $randomCode = $this->getRandomCode(180);

            //Create User
            $user = new User();
            $user->enterprise_user_id = $requestData['enterprise_user_id'];
            $user->name = ucwords($name);
            $user->email = $email;
            $user->mobile = $mobile;
            $user->enterprise_id = $enterprise->id;
            $user->password = Hash::make($password);
            $user->role_id = 2;
            $user->pass_token = $randomCode . $date;
            $user->enterprise_info_token = $randomCode . $date;
            $user->wa_access_token = '';
            $user->social_post_api_token = $socialPostAuthToken;
            $user->status = 1;
            $user->save();

            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
            if ($wa_session == null) {
                $wa_session = new WhatsappSession();
                $wa_session->user_id = $user->id;
            }
            $wa_session->key_id = $wa_registration['data']['key_id'] ?? 'NULL';
            $wa_session->key_secret = $wa_registration['data']['key_secret'] ?? 'NULL';
            $wa_session->save();

            $userData['id'] = $user->id;
            $userData['enterprise_id'] = $enterprise->id;

            /* CRON FOR OTHER DATA */
            dispatch(new CreateFreeBusinessUserJob($userData));

            $redirectURL = route('enterpriseUserDetail', $user->enterprise_info_token);

            $responseData['enterprise_id'] = $requestData['enterprise_id'];
            $responseData['enterprise_user_id'] = $requestData['enterprise_user_id'];
            $responseData['redirect_url'] = $redirectURL;

            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully.',
                'data' => $responseData
            ]);
        }else if($uniqueNoExist != null){

            $redirectURL = '';
            
            if($uniqueNoExist->enterprise_info_token != ''){
                $redirectURL = route('enterpriseUserDetail', $uniqueNoExist->enterprise_info_token);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'User details fetched successfully.',
                'data' => [
                    'enterprise_user_id' => $requestData['enterprise_user_id'],
                    'enterprise_id' => $requestData['enterprise_id'],
                    'redirect_url' => $redirectURL, 
                ]
            ]);
        }else if($existEmail != null){
            return response()->json([
                'status' => 'error',
                'message' => 'User with same email already exist.',
                'data' => []
            ]);
        }else if($existMobileNo != null){
            return response()->json([
                'status' => 'error',
                'message' => 'User with same mobile number already exist.',
                'data' => []
            ]);
        }
    }

    public function validateEnterpriseUserParams($req){
        $params = $req->all();

        if(!isset($params['enterprise_id']) || $params['enterprise_id'] == ''){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise ID is required.']; 
        }

        $enterprise = Enterprise::find($params['enterprise_id']);
        if($enterprise == null){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise ID is invalid.']; 
        }

        if(!isset($params['enterprise_user_id']) || $params['enterprise_user_id'] == ''){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise user ID is required.']; 
        }

        if(isset($params['enterprise_user_name']) && $params['enterprise_user_name'] != '' && is_numeric($params['enterprise_user_name'])){ 
            return ['status'=> false, 'data' => [], 'message'=> 'Enterprise user name is invalid.']; 
        }

        if(isset($params['enterprise_user_email']) && $params['enterprise_user_email'] != ''){ 
            if (!filter_var($params['enterprise_user_email'], FILTER_VALIDATE_EMAIL)) {
                return ['status'=> false, 'data' => [], 'message'=> 'Enterprise user email is invalid.']; 
            }
        }

        if(isset($params['enterprise_user_mobile']) && $params['enterprise_user_mobile'] != ''){ 
            if (!is_numeric($params['enterprise_user_mobile']) || strlen($params['enterprise_user_mobile']) != 10) {
                return ['status'=> false, 'data' => [], 'message'=> 'Enterprise user mobile number is invalid.']; 
            }
        }

        return ['status'=> true, 'data' => [], 'message'=> 'Data is valid.']; 
    }

    public function getRandomCode($char = 8)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $char; $i++) {
            $index = rand(0, strlen($string) - 1);
            $randomCode .= $string[$index];
        }

        return $randomCode;
    }



}