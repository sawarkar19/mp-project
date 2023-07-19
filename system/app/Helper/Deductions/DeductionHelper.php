<?php 
namespace App\Helper\Deductions;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Deduction;

use Illuminate\Http\Request;
use App\Models\MessageWallet;
use App\Models\MessageHistory;
use App\Models\DeductionHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\ShareChallengeContact;
use App\Models\Option;

class DeductionHelper 
{
    public static function getUserWalletBalance($user_id=0)
    {
        $messageWallet = MessageWallet::where('user_id', $user_id)->first();
        if($messageWallet==NULL){
            $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
            $options=Option::whereIn('key',$key)->pluck('value')->toArray();
            $messageWallet = new MessageWallet;
            $messageWallet->user_id = $user_id;
            $messageWallet->wallet_balance = 0;
            $messageWallet->minimum_balance = $options[0];
            $messageWallet->messaging_api_daily_limit = $options[1];
            $messageWallet->messaging_api_daily_free_limit = $options[2];
            $messageWallet->total_messages = 0;
            $messageWallet->save();
        }

        $walletBalance = (float) $messageWallet->wallet_balance;
        $res = [ 'status' => true, 'message' => 'Your wallet balance', 'wallet_balance'=> $walletBalance ];
        return $res;
    }

    public static function getActiveDeductionDetail($column, $value)
    {
        return $deductionDetail = Deduction::where($column, $value)->where('status', 1)->first();
    }

    // Single Person Check
    public static function checkWalletBalance($user_id=0, $deduction_id=0)
    {
        $messageWallet = MessageWallet::where('user_id', $user_id)->first();
        if($messageWallet==NULL){
            $res = [ 'status' => false, 'message' => 'Wallet not found!' ];
            return $res;
        }

        $deductionDetail = Deduction::where('id', $deduction_id)->where('status', 1)->first();
        if($deductionDetail==NULL){
            $res = [ 'status' => false, 'message' => 'Deduction amount not found!' ];
            return $res;
        }

        $walletBalance = (float) $messageWallet->wallet_balance;
        $deductionAmout = (float) $deductionDetail->amount ?? 0;
        
        $walletBalanceAmount = $walletBalance - $deductionAmout;
        if($walletBalanceAmount < 0){
            $res = [ 'status' => false, 'message' => 'Your wallet balance is low, please recharge!' ];
            return $res;
        }
        else{
            $res = [ 'status' => true, 'message' => 'Wallet balance available!' ];
            return $res;
        }
    }

    public static function checkWalletBalanceWithNoOfPer($user_id=0, $deduction_id=0, $noOfPer=1)
    {
        $messageWallet = MessageWallet::where('user_id', $user_id)->first();
        if($messageWallet==NULL){
            $res = [ 'status' => false, 'message' => 'Wallet not found!' ];
            return $res;
        }

        $deductionDetail = Deduction::where('id', $deduction_id)->where('status', 1)->first();
        // dd($deductionDetail);
        if($deductionDetail==NULL){
            $res = [ 'status' => false, 'message' => 'Deduction amount not found!' ];
            return $res;
        }

        $walletBalance = (float) $messageWallet->wallet_balance;
        $deductionAmout = (float) $deductionDetail->amount;//$deductionDetail->amount * $noOfPer ?? 0;
        
        $walletBalanceAmount = $walletBalance - $deductionAmout;
        if($walletBalanceAmount < 0){
            $res = [ 'status' => false, 'message' => 'Your wallet balance is low, please recharge!' ];
            return $res;
        }
        else{
            $res = [ 'status' => true, 'message' => 'Wallet balance available!' ];
            return $res;
        }
    }



    public static function checkWalletBalanceWithChannel($user_id=0, $channel_id=0, $deductionSlugs=[])
    {
        $messageWallet = MessageWallet::where('user_id', $user_id)->first();
        if($messageWallet==NULL){
            $res = [ 'status' => false, 'message' => 'Wallet not found!' ];
            return $res;
        }
        $route = \App\Http\Controllers\Business\RouteToggleContoller::routeDetail($channel_id, $user_id);
        $route_wa = $route->wa ?? 0;
        $route_sms = $route->sms ?? 0;

        $checkAmt = 0;
        foreach ($deductionSlugs as $key => $slug){
            $deductionDetail = Deduction::where('slug', $slug)->where('status', 1)->first();
            if($deductionDetail!=NULL){
                if($slug=='send_sms' && $route_sms!='0'){
                    $checkAmt += (float)$deductionDetail->amount ?? 0;
                }
                else if($slug=='send_whatsapp' && $route_wa!='0'){
                    $checkAmt += (float)$deductionDetail->amount ?? 0;
                }
                else if($slug!='send_sms' && $slug!='send_whatsapp'){
                    $checkAmt += (float)$deductionDetail->amount ?? 0;
                }
            }
        }
        
        $walletBalance = (float) $messageWallet->wallet_balance;
        $deductionAmout = (float) $checkAmt;
        
        $walletBalanceAmount = $walletBalance - $deductionAmout;
        if($walletBalanceAmount <= 0){
            $res = [ 'status' => false, 'message' => 'Your wallet balance is low, please recharge!' ];
            return $res;
        }
        else{
            $res = [ 'status' => true, 'message' => 'Wallet balance available!' ];
            return $res;
        }
    }

    public static function deductWalletBalance($user_id=0, $deduction_id=0, $channel_id=0, $message_history_id=0, $customer_id=0, $employee_id=0)
    {
        $messageWallet = MessageWallet::where('user_id', $user_id)->first();
        if($messageWallet==NULL){
            $res = [ 'status' => false, 'message' => 'Wallet not found!' ];
            return $res;
        }

        $deductionDetail = Deduction::where('id', $deduction_id)->where('status', 1)->first();
        if($deductionDetail==NULL){
            $res = [ 'status' => false, 'message' => 'Deduction amount not found!' ];
            return $res;
        }

        $walletBalance = (float) $messageWallet->wallet_balance;
        $deductionAmout = (float) $deductionDetail->amount ?? 0;
        
        $walletBalanceAmount = $walletBalance - $deductionAmout;

        if($walletBalanceAmount < 0){
            $res = [ 'status' => false, 'message' => 'Your wallet balance is low, please recharge!' ];
            return $res;
        }

        $deductionHistory = new DeductionHistory;
        $deductionHistory->user_id = $user_id;
        $deductionHistory->channel_id = $channel_id;
        $deductionHistory->message_history_id = $message_history_id;
        $deductionHistory->deduction_id = $deduction_id;
        $deductionHistory->deduction_amount = $deductionAmout;
        $deductionHistory->customer_id = $customer_id;
        $deductionHistory->employee_id = $employee_id;

        if($deductionHistory->save()){
            $messageWallet->wallet_balance = $walletBalanceAmount;
            $messageWallet->save();

            $res = [ 'status' => true, 'message' => 'Wallet amount deducted and saved in History!', 'data' => $deductionHistory ];
            return $res;
        }
        else{
            $res = [ 'status' => false, 'message' => 'Unable to deduct wallet amount' ];
            return $res;
        }
    }

    public static function setMessageHistory($user_id=0, $channel_id=0, $mobile="", $message="", $related_to="", $sent_via="sms", $status = 1, $offer_id="NULL")
    {
        /* Customer ID */
        $customer_id = 0;
        $mobile_number = substr($mobile, 2);
        $customer = Customer::where('mobile', $mobile_number)->first();
        if($customer != null){
            $customer_id = $customer->id;
        }

        $sms_message = new MessageHistory;
        $sms_message->user_id = $user_id;
        $sms_message->channel_id = $channel_id;
        $sms_message->customer_id = $customer_id;
        $sms_message->offer_id = $offer_id;
        $sms_message->mobile = $mobile;
        $sms_message->content = $message;
        $sms_message->related_to = $related_to;
        $sms_message->sent_via = $sent_via;
        $sms_message->status = $status;
        $sms_message->save();

        return $sms_message->id;
    }

    public static function setOfferContactHistory($user_id=0, $customer_id=0, $offer_id=0, $ShareChallengeContactstatus=0, $shareContactId=0)
    {
        if($shareContactId != 0){
            $contactmsg = ShareChallengeContact::find($shareContactId);
        }else{
            $contactmsg = new ShareChallengeContact;
        }
        $contactmsg->user_id = $user_id;
        $contactmsg->customer_id = $customer_id;
        $contactmsg->offer_id = $offer_id;
        $contactmsg->status = $ShareChallengeContactstatus;
        $contactmsg->save();
        return $contactmsg;
    }
    public static function checkDeductionHistory($user_id=0, $channel_id=0, $deduction_id=0)
    {
        $where=array();
        if(isset($user_id)){
            $where[] = ['user_id', '=', $user_id];
        }
        if(isset($deduction_id)){
            $where[] = ['channel_id', '=', $channel_id];
        }
        if(isset($deduction_id)){
            $where[] = ['deduction_id', '=', $deduction_id];
        }
        $deductionHistory = DeductionHistory::whereDate('created_at', Carbon::today())->where($where)->first();
        if($deductionHistory==NULL){
            $res = [ 'status' => false, 'message' => 'Deduction history not found!' ];
            return $res;
        }else{
            $res = [ 'status' => true,'message' => 'Deduction history found!' ];
            return $res;
        }
        
    }

}

    

    



?>