<?php

namespace App\Http\Controllers\Admin;

use Auth;

use Carbon\Carbon;
use App\Models\Plan;

use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Customer;
use App\Models\EmailJob;
use App\Models\Employee;
use App\Models\Recharge;
use App\Models\Userplan;
use App\Models\WpMessage;
use App\Models\DirectPost;
use App\Models\InstantTask;
use App\Models\OfferReward;
use App\Models\PlanFeature;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\Notification;
use App\Models\RedeemDetail;
use App\Models\UserEmployee;
use App\Models\UserRecharge;
use App\Models\WhatsappPost;
use Illuminate\Http\Request;

use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use App\Models\Userrechargemeta;

use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;
use App\Models\WhatsappFestivalPost;
use Illuminate\Support\Facades\Hash;
use App\Models\MessageTemplateSchedule;

class CommonSettingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    static function getNotification(){
        $notifications = EmailJob::where('user_id', Auth::id())
            ->where('mark_deleted', '0')
            ->where('mark_read', '0')
            ->orderBy('created_at', 'desc')
            // ->limit(3)
            ->get();

        return $notifications;
    }
	
	static function getDatesArray($planId,$firstMonthStartDate){
		$planDetails = Plan::where('id',$planId)->first();
        // dd($planDetails);
		if(!empty($planDetails)){
				$toatalDays = $planDetails->days;
				$months = (int)( $toatalDays / 30 );
				$datesArray = [];
				for($i=1; $i<=$months;$i++){
						$createdAt = Carbon::parse($firstMonthStartDate);
						$newDateTime = $createdAt->addDays(29)->format('Y-m-d');
						$datesArray[] = ['startDate'=>Carbon::parse($firstMonthStartDate)->format('Y-m-d'),'endDate'=>$newDateTime];
						$appendDay = Carbon::parse($newDateTime);
						$newAppendDay = $appendDay->addDays(1)->format('Y-m-d');
						$firstMonthStartDate = $newAppendDay;
				}
		}
		return $datesArray;
	}


    static function getBusinessPlanDetails(){

        $planData = array();

        $purchasedChannelIds = UserChannel::where('user_id',Auth::id())->pluck('channel_id')->toArray();
        $planData['purchasedChannelIds'] = $purchasedChannelIds;
        if(!empty($purchasedChannelIds)){

            $paidChannels = Channel::with('user_channel')->whereIn('id', $purchasedChannelIds)->orderBy('price','asc')->get();
            $planData['paidChannels'] = $paidChannels;

            $unpaidChannels = Channel::whereNotIn('id', $purchasedChannelIds)->get();
            $planData['unpaidChannels'] = $unpaidChannels;
            
        }

        $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $planData['users'] = $users;
        if(!empty($users)){
            $usedUsers = UserEmployee::with('employee')->where('employee_id', '!=', '')->where('user_id',Auth::id())->get();

            $planData['usedUsers'] = $usedUsers;
        }else{
            $planData['usedUsers'] = 0;
        }

        // dd($planData);

        $message_plan = MessageWallet::where('user_id', Auth::id())->first();
        $planData['message_plan'] = $message_plan;


        /* Current Offer */
        $today = date("Y-m-d");
        $offer = Offer::with('offer_template')->where('user_id',Auth::id())->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();

        if($offer == null){
            /* find upcoming if no current offer available */
            $offer = Offer::with('offer_template')->where('user_id',Auth::id())->where('start_date', '>', $today)->where('status', 1)->orderBy('start_date', 'asc')->first();
        }
        $planData['current_offer'] = $offer;
        $planData['is_posted'] = 0;
        if($offer != ''){
            // Check Instant Task
            $currentOfferInsatntTask = InstantTask::where('user_id', Auth::id())->where('offer_id', $offer->id)->whereNull('deleted_at')->count();
            // $planData['is_posted'] = $offer->social_post__db_id ? 1 : 0;
            $planData['is_posted'] = ($currentOfferInsatntTask > 0) ? 1 : 0;
        }

        /* Whatsapp Settings */
        $wa_session = WhatsappSession::where('user_id', Auth::id())->first();
        $planData['wa_session'] = $wa_session;

        $planData['whatsapp_num'] = '';
        if ($planData['wa_session']) {
            $planData['whatsapp_num'] = $planData['wa_session']->wa_number;
        }

        $planData['userData'] = User::where('id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        // $planData['wa_url'] = Option::where('key', 'oddek_url')->first();
        $planData['wa_api_url'] = Option::where('key', 'wa_api_url')->first();
        $planData['logo_url'] = asset('assets/business/logos');

        /* Instant Reward Settings */
        $planData['instant_reward_settings'] = OfferReward::where('user_id', Auth::id())->where('channel_id', 2)->first();

        /* Share and Reward Settings */
        $planData['share_and_reward_settings'] = OfferReward::where('user_id', Auth::id())->where('channel_id', 3)->first();

        /* Paid user or free */
        $planData['is_paid'] = Transaction::where('user_id', Auth::id())->where('transaction_amount', '>', 0)->first();

        /* Business Details */
        $planData['business_detail'] = BusinessDetail::where('user_id', Auth::id())->first();

        $planData['userSocialConnection'] = UserSocialConnection::where('user_id', Auth::id())->first();
        $planData['getYoutubeTasks'] = InstantTask::where('user_id', Auth::id())->whereIn('task_id', [10,11,12])->whereNull('deleted_at')->count();

        $planData['instantChallengeOfferReward'] = OfferReward::where('user_id', Auth::id())->where('channel_id', 2)->first();
        $planData['sharedChallengeOfferReward'] = OfferReward::where('user_id', Auth::id())->where('channel_id', 3)->first();

        /* setting status data */
        // 1. Profile
        // $created_at = \Carbon\Carbon::parse(Auth::user()->created_at)->format("j M, Y");
        // $planData['statusbar']['profile']['details'] = (Auth::user()->name!=NULL || Auth::user()->email!=NULL || $created_at!=NULL) ? 1 : 0;
        
        // $planData['statusbar']['profile']['reg_number'] = (Auth::user()->mobile!= NULL) ? 1 : 0;
        
        // $profile_completed = 0;
        // foreach ($planData['statusbar']['profile'] as $key => $profile) {
        //     $profile_completed += $profile;
        // }
        // $profile_count = count($planData['statusbar']['profile']);
        // $planData['statusbar']['profile']['profile_per'] = round($profile_completed * 100 / $profile_count);

        // 2. Setting
        $planData['statusbar']['setting']['business_details'] = (isset($planData['business_detail']->business_name) && $planData['business_detail']->business_name!=NULL) ? 1 : 0;
        
        $planData['statusbar']['setting']['business_contact'] = (isset($planData['business_detail']->call_number) && $planData['business_detail']->call_number!=NULL) && (isset($planData['business_detail']->address_line_1) && $planData['business_detail']->address_line_1!=NULL) && (isset($planData['business_detail']->pincode) && $planData['business_detail']->pincode!=NULL) && (isset($planData['business_detail']->city) && $planData['business_detail']->city!=NULL) && (isset($planData['business_detail']->state) && $planData['business_detail']->state!=NULL) ? 1 : 0;
        
        $planData['statusbar']['setting']['business_address'] = (isset($planData['business_detail']->billing_address_line_1) && $planData['business_detail']->billing_address_line_1!=NULL) && (isset($planData['business_detail']->billing_pincode) && $planData['business_detail']->billing_pincode!=NULL) && (isset($planData['business_detail']->billing_city) && $planData['business_detail']->billing_city!=NULL) && (isset($planData['business_detail']->billing_state) && $planData['business_detail']->billing_state!=NULL) ? 1 : 0;

        $planData['statusbar']['setting']['social_link'] = (isset($planData['business_detail']->facebook_link) && $planData['business_detail']->facebook_link!=NULL) && (isset($planData['business_detail']->instagram_link) && $planData['business_detail']->instagram_link!=NULL) && (isset($planData['business_detail']->twitter_link) && $planData['business_detail']->twitter_link!=NULL) && (isset($planData['business_detail']->linkedin_link) && $planData['business_detail']->linkedin_link!=NULL) && (isset($planData['business_detail']->youtube_link) && $planData['business_detail']->youtube_link!=NULL) ? 1 : 0;

        $planData['statusbar']['setting']['whatsapp_setting'] = (isset($wa_session) && $wa_session->status=='active') ? 1 : 0;

        $channels = Channel::where('is_use_msg', 1)->orderBy('ordering', 'asc')->get();
        $message_route = 0;
        foreach($channels as $channel){
            $route = app('App\Http\Controllers\Business\RouteToggleContoller')->routeDetail($channel->id, Auth::id());
            if($route->wa==1 || $route->sms==1){
                $message_route = 1;
            }
        }
        $planData['statusbar']['setting']['message_route'] = $message_route;

        $vcard = BusinessVcard::where('status', 1)->get();
        $vcard_setting = 0;
        if($planData['business_detail']->vcard_type =="vcard"){
            $vcard_setting = ($planData['business_detail']->business_card_id != NULL) ? 1 : 0;
        }
        else{
            $vcard_setting = ($planData['business_detail']->webpage_url != NULL) ? 1 : 0;
        }
        $planData['statusbar']['setting']['vcard_setting'] = $vcard_setting;

        $notifications = Notification::where('status', 1)->get();
        $notification_setting = 0;
        foreach ($notifications as $notification){
            $notificationToggle = app('App\Http\Controllers\Business\RouteToggleContoller')->notificationDetail($notification->id, Auth::id());

            if($notificationToggle->wa==1 || $notificationToggle->email==1){
                $notification_setting = 1;
            }
        }
        $planData['statusbar']['setting']['notification_setting'] = $notification_setting;

        $setting_completed = 0;
        foreach ($planData['statusbar']['setting'] as $key => $setting) {
            $setting_completed += $setting;
        }
        $setting_count = count($planData['statusbar']['setting']);
        $planData['statusbar']['setting']['setting_per'] = round($setting_completed * 100 / $setting_count);

        // 3. Social Connect with Social Media
        $planData['statusbar']['social_connect']['facebook'] = isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_facebook_auth ? 1 : 0;

        $planData['statusbar']['social_connect']['instagram'] = isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_instagram_auth ? 1 : 0;

        $planData['statusbar']['social_connect']['twitter'] = isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_twitter_auth ? 1 : 0;

        $planData['statusbar']['social_connect']['linkedin'] = isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_linkedin_auth ? 1 : 0;

        $planData['statusbar']['social_connect']['youtube'] = (isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_youtube_auth) || ($planData['getYoutubeTasks'] > 0) ? 1 : 0;

        $planData['statusbar']['social_connect']['google'] = isset($planData['userSocialConnection']) && $planData['userSocialConnection']->is_google_auth ? 1 : 0;

        $social_connect_completed = 0;
        foreach ($planData['statusbar']['social_connect'] as $key => $social_connect) {
            $social_connect_completed += $social_connect;
        }
        $social_connect_count = count($planData['statusbar']['social_connect']);
        $planData['statusbar']['social_connect']['social_connect_per'] = round($social_connect_completed * 100 / $social_connect_count);

        // 4. Social Connect with Social Media
        $planData['statusbar']['challenge_setting']['instant_challenge'] = (isset($planData['instantChallengeOfferReward']) && $planData['instantChallengeOfferReward']!=NULL) ? 1 : 0;
        $planData['statusbar']['challenge_setting']['shared_challenge'] = (isset($planData['sharedChallengeOfferReward']) && $planData['sharedChallengeOfferReward']!=NULL) ? 1 : 0;

        $challenge_setting_completed = 0;
        foreach ($planData['statusbar']['challenge_setting'] as $key => $challenge_setting) {
            $challenge_setting_completed += $challenge_setting;
        }
        $challenge_setting_count = count($planData['statusbar']['challenge_setting']);
        $planData['statusbar']['challenge_setting']['challenge_setting_per'] = round($challenge_setting_completed * 100 / $challenge_setting_count);

        // 5. Personalised Messages
        $dobMsg = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 7)
            ->orderBy('id', 'DESC')
            ->first();

        $anniMsg = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 8)
            ->orderBy('id', 'DESC')
            ->first();

        $planData['statusbar']['personalised_msg']['dob'] = isset($dobMsg->is_scheduled) && $dobMsg->is_scheduled ? 1 : 0;
        $planData['statusbar']['personalised_msg']['anni'] = isset($anniMsg->is_scheduled) && $anniMsg->is_scheduled ? 1 : 0;
        
        $personalised_msg_completed = 0;
        foreach ($planData['statusbar']['personalised_msg'] as $key => $personalised_msg) {
            $personalised_msg_completed += $personalised_msg;
        }
        $personalised_msg_count = count($planData['statusbar']['personalised_msg']);
        $planData['statusbar']['personalised_msg']['personalised_msg_per'] = round($personalised_msg_completed * 100 / $personalised_msg_count);


        /* Not created a single offer */
        $planData['no_created_a_single_offer'] = Offer::where('user_id', Auth::id())->count();

        // dd($planData['statusbar'], $dobMsg, $anniMsg);
        return $planData;
    }

    static function getEmployeePlanDetails($business_id){

        $planData = array();

        $purchasedChannelIds = UserChannel::where('user_id',$business_id)->pluck('channel_id')->toArray();
        $planData['purchasedChannelIds'] = $purchasedChannelIds;
        if(!empty($purchasedChannelIds)){

            $paidChannels = Channel::with('user_channel')->whereIn('id', $purchasedChannelIds)->orderBy('price','asc')->get();
            $planData['paidChannels'] = $paidChannels;

            $unpaidChannels = Channel::whereNotIn('id', $purchasedChannelIds)->get();
            $planData['unpaidChannels'] = $unpaidChannels;
            
        }

        $users = UserEmployee::with('employee')->where('user_id',$business_id)->get();
        $planData['users'] = $users;
        if(!empty($users)){
            $usedUsers = UserEmployee::with('employee')->where('employee_id', '!=', '')->where('user_id',$business_id)->get();

            $planData['usedUsers'] = $usedUsers;
        }else{
            $planData['usedUsers'] = 0;
        }

        // dd($planData);

        $message_plan = MessageWallet::where('user_id', $business_id)->first();
        $planData['message_plan'] = $message_plan;


        /* Current Offer */
        $today = date("Y-m-d");
        $offer = Offer::with('offer_template')->where('user_id',$business_id)->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();

        if($offer == null){
            /* find upcoming if no current offer available */
            $offer = Offer::with('offer_template')->where('user_id',$business_id)->where('start_date', '>', $today)->where('status', 1)->orderBy('start_date', 'asc')->first();
        }
        $planData['current_offer'] = $offer;
        $planData['is_posted'] = 0;
        if($offer != ''){
            $planData['is_posted'] = $offer->social_post__db_id ? 1 : 0;
        }

        /* Whatsapp Settings */
        $wa_session = WhatsappSession::where('user_id', $business_id)->first();
        $planData['wa_session'] = $wa_session;

        /* Instant Reward Settings */
        $planData['instant_reward_settings'] = OfferReward::where('user_id', $business_id)->where('channel_id', 2)->first();

        /* Share and Reward Settings */
        $planData['share_and_reward_settings'] = OfferReward::where('user_id', $business_id)->where('channel_id', 3)->first();

        /* Paid user or free */
        $planData['is_paid'] = Transaction::where('user_id', $business_id)->where('transaction_amount', '>', 0)->first();

        /* Business Details */
        $planData['business_detail'] = BusinessDetail::where('user_id', $business_id)->first();

        return $planData;
    }
	

    static function getPlanDetails($userId = ''){

        return [];
    }

    static function getRechargeDetails(){
        
        $rechargeDetails = UserRecharge::where('user_id',Auth::id())->orderBy('id', 'desc')->first();
        $rechargeData = array();

        if($rechargeDetails != null){
            $rechargeData['is_paid'] = 1;
        }else{
            $rechargeData['is_paid'] = 0;
        }

        // return $rechargeData;
        return $rechargeDetails;
    }

    static function businessSettings(){
        $guide_page=Option::where('key','guide_link')->first();
        $ask_for_invoice=Option::where('key','ask_for_invoice')->first();     
        $invoice_required=Option::where('key','invoice_required')->first();
        $ask_for_name=Option::where('key','ask_for_name')->first();
        $ask_for_dob=Option::where('key','ask_for_dob')->first();
        $ask_for_anniversary_date=Option::where('key','ask_for_anniversary_date')->first();
        $name_required=Option::where('key','name_required')->first();
        $dob_required=Option::where('key','dob_required')->first();
        $anniversary_date_required=Option::where('key','anniversary_date_required')->first();

        $businessSettings = array();
        $businessSettings['guide_page'] = $guide_page->value;
        $businessSettings['ask_for_invoice'] = $ask_for_invoice->value;
        $businessSettings['invoice_required'] = $invoice_required->value;
        $businessSettings['ask_for_name'] = $ask_for_name->value;
        $businessSettings['ask_for_dob'] = $ask_for_dob->value;
        $businessSettings['ask_for_anniversary_date'] = $ask_for_anniversary_date->value;
        $businessSettings['name_required'] = $name_required->value;
        $businessSettings['dob_required'] = $dob_required->value;
        $businessSettings['anniversary_date_required'] = $anniversary_date_required->value;

        return $businessSettings;
    }

    static function expiredOffers(){
        $todays_date = date('Y-m-d');
        $offer_ids = Offer::where('end_date','<',$todays_date)->where('user_id',Auth::id())->pluck('id')->toArray();
        if(!empty($offer_ids)){
            Offer::whereIn('id', $offer_ids)->update(['status' => 0, 'is_default' => '0']);
        }
        return true;
    }

    static function cmp($a, $b)
    {
        if($a['unique_clicks']==$b['unique_clicks']) return 0;
        return $a['unique_clicks'] < $b['unique_clicks']?1:-1;
    }
    
    public function setBillingType(Request $request)
    {
        $planData = Session([
            'payble_price'   =>  $request->payble_price,
            'base_price'   =>  $request->base_price,
            'billing_type'   =>  $request->billing_type
        ]);
        return response()->json(['status' => true, 'planData' => $planData]);
    }
	
	public static function checkSendFlag($user_id,$featureId){
		
		$userPlanDetails = Userplan::join('plan_features', 'userplans.channel_ids', '=', 'plan_features.id')->where('userplans.status',1)->where('userplans.user_id',$user_id)->where('userplans.channel_ids',$featureId)->select('userplans.id','userplans.created_at','userplans.will_expire_on','userplans.plan_id')->first();
		
		$messageWallet = MessageWallet::where('user_id',$user_id)->orderBy('id','desc')->first();
		
		$userRechargeValid = UserRecharge::where('user_id',$user_id)->where('status',1)->where('will_expire_on','>=',date('Y-m-d'))->select('will_expire_on')->latest('id')->first();
		
		$sendFlag = false;
		$today = Carbon::now();
		$countMain = $countCommon = 0;
		$subtype = 'main';
		
		$planFeature = PlanFeature::where('id',$featureId)->select('slug')->first();
		
		if(isset($userPlanDetails) && $userPlanDetails != null && $messageWallet != null){
		
			$planDates = CommonSettingController::getDatesArray($userPlanDetails->plan_id,$userPlanDetails->created_at);

			$today = Carbon::now();
			
			$slug = $planFeature->slug.'_wallet';

			foreach ($planDates as $dates) {
				$startDate = Carbon::parse($dates['startDate']);
				$endDate = Carbon::parse($dates['endDate']);
				if($today >= $startDate && $today <= $endDate){                
				   $countMain = WpMessage::where('user_id', $user_id) 
					->where('type', $planFeature->slug)
					->where('sub_type', 'main')
					->where('status', '1')
					->whereDate('created_at', '>=', $startDate)
					->whereDate('created_at', '<=', $endDate)
					->count();
					
					$countCommon = WpMessage::where('user_id', $user_id) 
					->where('sub_type', 'common')
					->where('status', '1')
					->whereDate('created_at', '>=', $startDate)
					->whereDate('created_at', '<=', $endDate)
					->count();
				}
			}

			if($countMain >= $messageWallet->$slug){
				if(($messageWallet->recharge_wallet > 0) && ($countCommon < $messageWallet->recharge_wallet) && ($userRechargeValid != null)){
					$sendFlag = true;
					$subtype = 'common';
				}
			}else{
				$sendFlag = true;
			}
		}
		
		$data['userPlanDetails'] = $userPlanDetails;
		$data['messageWallet'] = $messageWallet;
		$data['userRechargeValid'] = $userRechargeValid;
		$data['sendFlag'] = $sendFlag;
		$data['subtype'] = $subtype;
		
		return $data;
	}

	public static function checkSendFlagD2c($user_id,$featureId,$schedule_date,$totalCustomers,$type=''){
		
		$userPlanDetails = Userplan::join('plan_features', 'userplans.channel_ids', '=', 'plan_features.id')->where('userplans.status',1)->where('userplans.user_id',$user_id)->where('userplans.channel_ids',$featureId)->select('userplans.id','userplans.created_at','userplans.will_expire_on','userplans.plan_id')->first();
		
		$messageWallet = MessageWallet::where('user_id',$user_id)->orderBy('id','desc')->first();
		
		$userRechargeValid = UserRecharge::where('user_id',$user_id)->where('status',1)->where('will_expire_on','>=',date('Y-m-d'))->select('will_expire_on')->latest('id')->first();
		
		$sendFlag = false;
		$today = Carbon::now();
		$countMain = $countCommon = $countMainRemaining = $countCommonRemaining = $customisedWishingMainCount = 0;
		
		$planFeature = PlanFeature::where('id',$featureId)->select('slug')->first();
		
		if(isset($userPlanDetails) && $userPlanDetails != null && $messageWallet != null){
		
			$planDates = CommonSettingController::getDatesArray($userPlanDetails->plan_id,$userPlanDetails->created_at);

			//$today = Carbon::now();
			$today = Carbon::parse($schedule_date);
			
			$slug = $planFeature->slug.'_wallet';

			foreach ($planDates as $dates) {
				$startDate = Carbon::parse($dates['startDate']);
				$endDate = Carbon::parse($dates['endDate']);
				if($today >= $startDate && $today <= $endDate){

					$countCommon = WpMessage::where('user_id', $user_id) 
					->where('sub_type', 'common')
					->where('status', '1')
					->whereDate('created_at', '>=', $startDate)
					->whereDate('created_at', '<=', $endDate)
					->count();
					
				if(isset($type) && $type == 'festival'){
					$currentPosts = WhatsappFestivalPost::where('user_id', $user_id)
                    ->where('status', '<>', 'cancelled')
                    ->whereDate('schedule_date', '>=', $startDate)
                    ->whereDate('schedule_date', '<=', $endDate)
                    ->get();
					
					$customisedWishingMainCount = WpMessage::where('user_id', Auth::id())
                    ->where('type', 'customised_wishing')
                    ->where('sub_type', 'main')
                    ->where('status', '1')
                    ->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate)
                    ->count();
                    
                    $secondaryPosts = WhatsappPost::where('user_id', $user_id)
                    ->where('status', '<>', 'cancelled')
                    ->whereDate('schedule_date', '>=', $startDate)
                    ->whereDate('schedule_date', '<=', $endDate)
                    ->get();
					
				}else{
					$currentPosts = WhatsappPost::where('user_id', $user_id)
                    ->where('status', '<>', 'cancelled')
                    ->whereDate('schedule_date', '>=', $startDate)
                    ->whereDate('schedule_date', '<=', $endDate)
                    ->get();
                    
                    $secondaryPosts = WhatsappFestivalPost::where('user_id', $user_id)
                    ->where('status', '<>', 'cancelled')
                    ->whereDate('schedule_date', '>=', $startDate)
                    ->whereDate('schedule_date', '<=', $endDate)
                    ->get();
				}
				
					if($currentPosts != null){
						foreach($currentPosts as $post){							
							if(!empty($post->count_statistics_realtime) || $post->count_statistics_realtime != null){
								$statistics = json_decode($post->count_statistics_realtime,true);
								$countMain += $statistics['main'];
								$countCommon += $statistics['common'];
							}
						}
					}
					
					if($secondaryPosts != null){
						foreach($secondaryPosts as $post){							
							if(!empty($post->count_statistics_realtime) || $post->count_statistics_realtime != null){
								$statistics = json_decode($post->count_statistics_realtime,true);
								$countCommon += $statistics['common'];
							}
						}
					}
					
				}
			}
			//dd($countMain);
			$countMain += $customisedWishingMainCount;

			if($countMain >= $messageWallet->$slug){
				if(($messageWallet->recharge_wallet > 0) && ($countCommon < $messageWallet->recharge_wallet) && ($userRechargeValid != null)){
					$sendFlag = true;
					$countCommonRemaining = $messageWallet->recharge_wallet - $countCommon;
				}
			}else{
				$countMainRemaining = $messageWallet->$slug - $countMain;
				if($totalCustomers>$countMainRemaining){
					if(($messageWallet->recharge_wallet > 0) && ($countCommon < $messageWallet->recharge_wallet) && ($userRechargeValid != null)){
						$sendFlag = true;
						$countCommonRemaining = $messageWallet->recharge_wallet - $countCommon;
					}
				}
				$sendFlag = true;
			}
		}

		$data['userPlanDetails'] = $userPlanDetails;
		$data['messageWallet'] = $messageWallet;
		$data['userRechargeValid'] = $userRechargeValid;
		$data['sendFlag'] = $sendFlag;
		$data['countMainBalance'] = $countMainRemaining;
		$data['countCommonBalance'] = $countCommonRemaining;
		
		return $data;
	}	

    public static function proceedMessages($customer_ids,$data){

        if(!empty($customer_ids)){

            Customer::whereIn('id',$customer_ids)
                ->with('businesses')
                ->chunk(50, function($customers) use (&$data) { 

                if(isset($data['userPlanDetails'])){

                    foreach ($customers as $customer) {

                        $today = Carbon::now();
                        $wishingCountMain = $wishingCountCommon = 0;
                            
                        $planDates = self::getDatesArray($data['userPlanDetails']->plan_id,$data['userPlanDetails']->created_at);

                        $today = Carbon::now();

                        foreach ($planDates as $dates) {
                            $startDate = Carbon::parse($dates['startDate']);
                            $endDate = Carbon::parse($dates['endDate']);
                            if($today >= $startDate && $today <= $endDate){                
                               $wishingCountMain = WpMessage::where('user_id', $data['template']->user_id) 
                                ->where('type', 'customised_wishing')
                                ->where('sub_type', 'main')
                                ->where('status', '1')
                                ->whereDate('created_at', '>=', $startDate)
                                ->whereDate('created_at', '<=', $endDate)
                                ->count();
								
								$wishingCountCommon = WpMessage::where('user_id', $data['template']->user_id) 
								->where('sub_type', 'common')
								->where('status', '1')
								->whereDate('created_at', '>=', $startDate)
								->whereDate('created_at', '<=', $endDate)
								->count();
                            }
                        }
                        
                        $sendFlag = false;
                        $subtype = 'main';

                        if($wishingCountMain >= $data['messageWallet']->customised_wishing_wallet){
                            if(($data['messageWallet']->recharge_wallet > 0) && ($wishingCountCommon < $data['messageWallet']->recharge_wallet) && ($data['userRechargeValid'] != null)){
                                $sendFlag = true;
                                $subtype = 'common';
                            }
                        }else{
                            $sendFlag = true;
                        }
                        
                        if($sendFlag){  //echo ' sendWaMessage ';                       
                            self::sendWaMessage($customer,$data,$subtype);
                            sleep(5);
                        }else{  //echo ' notifyClient ';    
                            self::notifyClient($data);
                            break;                          
                        }
                    }

                }
            });
        }
    }
    
    public static function sendWaMessage($customer,$data,$subtype){ //echo ' '. $customer->mobile . ' ';
        $number = 91;
        $number .= $customer->mobile;
        $message = $data['template']->whatsapp_content;
        $attachment_url = $data['template']->attachment_url;

        $message = str_replace("[mobile]",$customer->mobile,$message);

        if(isset($customer->businesses[0]->name) && $customer->businesses[0]->name != ''){
            $message = str_replace("[name]",$customer->businesses[0]->name,$message);
        }else{
            $message = str_replace("[name]",'Dear',$message);
        }
		
		$postDataArray = [
            'number' => $number,
            'message' => $message,
            'instance_id' => $data['session']->instance_id,
            'access_token' => $data['user']->wa_access_token
        ];
        
		if(isset($attachment_url) && !empty($attachment_url)){
			$filename = explode("/",$attachment_url);
			$filename = end($filename);
			$postDataArray['type'] = 'media';
			$postDataArray['media_url'] = $attachment_url;
			$postDataArray['filename'] = $filename;
		}else{
			$postDataArray['type'] = 'text';
		}

        #var_dump($postDataArray);
        
        $dataArr = http_build_query($postDataArray);
        $ch = curl_init();
  
		
		$wa_url=Option::where('key','oddek_url')->first();
		$url=$wa_url->value."/api/send.php";
      
        $getUrl = $url."?".$dataArr;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);
        
        if ($err) { 
            $status = 0;
        } else { 
            if($output == null || $output->status == 'error')
                $status = 0;
            else
                $status = 1;
        }
        
    }
    
}
