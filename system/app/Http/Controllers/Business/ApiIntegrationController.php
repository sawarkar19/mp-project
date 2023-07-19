<?php

namespace App\Http\Controllers\Business;

use URL;
use Auth;
use App\Models\User;
use App\Models\Userplan;
use App\Models\OfferReward;
use App\Models\Transaction;
use App\Models\WhatsappApi;
use Illuminate\Http\Request;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;
use App\Models\MessageTemplateSchedule;
use App\Models\OfferSubscriptionReward;

class ApiIntegrationController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function apiKeys($channel_id){

        $apiData = WhatsappApi::where('user_id',Auth::id())->orderBy('id', 'desc')->first();

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $businessDetails = BusinessDetail::where('user_id', Auth::id())->first();
        $message = "Thanks for visiting and choosing ".$businessDetails->business_name."\nWe would be pleased to serve you again.\nOPNLNK";

        $domain = URL::to('/');
        $api_url = $domain.'/api/v1/WHATSAPP_MESSAGE_API/send?username='.$apiData->username.'&password='.$apiData->password.'&mobile=91XXXXXXXXXX&sendername='.$apiData->sendername.'&message='.$message.'&routetype=1';

        $routes = RouteToggleContoller::routeDetail($channel_id, Auth::id());

        return view('business.apis.keys', compact('routes','apiData','notification_list', 'planData','api_url', 'message'));
    }

    public function apiDocs(){

        $apiData = WhatsappApi::where('user_id',Auth::id())->orderBy('id', 'desc')->first();
        if($apiData == null){
            return redirect()->route('business.settings');
        }
        #dd($apiData);

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $domain = URL::to('/');
        $businessDetails = BusinessDetail::where('user_id', Auth::id())->first();
        $message = "Thanks for visiting and choosing ".$businessDetails->business_name."\nWe would be pleased to serve you again.\nOPNLNK";
         
        $api_url = $domain.'/api/v1/WHATSAPP_MESSAGE_API/send?username=WAAPIXXX&password=XXXXXXXX&mobile=91XXXXXXXXXX&sendername=XXXXXXXX&message='.$message.'&routetype=1';

        return view('business.apis.docs', compact('apiData','notification_list', 'planData','api_url','message'));
    }
}
