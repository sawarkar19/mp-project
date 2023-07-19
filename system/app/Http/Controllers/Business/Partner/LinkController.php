<?php

namespace App\Http\Controllers\Business\Partner;

use Auth;
use Session;

use Carbon\Carbon;
use App\Models\User;

use App\Models\Option;
use App\Models\Customer;

use App\Models\PaymentLink;
use App\Models\MessageWallet;
use App\Models\MessageHistory;

use Illuminate\Http\Request;
use App\Models\WhatsappSession;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

use DeductionHelper;

class LinkController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function paymentLinks(){
        $paymentLinks = PaymentLink::where('enterprise_id',Auth::id())->where('status', '1')->latest()->paginate(10);
    

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('partner.links.index', compact('paymentLinks','notification_list', 'planData'));
    }

    public function paymentLink($id)
    {
        $paymentLink = PaymentLink::findorFail($id);

        $whatsappSession = WhatsappSession::where('user_id', $paymentLink->enterprise_id)->first();
        $instance = '';
        if($whatsappSession != null && $whatsappSession->instance_id != ''){
            $instance = $whatsappSession->instance_id;
        }

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('partner.links.send-link',compact('paymentLink','notification_list', 'planData', 'instance'));
    }

    public function sendToBusiness(Request $request)
    {
        /*whatsapp login check*/
        $whatsappSession = WhatsappSession::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $paymentLink = PaymentLink::find($request->paymentlink_id);
        $userData = User::find($paymentLink->enterprise_id);

        // if($userData->wa_access_token == ''){
        //     return response()->json(["status" => false, "message" => "Link not shared."]);
        // }
        if($whatsappSession == null && isset($whatsappSession->instance_id) && $whatsappSession->instance_id == ''){
            return response()->json(["status" => false, "message" => "Link not shared."]);
        }

        
        if($request->message != ''){
            $message = $request->message."\n\n".$paymentLink->short_link;
        }else{
            $message = $paymentLink->short_link;
        }

        // $wpa_res = WhatsAppMsgController::sendTextMessageWP('91'.$paymentLink->mobile, $message);
        // $res = json_decode($wpa_res);

        $dataArr = [
            'number' => $paymentLink->mobile,
            'type' => 'text',
            'message' => $message,
            'wa_session' => $whatsappSession
        ];

        $shareLink = $this->shareLinkOnWhatsapp($dataArr);
        // dd($shareLink);
        if($shareLink['status'] == false){
            return response()->json(["status" => false, "message" => "Link not shared."]);
        }else{
            return response()->json(["status" => true, "message" => "Link shared successfully."]);
        }

    }

    public function shareLinkOnWhatsapp($dataArr){
        $url = Option::where('key','wa_api_url')->first();
        $waurl = $url->value."/api/send.php";

        $paramDataArray = [
            'mobile' => '91'.$dataArr['number'],
            'message' => $dataArr['message'],
            'wa_session' => $dataArr['wa_session']
        ];

        $wa_send_message = app('App\Http\Controllers\WaApiController')->sendWaTextMsg($paramDataArray);
        // dd($wa_send_message);
        if ($wa_send_message["status"] == false) { 
            return ['status'=> false, 'data' => [], 'message'=> 'Link not shared']; 
        } else {
            //  Customer ID 
            $customer_id = 0;
            $customer = Customer::where('mobile', $dataArr['number'])->first();
            if($customer != null){
                $customer_id = $customer->id;
            }

            $offer_id = 'NULL';
            if(isset($dataArr['offer_id'])){
                $offer_id = $dataArr['offer_id'];
            }

            // save Message in History
            $messageHistory = new MessageHistory();
            $messageHistory->user_id = Auth::id();
            $messageHistory->customer_id = $customer_id;
            $messageHistory->offer_id = $offer_id;
            $messageHistory->mobile = '91'.$dataArr['number'];
            $messageHistory->content = $dataArr['message'];
            $messageHistory->related_to = "Sent by Partner";
            $messageHistory->sent_by = "Partner";
            $messageHistory->sent_via = 'wa';
            $messageHistory->is_sent_auto_msg = 0;
            $messageHistory->status = 1;
            $messageHistory->save();

            // Insert in Deduction History Table
            $customer = Customer::where('mobile', $dataArr['number'])->orderBy('id', 'desc')->first();

            // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
            // DeductionHelper::deductWalletBalance(Auth::id(), $deductionWaDetail->id ?? 0, 0, $messageHistory->id, $customer->id ?? 0, 0);

            return ['status' => true, 'message' => 'Link shared successfully!'];
        }
    }

    /*
    public function shareLinkOnWhatsapp($dataArr){
        
        // $messageWallet = MessageWallet::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        
        // Check Wallet using Route
        // $getWalleteInfo = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
        // $checkWalletBalance = DeductionHelper::checkWalletBalance(Auth::id(), $getWalleteInfo->id ?? 0);
        // dd($checkWalletBalance);
        
        // if($checkWalletBalance['status'] != true){
        //     return ['status'=> $checkWalletBalance['status'], 'data' => [], 'message'=> $checkWalletBalance['message']]; 
        // }
        // else{
            $url = Option::where('key','oddek_url')->first();
            $waurl = $url->value."/api/send.php";

            $paramDataArray = [
                'number' => '91'.$dataArr['number'],
                'type' => 'text',
                'message' => $dataArr['message'],
                'instance_id' => $dataArr['instance_id'],
                'access_token' => $dataArr['access_token']
            ];
            
            $paramData = http_build_query($paramDataArray);
            
            $ch = curl_init();              
            $getUrl = $waurl."?".$paramData;
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_URL, $getUrl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 80);
            $response = curl_exec($ch);
            $output = json_decode($response);
            $err = curl_error($ch);
            
            if ($err) {
                return ['status'=> false, 'data' => $err, 'message'=> 'Link not shared']; 
            } else { 
                if($output == null || $output->status == 'error'){
                    return ['status'=> false, 'data' => $response, 'message'=> 'Link not shared']; 
                }else{
                    // Msg Deduct from wallet
                    // $messageWallet->total_messages = $messageWallet->total_messages - 1;
                    // $messageWallet->save();

                    //  Customer ID 
                    $customer_id = 0;
                    $customer = Customer::where('mobile', $dataArr['number'])->first();
                    if($customer != null){
                        $customer_id = $customer->id;
                    }

                    $offer_id = 'NULL';
                    if(isset($dataArr['offer_id'])){
                        $offer_id = $dataArr['offer_id'];
                    }

                    // save Message in History
                    $messageHistory = new MessageHistory();
                    $messageHistory->user_id = Auth::id();
                    $messageHistory->customer_id = $customer_id;
                    $messageHistory->offer_id = $offer_id;
                    $messageHistory->mobile = '91'.$dataArr['number'];
                    $messageHistory->content = $dataArr['message'];
                    $messageHistory->related_to = "Sent by Partner";
                    $messageHistory->sent_by = "Partner";
                    $messageHistory->sent_via = 'wa';
                    $messageHistory->is_sent_auto_msg = 0;
                    $messageHistory->status = 1;
                    $messageHistory->save();

                    // Insert in Deduction History Table
                    $customer = Customer::where('mobile', $dataArr['number'])->orderBy('id', 'desc')->first();

                    // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                    // DeductionHelper::deductWalletBalance(Auth::id(), $deductionWaDetail->id ?? 0, 0, $messageHistory->id, $customer->id ?? 0, 0);

                    return ['status' => true, 'message' => 'Link shared successfully!'];
                }
                
            }
        // }
    }
    */

}
