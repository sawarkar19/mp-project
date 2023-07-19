<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;

use Illuminate\Http\Request;

use App\Models\Userplan;
use App\Models\User;
use App\Models\UserChannel;
use App\Models\Channel;
use App\Models\Option;
use App\Models\Deduction;
use App\Models\MessageWallet;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Auth;
use DeductionHelper;

class ChannelController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public static function all_channels()
    {
        $channels = Channel::where('status', '1')->get();
        return $channels;
    }

    public static function msg_channels()
    {
        $channels = Channel::where('status', '1')->where('is_use_msg', '1')->get();
        return $channels;
    }

    public static function no_msg_channels()
    {
        $channels = Channel::where('status', '1')->where('is_use_msg', '0')->get();
        return $channels;
    }
	
	public function index()
    {
        $channels = Channel::with('user_channel')->whereIn('id',[1,4,5])->where('status','1')->orderBy('ordering','asc')->get();

        $challenges = Channel::with('user_channel')->whereIn('id',[2,3])->where('status','1')->orderBy('ordering','asc')->get();

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $MsgDeduction=Deduction::where('slug','=','send_sms')->first();
        $MsgAPIDeduction=Deduction::where('slug','=','messaging_api_cost')->first();
        $MsgAPIDeductionValue=$MsgAPIDeduction->amount;
        $MsgDeductionValue=$MsgDeduction->amount;
        $deductionhistory=DeductionHelper::checkDeductionHistory(Auth::id(), 4,7);
        $MsgApidh=0;
        if($deductionhistory['status'] ==true){
            $MsgApidh=1;
        }
        
        return view('business.channels.index', compact('notification_list','planData', 'channels','challenges','MsgAPIDeductionValue','MsgDeductionValue','MsgApidh'));
    }

    public function disableEnableChannel(Request $request)
    {
        $option = Option::where('key','social_post_url')->first();
        $url = $option->value."/api/change-status";
        $userDet=User::where('id',Auth::id())->first();
        if ($request->status == 0) {
            UserChannel::where(['channel_id' => $request->id])->whereUserId(Auth::id())->update(['status' => $request->status, 'updated_at'=> Date('Y-m-d H:i:s')]);

            $response = Http::withToken(Auth::user()->social_post_api_token)->post($url, [
                'status' => $request->status,
            ]);

            return $response;
        }else{

            $response = Http::withToken(Auth::user()->social_post_api_token)->post($url, [
                'status' => $request->status,
            ]);

            if($userDet->current_account_status=='paid' && $request->id==4){

                    /*get user wallet balance*/
                    $userwalletbal=MessageWallet::where('user_id',Auth::id())->first();

                    /*get standard deduction amount for service*/
                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'messaging_api_cost');

                    /*get todays deduction history for service*/  
                    $deductionhistory=DeductionHelper::checkDeductionHistory(Auth::id(), 4,7);

                    /*check if user have balance to on the service or not*/
                    if($userwalletbal->wallet_balance>=$deductionSmsDetail->amount){
                        
                        /*check if todays deduction history for service found against user*/
                        if($deductionhistory['status'] !=true){
                            $channel_id = 4;
                            DeductionHelper::deductWalletBalance(Auth::id(), $deductionSmsDetail->id ?? 0, $channel_id,0,0,0);
                        }
                    }else{
                        if($deductionhistory['status'] !=true){
                            return response()->json(["status" => false, "message" => 'Low']);
                        }
                    }
            }
            if($userDet->current_account_status=='paid'){
              $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel(Auth::id(), $request->id, ['send_sms']);
                if($checkWalletBalance['status'] != true){
                    return response()->json(["status" => $checkWalletBalance['status'], "message" => 'Low']);
                }  
            }
             
            UserChannel::where(['channel_id' => $request->id])->whereUserId(Auth::id())->update(['status' => $request->status, 'updated_at'=> Date('Y-m-d H:i:s')]);

            $tasks = ["facebook", "instagram", "twitter", "linkedIn"];
            foreach ($tasks as $key => $task){
                app("App\Http\Controllers\Business\SocialConnectController")->postOngoingOfferToSocialMedia($task);
            }
            
            return $response;
        }

    }
}
