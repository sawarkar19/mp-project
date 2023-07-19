<?php

namespace App\Http\Controllers\Business;

use Auth;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Customer;
use App\Models\ShortLink;
use App\Models\OfferReward;
use App\Models\UserChannel;

use App\Models\ContactGroup;
use App\Models\UserSocialConnection;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\MessageWallet;


use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\AutoShareTiming;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;
use App\Models\OfferSubscriptionReward;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Jobs\UpdateSocialConnectionSalesPerson;
use App\Http\Controllers\Business\CommonSettingController;

use App\Helper\Deductions\DeductionHelper;

class ShareAndRewardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function index($channel_id)
    {
        $channel_id = \Request::segment(3);

        $settings = OfferReward::where('user_id',Auth::id())->where('channel_id',$channel_id)->first();
        $isChannelActive = UserChannel::whereChannelId(3)->whereUserId(Auth::id())->first('status');
        if($settings == null){
            $settings = new OfferReward;
            $settings->type = 'Free';
            // $settings->details = [
            //     'discount_perclick' => '',
            //     'minimum_click' => '',
            //     'maximum_click' => '',
            //     'pending_click' => ''
            // ];
            $settings->details = [];
        }else{
            if($settings->type == 'Free'){
                $settings->details = [];
            }else{
                $settings->details = json_decode($settings->details, true);
            }
            
        }

        // dd($settings->details);        
        $routes = RouteToggleContoller::routeDetail($channel_id, Auth::id());

        $timings = AutoShareTiming::where('status', 1)->get();
        
        $groups = ContactGroup::where('user_id', Auth::id())->get();

        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();

        $businessDetail->selected_groups = explode(',', $businessDetail->selected_groups);
        
        $notification_list = CommonSettingController::getNotification();

        $planData = CommonSettingController::getBusinessPlanDetails();

        $has_reward_setting = 0;
        if($planData['share_and_reward_settings'] != ''){
            $has_reward_setting = 1;
        }

        // Update Social Connections
        app('App\Http\Controllers\Business\SocialConnectController')->updateUserConnections();

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first(); 
        $isConnectAnySocialMedia = 1;
        if($userSocialConnection!=NULL){
            if(
                ($userSocialConnection->is_facebook_auth ==0 || $userSocialConnection->is_facebook_auth == NULL) && 

                // ($userSocialConnection->is_twitter_auth ==0) && 

                ($userSocialConnection->is_linkedin_auth ==0 || $userSocialConnection->is_linkedin_auth == NULL) &&

                ($userSocialConnection->is_instagram_auth == 0 || $userSocialConnection->is_instagram_auth == NULL) && 

                ($userSocialConnection->is_youtube_auth == 0 || $userSocialConnection->is_youtube_auth == NULL)
            ){
                $isConnectAnySocialMedia = 0;
            }
        }
        else{
            $isConnectAnySocialMedia = 0;
        }

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());

        return view('business.share-and-rewards.index', compact(['routes', 'notification_list','planData','channel_id','settings', 'timings', 'groups','businessDetail','has_reward_setting', 'isConnectAnySocialMedia', 'userBalance','isChannelActive']));
    }

    public function store(Request $request){

        // return response()->json($request);

        /* Restrict Sale Person */
        if(Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0){
            return response()->json(
                ['status'=> false,'message'=> "You are not authorised to perform this action."]
            );
        }
        
        $validate = $this->validateSetting($request);
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message']]
                );
        }
        $details = $this->getSettingData($request);

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());

        $userData=User::where('id',Auth::id())->first();
        
        if($userData->current_account_status=='paid'){
            if($userBalance['wallet_balance'] <= 0 && ($request->type == 'Gift' || $request->type == 'Percentage Discount' || $request->type == 'Fixed Amount' || $request->type == 'Cash Per Click' || $request->type == 'No Reward')){
                return response()->json(
                    ['status'=> false,'message'=> config('constants.payment_alert')]
                );
            }
        }else{
           if($request->type == 'Gift' || $request->type == 'Percentage Discount' || $request->type == 'Fixed Amount' || $request->type == 'Cash Per Click' || $request->type == 'No Reward'){
                return response()->json(
                    ['status'=> false,'message'=> config('constants.payment_alert')]
                );
            } 
        }

        $settings = OfferReward::where('user_id',Auth::id())->where('channel_id',$request->channel_id)->first();
        if($settings == null){
            $settings = new OfferReward;
            $settings->user_id = Auth::id();
            $settings->channel_id = $request->channel_id;
        }
        $settings->type = $request->type;
        $settings->details = json_encode($details);
        $settings->save();

        /* Update Social Channels for Sales Person */
        dispatch(new UpdateSocialConnectionSalesPerson());

        return response()->json(["status" => true, "message" => "Settings updated successfully!."]);

    }

    public function getSettingData($request){
        $data = array();

        if($request->type == 'Cash Per Click'){
            $data['discount_perclick'] = $request->discount_perclick;
            $data['maximum_click'] = $request->maximum_click;
            $data['pending_click'] = $request->maximum_click;
        }

        if($request->type == 'Fixed Amount'){
            $data['discount_amount'] = $request->discount_amount;
        }

        if($request->type == 'Percentage Discount'){
            $data['discount_percent'] = $request->discount_percent;
        }

        if($request->type == 'Gift'){
            $data['gift'] = $request->gift;
        }
        $data['minimum_click'] = $request->minimum_click;

        return $data;
    }

    public function autoShareSettings(Request $request){
        // if(!isset($request->auto_share_timing_id) && !isset($request->send_when_start)){
        //     return response()->json(['status' => false, 'message' => 'Please select settings.']);
        // }

        // if(isset($request->send_when_start) && !isset($request->selected_groups)){
        //     return response()->json(['status' => false, 'message' => 'Please select contact groups.']);
        // }

        // if(!isset($request->send_when_start) && isset($request->selected_groups)){
        //     return response()->json(['status' => false, 'message' => 'Please check Send when new offer start option.']);
        // }

        // if(!isset($request->share_to_subscribed_customers) && isset($request->auto_share_timing_id)){
        //     return response()->json(['status' => false, 'message' => 'Please check Share With Subscribers option.']);
        // }

        // if(isset($request->share_to_subscribed_customers)){
        //     $auto_share_timing_id = isset($request->auto_share_timing_id) ? $request->auto_share_timing_id : 1;
        // }else{
        //     $auto_share_timing_id = '';
        // }


        if(!isset($request->auto_share_timing_id) && isset($request->share_to_subscribed_customers)){
            return response()->json(['status' => false, 'message' => 'Please select share timing.']);
        }

        if(isset($request->auto_share_timing_id) && !isset($request->share_to_subscribed_customers)){
            return response()->json(['status' => false, 'message' => 'Please check share with subscribers checkbox.']);
        }

        if(!isset($request->share_to_subscribed_customers)){
            $auto_share_timing_id = '';
            $share_to_subscribed_customers = 0;
        }else{
            $auto_share_timing_id = $request->auto_share_timing_id;
            $share_to_subscribed_customers = 1;
        }


        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        $businessDetail->auto_share_timing_id = $auto_share_timing_id;
        $businessDetail->share_to_subscribed_customers = $share_to_subscribed_customers;
        // $businessDetail->send_when_start = isset($request->send_when_start) ? 1 : 0;
        // $businessDetail->selected_groups = isset($request->selected_groups) ? implode(',', $request->selected_groups) : '';
        $businessDetail->save();

        return response()->json(['status' => true, 'message' => 'Auto Share Settings Updated.']);

        // dd($businessDetail);
    }

    public function validateSetting($request){
        //dd($request->all());
        if($request->type == 'Cash Per Click'){
            if($request->discount_perclick == ''){
                return ["status" => false, "message" => "Discount Per Click field can not be empty."];
            }

            if($request->maximum_click == ''){
                return ["status" => false, "message" => "Maximum click field can not be empty."];
            }
        }

        if($request->type == 'Fixed Amount'){
            if($request->discount_amount == ''){
                return ["status" => false, "message" => "Discount Amount field can not be empty."];
            }
        }

        if($request->type == 'Percentage Discount'){
            if($request->discount_percent == ''){
                return ["status" => false, "message" => "Discount Percent field can not be empty."];
            }
        }

        if(in_array($request->type, ['Cash Per Click', 'Fixed Amount', 'Percentage Discount'])){
            if($request->minimum_click == ''){
                return ["status" => false, "message" => "Minimum click field can not be empty."];
            }
        }

        if($request->type == 'Cash Per Click'){
            if($request->maximum_click <= $request->minimum_click){
                return ["status" => false, "message" => "Maximum click should greater than minimum click."];
            }
        }

        if($request->type == 'Gift'){
            if($request->gift == ''){
                return ["status" => false, "message" => "Gilf field can not be empty."];
            }
        }

        return ["status" => true, "message" => "Validated successfully."];
    }

    public function sendShareChallenge(Request $request){
        $customer = Customer::where('mobile', $request->mobile)->first();
        if($customer != null){
            $businessCustomer = BusinessCustomer::where('user_id', Auth::id())->where('customer_id', $customer->id)->first();

            if($businessCustomer != null){
                $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();

                // dd($businessCustomer);
                $offer = Offer::where('user_id', $businessDetail->user_id)->where('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->first();

                /* check if already subscribed */
                $subscription = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $customer->id)->where('status','1')->first();
                
                if($subscription == ''){
                    
                    $type = 'future';
                    $randomString = UuidTokenController::eightCharacterUniqueToken(8);
                    $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
                    $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
                    
                    if($tokenData['status'] == true){
                        $tokenData = UuidTokenController::findUniqueToken($type, $addedCharacter);
                    }

                    /* Domain */
                    $option = Option::where('key', 'site_url')->first();
                    
                    if($offer->website_url == ''){
                        $share_link = '/f/'.$offer->uuid.'?share_cnf='.$tokenData['token'];
                    }else{
                        $url = rtrim($offer->website_url,"/");
                        $share_link = $url.'/?o='.$offer->uuid.'&share_cnf='.$tokenData['token'];
                    }
                    $uuid_code = $tokenData['token'];

                    /* Get Short Link */
                    if($offer->website_url != ''){
                        $long_link = $share_link;
                    }else{
                        $long_link = $option->value.$share_link;
                    }
                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $offer->user_id ?? 0, "instant_challenge");

                    if($shortLinkData->original["success"] !== false){
                        $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',3)->first();
                        if($settings != null){
                            /* Share link */
                            $short_link = "https://opnl.in/".$shortLinkData->original["code"];
                            
                            $biz_name = $groupSettings->business_name ?? 'business owner';
                            if(strlen($biz_name) > 28){
                                $biz_name = substr($biz_name,0,28).'..';
                            }

                            $message = "You are eligible for Challenge\nClick: opnl.in/".$shortLinkData->original["code"]."\nShare to your contacts to get benefits on your next purchase with ".$biz_name."\nOPNLNK";
                            
                            $followThisLink = "Follow this link:";
                            
                            $whatsapp_msg = "Hello again!\n\nWe have another exciting and simple to do challenge for you. All you need to do is share the provided link with your friends and family, and get targeted clicks.\n\nOnce you've completed this task, you'll receive a prize as a benefit for your effort on your next purchase!\n\nDon't miss out on this opportunity to earn some extra prizes while supporting *".$biz_name."*. \n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]."  to the offer page for more details on this task and the reward.\n\nThank you for your continued support!";

                            $params = [
                                "mobile" => "91".$customer->mobile,
                                "message" => $message,
                                "channel_id" => 3,
                                'whatsapp_msg' => $whatsapp_msg,
                                'sms_msg' => $message,
                                "user_id" => $offer->user_id
                            ];
                            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
                            
                            $link_by_sms = $link_by_wa = false;
                            $err_by_sms = $err_by_wa = '';
                            
                            if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                                $link_by_wa = true;

                                $messageWallet = MessageWallet::where('user_id', $offer->user_id)->first();
                                $messageWallet->total_messages = $messageWallet->total_messages - 1;
                                $messageWallet->save();
                            }else{
                                $err_by_wa = $sendLink->original["wa"]["message"];
                            }

                            if(isset($sendLink->original["sms"]["Status"]) && $sendLink->original["sms"]["Status"] == "1"){
                                $link_by_sms = true;
                            }else{  
                                if(isset($sendLink->original["sms"]["message"])){
                                    $err_by_sms = $sendLink->original["sms"]["message"];
                                }else{
                                    $err_by_sms = $sendLink->original["sms"];
                                }
                            }
                            
                            if($link_by_sms == true || $link_by_wa == true){
                                $deduct = 0;

                                if($link_by_sms == true){
                                    
                                    $wel_sms_message = new MessageHistory;
                                    $wel_sms_message->user_id = $offer->user_id;
                                    $wel_sms_message->channel_id = 3;
                                    $wel_sms_message->customer_id = $customer->id;
                                    $wel_sms_message->offer_id = $offer->id;
                                    $wel_sms_message->mobile = "91".$customer->mobile;
                                    $wel_sms_message->content = $message;
                                    $wel_sms_message->related_to = "Share and reward";
                                    $wel_sms_message->sent_via = 'sms';
                                    $wel_sms_message->status = 1;
                                    $wel_sms_message->save();
                                    
                                    $deduct++;
                                }
                                if($link_by_wa == true){
                                    $wel_wa_message = new MessageHistory;
                                    $wel_wa_message->user_id = $offer->user_id;
                                    $wel_wa_message->channel_id = 3;
                                    $wel_wa_message->customer_id = $customer->id;
                                    $wel_wa_message->offer_id = $offer->id;
                                    $wel_wa_message->mobile = "91".$customer->mobile;
                                    $wel_wa_message->content = $message;
                                    $wel_wa_message->related_to = "Share and reward";
                                    $wel_wa_message->sent_via = 'wa';
                                    $wel_wa_message->status = 1;
                                    $wel_wa_message->save();

                                    $deduct++;
                                }

                                /* Deduct message */
                                $messageWallet = MessageWallet::where('user_id', $offer->user_id)->first();
                                $messageWallet->total_messages = $messageWallet->total_messages - $deduct;
                                $messageWallet->save();

                                $incomplete = OfferSubscription::where('user_id', $offer->user_id)->where('channel_id', 3)->where('customer_id', $customer->id)->where('status','3')->first();
                                if($incomplete != null){  
                                    $parent_id = $incomplete->id;
                                }else{
                                    $parent_id = '';
                                }

                                $shortLink = new ShortLink;
                                $shortLink->uuid = $shortLinkData->original["code"];
                                $shortLink->link = $long_link;
                                $shortLink->save();

                                $subscription = new OfferSubscription;
                                $subscription->parent_id = $parent_id;
                                $subscription->channel_id = 3;
                                $subscription->user_id = $offer->user_id;
                                $subscription->created_by = $offer->user_id;
                                $subscription->offer_id = $offer->id;
                                $subscription->short_link_id = $shortLink->id;
                                $subscription->customer_id = $customer->id;
                                $subscription->uuid = $uuid_code;
                                $subscription->share_link = $share_link;
                                $subscription->save();
                        
                                $offerSubscriptionReward = new OfferSubscriptionReward;
                                $offerSubscriptionReward->user_id = $offer->user_id;
                                $offerSubscriptionReward->offer_id = $offer->id;
                                $offerSubscriptionReward->offer_subscription_id = $subscription->id;
                                $offerSubscriptionReward->type = $settings->type;
                                $offerSubscriptionReward->details = $settings->details;
                                $offerSubscriptionReward->save();

                                return response()->json([
                                    "status" => true, 
                                    "message" => "Challenge sent successfully.",
                                    "link" => $short_link
                                ]);
                            }else{
                                return response()->json([
                                    "status" => false, 
                                    "message" => "Failed to send challenge."
                                ]);
                            }
                        }else{
                            return response()->json([
                                "status" => false, 
                                "message" => "Share reward setting not found."
                            ]);
                        }
                    }else{
                        return response()->json([
                            "status" => false, 
                            "message" => "Link not created."
                        ]);
                    }
                }else{
                    return response()->json([
                        "status" => false, 
                        "message" => "Challenge already sent."
                    ]);
                }
            }else{
                return response()->json([
                    "status" => false, 
                    "message" => "Mobile number does not exists in your contacts."
                ]);
            }
        }else{
            return response()->json([
                "status" => false, 
                "message" => "Mobile number does not exists in your contacts."
            ]);
        }
    }

}
