<?php

namespace App\Http\Controllers;
use DB;
use Auth;

use Session;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Redeem;
use App\Models\Customer;
use App\Models\InstantTask;
use App\Models\OfferReward;
use App\Models\CompleteTask;
use App\Models\ContactGroup;

use App\Models\MessageRoute;
use App\Models\InstantTaskStat;

use App\Models\OfferInstant;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\SocialChannel;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use App\Models\SocialCustomerCount;
use Illuminate\Support\Facades\URL;
use App\Models\UserSocialConnection;
use Illuminate\Support\Facades\Hash;
use App\Models\OfferSubscriptionReward;
use Illuminate\Support\Facades\Redirect;

use App\Helper\Deductions\DeductionHelper;
use App\Http\Controllers\ShortLinkController;

use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\WhatsAppMsgController;

use Jenssegers\Agent\Agent;

class InstantTaskController extends Controller
{

    public function sharedInstantTemplate(Request $request,$offer_uuid){

        // header("Cache-Control: no-cache, must-revalidate");
        // header("Content-Type: application/xml; charset=utf-8");
        
        $show_user_modal = true;
        $services_url=Option::where('key','services_url')->first();
        $offer = Offer::with('offer_template')->where('uuid', $offer_uuid)->first();
        
        $business = BusinessDetail::where('user_id',$offer->user_id)->first();
        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;

        if($business->vcard_type == 'webpage'){
            $vcard_url = $business->webpage_url;
        }else{
            $vcard_url = URL::to('/').'/business/info/'.$business->uuid;
        }
        
        $today = date("Y-m-d");
        $domain = URL::to('/');
        
        if($offer != null){

            // Get User Message Wallet
            $messageWallet = MessageWallet::where('user_id', $offer->user_id)->first();

            if($today > Carbon::parse($offer->end_date)->format("Y-m-d")){
                

                $ongoing_offer = Offer::where('user_id', $offer->user_id)
                                ->where(function ($query) {
                                    $query->where(function ($q) {
                                            $q->where('start_date', '<', date("Y-m-d"))
                                            ->where('end_date', '>=', date("Y-m-d"));
                                        })
                                        ->orWhere(function ($q) {
                                            $q->where('start_date', '<=', date("Y-m-d"))
                                                ->where('end_date', '>', date("Y-m-d"));
                                        })
                                        ->orWhere(function ($q) {
                                            $q->where('start_date', '=', date("Y-m-d"))
                                                ->where('end_date', '=', date("Y-m-d"));
                                        });
                                })->first();
       
                if($ongoing_offer != null &&  $ongoing_offer->website_url == ''){ 
                    $url = $domain.'/f/'.$ongoing_offer->uuid;
                }else{
                    // $url = $domain.'/business/info/'.$business->uuid;
                    if($business->vcard_type == 'webpage'){
                        $url = $business->webpage_url;
                    }else{
                        $url = URL::to('/').'/business/info/'.$business->uuid;
                    }
                }
                
                return Redirect::to($url);
            }

            // Check AutoPost Offer Available or not
            $isAutoPostOffer = 1;
            // Changes for Free users
            // $autoInstantTask = InstantTask::where('offer_id', $offer->id)->whereNull('deleted_at')->count();
            // if($autoInstantTask==NULL){
            //     $isAutoPostOffer = 0;
            //     // $url = $domain.'/business/info/'.$business->uuid;
            //     if($business->vcard_type == 'webpage'){
            //         $url = $business->webpage_url;
            //     }else{
            //         $url = URL::to('/').'/business/info/'.$business->uuid;
            //     }
            //     return Redirect::to($url);
            // }
             
            $tasks = [];
            $tasks_value = [];
            $task_ids = [];

            if(empty($request->all())){
                $redeem = $settings = $subscription = '';
                $instantTasks = $completedTasks = $redeemedTasks = $notRedeemedTasks = array();
            }else{
                
                if(isset($request->share_cnf)){
                    $show_user_modal = false;
                }

                $subscription = OfferSubscription::where('uuid',$request->share_cnf)->first();
                if($subscription == null){
                    
                    // $url = $domain.'/business/info/'.$business->uuid;
                    if($business->vcard_type == 'webpage'){
                        $url = $business->webpage_url;
                    }else{
                        $url = URL::to('/').'/business/info/'.$business->uuid;
                    }
                    return Redirect::to($url);
                }else{
                    
                    if($subscription->status == '2'){
                        
                        $new_subscription = OfferSubscription::where('user_id',$subscription->user_id)->where('offer_id',$subscription->offer_id)->where('customer_id',$subscription->customer_id)->where('channel_id', 2)->where('status', '1')->first();
                        
                        if($new_subscription != null){
                            $url = $domain.$new_subscription->share_link;
                            return Redirect::to($url);
                        }
                        else{
                            $redeem = Redeem::where('offer_subscription_id', $subscription->id)->orderBy('id','desc')->first();
                            if(isset($redeem) && $redeem->is_redeemed == 1){
                                // $url = $domain.'/business/info/'.$business->uuid;
                                if($business->vcard_type == 'webpage'){
                                    $url = $business->webpage_url;
                                }else{
                                    $url = URL::to('/').'/business/info/'.$business->uuid;
                                }
                                return Redirect::to($url);
                            }
                        }
                        
                    }
                }
                

                $redeemSubId = OfferSubscription::where('user_id',$subscription->user_id)->where('customer_id',$subscription->customer_id)->where('channel_id', 2)->where('status', '2')->pluck('id')->toArray();

                $notRedeemSubId = OfferSubscription::where('user_id',$subscription->user_id)->where('customer_id',$subscription->customer_id)->where('channel_id', 2)->where('status', '1')->pluck('id')->toArray();

                // $completedSubIds = OfferSubscription::where('user_id',$subscription->user_id)->where('customer_id',$subscription->customer_id)->where('channel_id', 2)->where('status', '2')->pluck('id')->toArray();

                $completedTasks = CompleteTask::where('offer_subscription_id', $subscription->id)->where('customer_id',$subscription->customer_id)->pluck('instant_task_id')->toArray();
                
                $redeemedTasks = CompleteTask::whereIn('offer_subscription_id',$redeemSubId)->pluck('instant_task_id')->toArray();
                // $notRedeemedTasks = CompleteTask::whereIn('offer_subscription_id',$notRedeemSubId)->pluck('instant_task_id')->toArray();

                $total_task_ids = InstantTask::with('activeTask')->has('activeTask')->where('user_id',$offer->user_id)->whereNull('deleted_at')->orderBy('id','desc')->pluck('id')->toArray();

                $completed_task_ids = CompleteTask::whereIn('offer_subscription_id', $redeemSubId)->where('customer_id',$subscription->customer_id)->pluck('instant_task_id')->toArray();

                $showInstantTaskIds = array();
                if($subscription->status == '1'){
                    $showInstantTaskIds = array_diff($total_task_ids, $completed_task_ids);
                }elseif($subscription->status == '2'){
                    $showInstantTaskIds = array_diff($total_task_ids, $completed_task_ids);

                    $sub_completed_task_ids = CompleteTask::where('offer_subscription_id', $subscription->id)->where('customer_id',$subscription->customer_id)->pluck('instant_task_id')->toArray();

                    $showInstantTaskIds = array_merge($total_task_ids, $completed_task_ids);
                }

                // check old Instant Task
                $anotherCompletedTasks = CompleteTask::where('customer_id', $subscription->customer_id)->where('offer_subscription_id', "!=", $subscription->id)->pluck('instant_task_id')->toArray();

                $socialPostDisconnectedInstantTaskIds = app("App\Http\Controllers\SocialPagesController")->socialPostDisconnectedInstantTasks($offer->user_id);
                if($socialPostDisconnectedInstantTaskIds['all_diconnected'] == 1){
                    // $url = $domain.'/business/info/'.$business->uuid;
                    if($business->vcard_type == 'webpage'){
                        $url = $business->webpage_url;
                    }else{
                        $url = URL::to('/').'/business/info/'.$business->uuid;
                    }
                    return Redirect::to($url);
                }

                $freeUserTaskIds=[];
                if($isUserFree=="free"){
                    $freeUserTaskIds = Task::where('visible_to_free_user', 1)->pluck('id')->toArray();
                }else{
                    $freeUserTaskIds = Task::where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
                }

                $instantTasks = InstantTask::with('activeTask', 'task')->has('activeTask')->where('user_id',$offer->user_id)->whereIn('id', $showInstantTaskIds)->whereNull('deleted_at')->whereNotIn('id', $anotherCompletedTasks)->whereNotIn('id', $socialPostDisconnectedInstantTaskIds['instantTaskIds'] ?? [])->whereIn('task_id', $freeUserTaskIds)->orderBy('task_id','ASC')->groupBy('task_id')->get();
                
                // Check All task completed or not using below variable
                $isAllTaskCompleted = 1;

                foreach ($instantTasks as $key => $instantTask) {
                    if(($instantTask->task_id != '')){
                        $task_ids[$instantTask->task->id] = $instantTask->task->id;
                        $tasks[$instantTask->task->id] = $instantTask->task->task_key;
                        $tasks_value[$instantTask->task->task_key] = $instantTask->task_value;
                    }

                    if(!in_array($instantTask->id, $completedTasks)){
                        $isAllTaskCompleted = 0;
                    }
                }

                // if(($isAllTaskCompleted == 1 || $isAutoPostOffer==0) && $subscription->status == 2){
                if(($isAllTaskCompleted == 1 || $isAutoPostOffer==0)){
                    // $url = $domain.'/business/info/'.$business->uuid;
                    if($business->vcard_type == 'webpage'){
                        $url = $business->webpage_url;
                    }else{
                        $url = URL::to('/').'/business/info/'.$business->uuid;
                    }
                    return Redirect::to($url);
                }

                $settings = OfferSubscriptionReward::where('offer_subscription_id',$subscription->id)->where('user_id', $offer->user_id)->where('offer_id', $offer->id)->first();
                $settings->details = json_decode($settings->details, true);

                //update social channel counts
                $share_cnf = $request->share_cnf;
                
                // $this->updateSocialData($offer_uuid, $share_cnf);
                $instantTasks = $this->sortInstantTaskByTask($instantTasks);
            }


            //balance check
            $checkWallet = DeductionHelper::getUserWalletBalance($offer->user_id);

            // $device = Agent::device();
            $agent = new Agent();
            // dd($agent->device());

            $optionContribUrl=Option::where('key', 'google_review_contrib_url')->first();
            $contribUrl = $optionContribUrl->value ?? NULL;
            
            return view('instant-challenge.index', compact('offer', 'business','instantTasks','tasks', 'tasks_value','task_ids','completedTasks','redeemedTasks','services_url','settings','show_user_modal', 'messageWallet', 'subscription', 'vcard_url', 'checkWallet', 'agent', 'contribUrl'));
        }else{
            return Response(view('errors.401'));
        }
    }

    function sortInstantTaskByTask($instantTasks){
        $sortedItasks=[];
        if($instantTasks!=NULL){
            foreach ($instantTasks as $key => $itask) {
                if($itask->task){
                    $sortNo = $itask->task->column_sort_no;
                    $sortedItasks[$sortNo] = $itask;
                }
            }
            ksort($sortedItasks);
        }
        return $sortedItasks;
    }

    public function addCustomerDetails(Request $request)
    {
        // dd($request->all());
        $offer = Offer::where('uuid', $request->offer_uuid)->first();
        $data = $request->all();
        $data['user_id'] = $offer->user_id;
        $data['offer_id'] = $offer->id;

        $businessDetail = BusinessDetail::where('user_id', $offer->user_id)->first();

        if($request->customer_uuid == null){
            $customer = $this->customer($data);
            $customer_info = BusinessCustomer::where('user_id', $data['user_id'])->where('customer_id', $customer->id)->first();
        }else{
            $uuids = explode("_", $request->customer_uuid);
            $customer_uuid = $uuids[0];
            $customer = Customer::where('uuid', $customer_uuid)->first();

            if($customer == null){
                $link = URL::to('/').'/i/'.$request->offer_uuid;
                return response()->json(["status" => false, "message" => "Customer uuid not found.", "action" => "remove_cache_and_reload", "link" => $link]);
            }
            $customer_info = BusinessCustomer::where('user_id', $data['user_id'])->where('customer_id', $customer->id)->first();
        }
        
        if($customer == null){
            return response()->json(["status" => false, "message" => "Customer not found.", "action" => "ask_for_number"]);
        }

        $activeSubscription = OfferSubscription::where("customer_id", $customer->id)->where("offer_id", $offer->id)->where("user_id", $offer->user_id)->where('channel_id',2)->where("status", '1')->first();

        if($activeSubscription != null){
            $active_link = URL::to('/').$activeSubscription->share_link;
            return response()->json(["status" => false, "message" => "Already subscribed.", "action" => "redirect_to_existing_subscription", "link" => $active_link]);
        }

        if($businessDetail->vcard_type == 'webpage'){
            $vcard_url = $businessDetail->webpage_url;
        }else{
            $vcard_url = URL::to('/').'/business/info/'.$businessDetail->uuid;
        }

        $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',2)->first();
        if($settings == null){
            return response()->json(["status" => false, "message" => "Instant challenge setting not found.", "action" => "redirect_to_business_vcard", "link" => $vcard_url]);
        }
        
        $checkIsAllTaskAreCompleted = $this->checkIsAllTaskAreCompleted($offer->user_id, $customer->id);
        if($checkIsAllTaskAreCompleted == true){
            return response()->json(["status" => false, "message" => "Do not have task to perform.", "action" => "redirect_to_business_vcard", "link" => $vcard_url]);
        }

        $hasTasks = $this->isTaskAvailable($customer->id, $offer->user_id, $settings);
        if($hasTasks == false){
            return response()->json(["status" => false, "message" => "Do not have task to perform.", "action" => "redirect_to_business_vcard", "link" => $vcard_url]);
        }

        // Check Minimum Task Start
        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::where('visible_to_free_user', 1)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }
        
        $notCompletedTasks = InstantTask::with('activeTask')->has('activeTask')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->orderBy('id','desc')->count();

        $rewardData = json_decode($settings->details, true);
        $req_task = (int)$rewardData['minimum_task'];

        if($notCompletedTasks < $req_task){
            return response()->json(["status" => false, "message" => "Minimum task more than available tasks", "action" => "ask_for_show_info_minimum_task_more_than_available_task_modal"]);
        }
        // Check Minimum Task End
        
        $customerDetail = BusinessCustomer::where('customer_id', $customer->id)->where('user_id', $offer->user_id)->first();
        if($customerDetail == null){
            return response()->json(["status" => false, "message" => "Customer detail not found.", "action" => "ask_for_number"]);
        }
        if($customerDetail->name == ''){
            return response()->json(["status" => false, "message" => "Do not have name.", "action" => "ask_for_name", "customer" => $customer, "customer_info" => $customer_info]);
        }
        
        if($customerDetail->dob == ''){
            return response()->json(["status" => false, "message" => "Do not have date of birth.", "action" => "ask_for_dob", "customer" => $customer, "customer_info" => $customer_info]);
        }

        if($customerDetail->anniversary_date == ''){
            return response()->json(["status" => false, "message" => "Do not have anniversary date.", "action" => "ask_for_anniversary", "customer" => $customer, "customer_info" => $customer_info]);
        }

        /* If old customer and all data is provided */
        $data = [
            'offer_id' => $offer->id,
            'user_id'  => $offer->user_id,
            'mobile' => $customer->mobile,
            'customer_id' => $customer->id,
        ];

        $response = $this->subscribeCustomer($data, $settings, $vcard_url);
        return response()->json($response);
    }

    public function continueWithSubscription(Request $request){
        $offer = Offer::where('uuid', $request->offer_uuid)->first();
        $data = $request->all();
        $data['user_id'] = $offer->user_id;
        $data['offer_id'] = $offer->id;

        $customer = $this->customer($data);
        $customer_info = BusinessCustomer::where('user_id', $data['user_id'])->where('customer_id', $customer->id)->first();
        $businessDetail = BusinessDetail::where('user_id', $offer->user_id)->first();

        $activeSubscription = OfferSubscription::where("customer_id", $customer->id)->where("offer_id", $offer->id)->where("user_id", $offer->user_id)->where('channel_id', 2)->where("status", '1')->first();
        
        if($activeSubscription != null){
            $active_link = URL::to('/').$activeSubscription->share_link;

            return response()->json(["status" => false, "message" => "Already subscribed.", "action" => "redirect_to_existing_subscription", "link" => $active_link, "customer_uuid" => $customer->uuid, 'business_uuid' => $businessDetail->uuid]);
        }

        if($businessDetail->vcard_type == 'webpage'){
            $vcard_url = $businessDetail->webpage_url;
        }else{
            $vcard_url = URL::to('/').'/business/info/'.$businessDetail->uuid;
        }

        $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',2)->first();
        if($settings == null){
            return response()->json(["status" => false, "message" => "Instant reward setting not found.", "action" => "redirect_to_business_vcard", "link" => $vcard_url]);
        }

        // Check Wallet using Route
        $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($offer->user_id, 2, ['send_sms', '', 'instant_challenge_subscription']);

        $route = MessageRoute::where('user_id', $offer->user_id)->where('channel_id', 2)->first();
        if($route->sms == 1){
            if($checkWalletBalance['status'] == true){
                $data['customer_id'] = $customer->id;
                $response = $this->subscribeCustomer($data, $settings, $vcard_url);
                return response()->json($response);
            }
            else{
                return response()->json(["status" => $checkWalletBalance['status'], "message" => $checkWalletBalance['message']]);
            }
        }else{
            $data['customer_id'] = $customer->id;
            $response = $this->subscribeCustomer($data, $settings, $vcard_url);
            return response()->json($response);
        }
        
    }

    public function checkIsAllTaskAreCompleted($user_id, $customer_id){
        $redeemSubId = OfferSubscription::where('user_id', $user_id)->where('customer_id', $customer_id)->where('channel_id', 2)->where('status', '2')->pluck('id')->toArray();

        $total_task_ids = InstantTask::with('activeTask')->has('activeTask')->where('user_id', $user_id)->whereNull('deleted_at')->orderBy('id','desc')->pluck('id')->toArray();

        $completed_task_ids = CompleteTask::whereIn('offer_subscription_id', $redeemSubId)->where('customer_id',$customer_id)->pluck('instant_task_id')->toArray();

        $showInstantTaskIds = array();
        $showInstantTaskIds = array_diff($total_task_ids, $completed_task_ids);

        $socialPostDisconnectedInstantTaskIds = app("App\Http\Controllers\SocialPagesController")->socialPostDisconnectedInstantTasks($user_id);
        if($socialPostDisconnectedInstantTaskIds['all_diconnected'] == 1){
            return true;
        }
        else{
            return false;
        }
        
        $instantTasks = InstantTask::with('activeTask', 'task')->has('activeTask')->where('user_id', $user_id)->whereIn('id', $showInstantTaskIds)->whereNull('deleted_at')->whereNotIn('id', $socialPostDisconnectedInstantTaskIds['instantTaskIds'] ?? [])->orderBy('task_id','ASC')->groupBy('task_id')->get();

        $completedTasks = CompleteTask::where('customer_id', $customer_id)->where('user_id', $user_id)->pluck('instant_task_id')->toArray();

        // Check All task completed or not using below variable
        $isAllTaskCompleted = 1;
        foreach ($instantTasks as $key => $instantTask) {
            if(($instantTask->task_id != '')){
                $task_ids[$instantTask->task->id] = $instantTask->task->id;
                $tasks[$instantTask->task->id] = $instantTask->task->task_key;
                $tasks_value[$instantTask->task->task_key] = $instantTask->task_value;
            }

            if(!in_array($instantTask->id, $completedTasks)){
                $isAllTaskCompleted = 0;
            }
        }

        if($isAllTaskCompleted == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function isTaskAvailable($customer_id, $user_id, $settings)
    {

        $offerSubscriptionIds = OfferSubscription::where('customer_id', $customer_id)->where('user_id', $user_id)->pluck('id')->toArray();
        
        $userInfo = user::find($user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::where('visible_to_free_user', 1)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $total_task_ids = InstantTask::with('activeTask')->whereIn('task_id', $taskIds)->has('activeTask')->where('user_id', $user_id)->whereNull('deleted_at')->orderBy('id','desc')->pluck('id')->toArray();

        $completedTasks = CompleteTask::where('customer_id', $customer_id)->whereIn('offer_subscription_id', $offerSubscriptionIds)->pluck('instant_task_id')->toArray();

        if(!empty($completedTasks)){
            $notCompletedTasks = count(array_diff($total_task_ids, $completedTasks));
        }else{
            $notCompletedTasks = count($total_task_ids);
        }
        // dd($notCompletedTasks);
        $rewardData = json_decode($settings->details, true);
        $req_task = (int)$rewardData['minimum_task'];
        // dd($total_task_ids);
        if($notCompletedTasks < $req_task){
            return false;
        }else{
            return true;
        }
    }

    public function subscribeCustomer($data, $settings, $vcard_url)
    {
        $offer = Offer::where('id', $data['offer_id'])->first();
        $business_details = BusinessDetail::where('user_id', $data['user_id'])->first();
        $customer = Customer::where('mobile', $data['mobile'])->first();

        /* Customer Subscribing for the first time */
        $subCount = OfferSubscription::where('user_id', $data['user_id'])->where('customer_id', $customer->id)->count();
        if($subCount == 0){
            $firstTime = true;
        }else{
            $firstTime = false;
        }
        
        $type = 'instant';
        $randomString = UuidTokenController::eightCharacterUniqueToken(8);
        $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
        $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
        
        if($tokenData['status'] == true){
            $tokenData = UuidTokenController::findUniqueToken($type, $addedCharacter);
        }
        $link = '/i/'.$offer->uuid.'?share_cnf='.$tokenData['token'];

        $long_link = URL::to('/').$link;
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $data['user_id'] ?? 0, "instant_challenge");
        if($shortLinkData->original["success"] == false){
            return ["status" => false, "message" => "Shortlink not created."];
        }
        
        /* Share link */
        $share_link = "https://opnl.in/".$shortLinkData->original["code"];
        $user_id = $data['user_id'];
        $channel_id = 2;
        $mobile = "91".$data['mobile'];

        $customer = Customer::where('mobile', $data['mobile'])->first();
        $customer_id = (isset($customer) && $customer->id) ? $customer->id : 0;

        $business_details = BusinessDetail::where('user_id', $user_id)->first();
        $biz_name = $business_details->business_name ?? 'business owner';

        if(strlen($biz_name) > 28){
            $biz_name = substr($biz_name,0,28).'..';
        }
        
        /* First Time */
        if($firstTime == true){
            /* Welcome Messsage */
            $message = "Welcome to ".$business_details->business_name."\nYou're eligible to get an offer today\nThanks for shopping with us.\nOPNLNK";

            $params = [
                "mobile" => $mobile,
                "message" => $message,
                "channel_id" => $channel_id,
                'whatsapp_msg' => $message,
                'sms_msg' => $message,
                "user_id" => $user_id
            ];

            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
            
            $link_by_sms = $link_by_wa = false;
            $err_by_sms = $err_by_wa = '';
            if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                $link_by_wa = true;
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

            /* Save Message History */
            if($link_by_sms == true){
                $related_to1 = "Welcome message";
                $sent_via1 = "sms";
                $status1 = 1;
                // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                    $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                }
                else{
                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
                }
            }

            if($link_by_wa == true){
                $related_to1 = "Welcome message";
                $sent_via1 = "wa";
                $status1 = 1;
                // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
            }
        }else{
            // $business_detail = BusinessDetail::where('user_id', Auth::id());
            // $biz_name = $business_detail->business_name;
            
            $message = "Congratulations, you are eligible to get an offer!\nClick: opnl.in/".$shortLinkData->original["code"]."\nComplete the task to get a discount instantly!\nOPNLNK";
            
            $followThisLink = "Follow this link:";

            $whatsapp_msg ="Hi there!\n\nWe hope you're enjoying your experience with *".$biz_name."*. We're excited to announce our *Instant Challenge* program,\n\nwhere you can get discounts/gifts Instantly by sharing our business with your friends and family or anyone in your network!\n\nAll you have to do is complete some easy social media tasks such as liking our Facebook page, subscribing to our Youtube channel, and leaving a review on Google. etc\n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]." to see all the details of the *Instant Challenge* program, including the tasks and discounts/gifts.\n\nThank you for supporting our business and helping us grow!";

            $params = [
                "mobile" => $mobile,
                "message" => $message,
                "channel_id" => $channel_id,
                'whatsapp_msg' => $whatsapp_msg,
                'sms_msg' => $message,
                "user_id" => $user_id
            ];

            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
            
            $link_by_sms = $link_by_wa = false;
            $err_by_sms = $err_by_wa = '';
            if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                $link_by_wa = true;
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

            /* Save Message History */
            if($link_by_sms == true){
                $related_to1 = "Send Link";
                $sent_via1 = "sms";
                $status1 = 1;
                // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                    $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                }
                else{
                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
                }
            }

            if($link_by_wa == true){
                $related_to1 = "Send Link";
                $sent_via1 = "wa";
                $status1 = 1;
                // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $whatsapp_msg, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
            }
        }

        // dd($sendLink);
        if($link_by_sms == true || $link_by_wa == true){

            if($firstTime == true){
                /* How it works */
                /* $how_to_link = URL::to('/');
                $shortLinkHowToData = ShortLinkController::callShortLinkApi($how_to_link, $data['user_id'] ?? 0, "instant_challenge");

                if($shortLinkHowToData->original["success"] == false){
                    return ["status" => false, "message" => "Shortlink not created."];
                }

                $business_details = BusinessDetail::where('user_id', $user_id)->first();
                $biz_name = $business_details->business_name ?? 'business owner';
                if(strlen($biz_name) > 28){
                    $biz_name = substr($biz_name,0,28).'..';
                }

                $second_message = "How it works:\n-Open the link\n-Finish the task\n-Share the code with ".$biz_name." to avail a discount\nMore info: opnl.in/".$shortLinkHowToData->original["code"]."\nOPNLNK";

                $secondParams = [
                    "mobile" => $mobile,
                    "message" => $second_message,
                    "channel_id" => $channel_id,
                    "user_id" => $user_id
                ];
                $sendSecondLink = app('App\Http\Controllers\MessageController')->sendMsg($secondParams);

                $link_by_sms_second = $link_by_wa_second = false;
                $err_by_sms_second = $err_by_wa_second = '';
                if(isset($sendSecondLink->original["wa"]["status"]) && $sendSecondLink->original["wa"]["status"] == "success"){
                    $link_by_wa_second = true;
                }else{
                    $err_by_wa_second = $sendSecondLink->original["wa"]["message"];
                }

                if(isset($sendSecondLink->original["sms"]["Status"]) && $sendSecondLink->original["sms"]["Status"] == "1"){
                    $link_by_sms_second = true;
                }else{  
                    $err_by_sms_second = $sendSecondLink->original["sms"]["message"];
                }

                if($link_by_sms_second == true || $link_by_wa_second == true){
                    if($link_by_sms_second == true){
                        $related_to2 = "How it Work";
                        $sent_via2 = "sms";
                        $status2 = 1;
                        $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $second_message, $related_to2, $sent_via2, $status2);
                    }

                    if($link_by_wa_second == true){
                        $related_to2 = "How it Work";
                        $sent_via2 = "wa";
                        $status2 = 1;
                        $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $second_message, $related_to2, $sent_via2, $status2);
                    } */

                    /* Send Link */
                    $third_message = "Congratulations, you are eligible to get an offer!\nClick: opnl.in/".$shortLinkData->original["code"]."\nComplete the task to get a discount instantly!\nOPNLNK";

                    $followThisLink = "Follow this link:";

                    $whatsapp_msg ="Hi there!\n\nWe hope you're enjoying your experience with *".$biz_name."*. We're excited to announce our *Instant Challenge* program,\n\nwhere you can get discounts/gifts Instantly by sharing our business with your friends and family or anyone in your network!\n\nAll you have to do is complete some easy social media tasks such as liking our Facebook page, subscribing to our Youtube channel, and leaving a review on Google. etc\n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]." to see all the details of the *Instant Challenge* program, including the tasks and discounts/gifts.\n\nThank you for supporting our business and helping us grow!";
            
                    $thirdParams = [
                        "mobile" => "91".$data['mobile'],
                        "message" => $third_message,
                        "channel_id" => $channel_id,
                        'whatsapp_msg' => $whatsapp_msg,
                        'sms_msg' => $message,
                        "user_id" => $user_id
                    ];
                    $sendThirdLink = app('App\Http\Controllers\MessageController')->sendMsg($thirdParams);

                    $link_by_sms_third = $link_by_wa_third = false;
                    $err_by_sms_third = $err_by_wa_third = '';
                    if(isset($sendThirdLink->original["wa"]["status"]) && $sendThirdLink->original["wa"]["status"] == "success"){
                        $link_by_wa_third = true;
                    }else{
                        $err_by_wa_third = $sendThirdLink->original["wa"]["message"];
                    }

                    if(isset($sendThirdLink->original["sms"]["Status"]) && $sendThirdLink->original["sms"]["Status"] == "1"){
                        $link_by_sms_third = true;
                    }else{  
                        if(isset($sendThirdLink->original["sms"]["message"])){
                            $err_by_sms_third = $sendThirdLink->original["sms"]["message"];
                        }else{
                            $err_by_sms_third = $sendThirdLink->original["sms"];
                        }
                    }

                    if($link_by_sms_third == true){
                        $related_to3 = "Send Link";
                        $sent_via3 = "sms";
                        $status3 = 1;
                        // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, $status3);

                        $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, 1);

                        // Insert in Deduction History Table
                        $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                        if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                            $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                        }
                        else{
                            $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                            DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
                        }
                    }

                    if($link_by_wa_third == true){    
                        $related_to3 = "Send Link";
                        $sent_via3 = "wa";
                        $status3 = 1;
                        // $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, $status3);
                        
                        $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $whatsapp_msg, $related_to3, $sent_via3, 1);

                        // Insert in Deduction History Table
                        // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                        // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer_id, 0);
                    }
                // }
            }

            /* Create Subscription */
            $subscription = new OfferSubscription;
            $subscription->channel_id = $channel_id;
            $subscription->user_id = $user_id;
            $subscription->created_by = $user_id;
            $subscription->offer_id = $offer->id;
            $subscription->short_link_id = $shortLinkData->original["id"];
            $subscription->customer_id = $customer->id;
            $subscription->uuid = $tokenData['token'];
            $subscription->share_link = $link;
            $subscription->save();
            
            $offerSubscriptionReward = new OfferSubscriptionReward;
            $offerSubscriptionReward->user_id = $user_id;
            $offerSubscriptionReward->offer_id = $offer->id;
            $offerSubscriptionReward->offer_subscription_id = $subscription->id;
            $offerSubscriptionReward->type = $settings->type;
            $offerSubscriptionReward->details = $settings->details;
            $offerSubscriptionReward->save();

            /* Add to Instant Contacts */
            $contactGroup = ContactGroup::where('user_id', $user_id)->where('channel_id', $channel_id)->first();
            $contact = GroupCustomer::where('user_id', $user_id)->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
            if($contact == null){
                $contact = new GroupCustomer;
                $contact->user_id = $user_id;
                $contact->contact_group_id = $contactGroup->id;
                $contact->customer_id = $customer->id;
                $contact->save();
            }

            // Insert Subscription in Deduction History Table
            // $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'instant_challenge_subscription');

            // DeductionHelper::deductWalletBalance($user_id, $deductionDetail->id ?? 0, $channel_id, 0, $customer_id, 0);

            return ["status" => true, "message" => "Offer link shared successfully.", "link" => $share_link, "customer_uuid" => $customer->uuid, 'business_uuid' => $business_details->uuid];
        }else{
            if($err_by_wa != "Route not active"){
                return ["status" => false, "message" => $err_by_wa, 'link' => $vcard_url];
            }

            if($link_by_sms != "Route not active"){
                return ["status" => false, "message" => $link_by_sms, 'link' => $vcard_url];
            }

            return ["status" => false, "message" => "Route not active", 'link' => $vcard_url];
            
        }
    }

    public function customer($data)
    {
        $customer = Customer::where('mobile',$data['mobile'])->first();
        // dd($customer);
        if($customer == null){
            $customer= new Customer;
            $customer->mobile = $data['mobile'];
            $customer->user_id = $data['user_id'];
            $customer->created_by = $data['user_id'];
            $customer->save();

            $customer->uuid = $customer->id.'CUST'.date("Ymd");
            $customer->save();

            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = $data['user_id'];
            $business_customer->name = $data['name'];
            $business_customer->dob = $data['dob'];
            $business_customer->anniversary_date = $data['anniversary'];
            $business_customer->save();
        }else{
            $customer_info = BusinessCustomer::where('user_id', $data['user_id'])->where('customer_id', $customer->id)->first();

            if($customer_info == null){
                $business_customer = new BusinessCustomer;
                $business_customer->customer_id = $customer->id;
                $business_customer->user_id = $data['user_id'];
                $business_customer->name = $data['name'];
                $business_customer->dob = $data['dob'];
                $business_customer->anniversary_date = $data['anniversary'];
                $business_customer->save();
            }else{
                $business_customer = BusinessCustomer::find($customer_info->id);
                if($data['name'] != ''){
                    $business_customer->name = $data['name'];
                }
                if($data['dob'] != ''){
                    $business_customer->dob = $data['dob'];
                }
                if($data['anniversary'] != ''){
                    $business_customer->anniversary_date = $data['anniversary'];
                }
                $business_customer->save();
            }
        }

        /* Add to Instant Contacts start */
        $contactGroup = ContactGroup::where('user_id', $data['user_id'])->where('channel_id', 2)->first();
        $contact = GroupCustomer::where('user_id', $data['user_id'])->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
        if($contact == null){
            $contact = new GroupCustomer;
            $contact->user_id = $data['user_id'];
            $contact->contact_group_id = $contactGroup->id;
            $contact->customer_id = $customer->id;
            $contact->save();
        }
        /* Add to Instant Contacts end */

        $customer = Customer::with('info')->where('id',$customer->id)->first();

        return $customer;
    }

    //update old count
    public function updateSocialData($offer_uuid, $share_cnf=""){
        $offer = Offer::where('uuid',$offer_uuid)->orderBy('id','desc')->first();

        $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
        if($youtube_data != null){
            $youtube = json_decode($youtube_data->value);
        }else{
            return ['status'=> false,'message'=> 'Youtube credentials not found.'];
        }
        
        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);
        }else{
            return ['status'=> false,'message'=> 'Twitter credentials not found.'];
            // return response()->json(['status'=> false,'message'=> 'Twitter credentials not found.'], 200);
        }

        $instant_tasks = InstantTask::where('user_id',$offer->user_id)->whereNull('deleted_at')->get();

        $offerSubscription = OfferSubscription::where('uuid', $share_cnf)->first();
        
        if(!empty($instant_tasks)){
            $customer_id = $offerSubscription->customer_id ?? 0;
            
            $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
            if($socialCustomerCount==NULL){
                $socialCustomerCount = new SocialCustomerCount;
            }

            $socialCustomerCount->user_id = $offer->user_id;
            $socialCustomerCount->customer_id = $customer_id;

            $option=Option::where('key','social_post_url')->first();
            $userDetail = User::find($offer->user_id);
            $social_post_api_token = $userDetail->social_post_api_token;

            $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

            foreach($instant_tasks as $task){
                // FACEBOOK
                // # Like Our Page
                if($task->task_id == 1){
                    $uriSegments = explode("/", parse_url($task->task_value, PHP_URL_PATH));
                    $facebookPageID = array_pop($uriSegments);
                    
                    $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Facebook')->where('type', 'Page')->where('data_key', 'likes')->orderBy('id','desc')->first();

                    $url=$option->value."/api/facebook/getPageLikeCount";
                    
                    // check facebook like
                    $curl = curl_init();
                    $postfields=[];
                    if(isset($facebookPageID)){
                        $postfields['fb_page_id'] = $facebookPageID;
                    }
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => $postfields,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$social_post_api_token
                        ),
                    ));
            
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);

                    if($response!=NULL){
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = 'Page';
                        $countData->data_key = 'likes';
                        $countData->media_id = $facebookPageID;
                        $countData->instant_task_id = $task->id;
                        $countData->count = $response['fan_count'] ?? 0;
                        $countData->save();

                        $socialCustomerCount->fb_page_url_count = $response['fan_count'] ?? 0;
                    }
                }

                if($task->task_id==2 || $task->task_id==3 || $task->task_id==15){
                    $uriSegments = explode("/", parse_url($task->task_value, PHP_URL_PATH));
                    $facebookPageIDUrl = array_pop($uriSegments);
                    $facebookPostID = $offer->social_post__db_id ?? '';

                    $countData=[];
                    $type = $data_key = "";
                    if($task->task_id==2){
                        $type = "Post";
                        $data_key = "comments";
                        
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Facebook')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                    }
                    else if($task->task_id==3){
                        $type = "Post";
                        $data_key = "likes";
                        
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Facebook')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                    }
                    else if($task->task_id==15){
                        $type = "Post";
                        $data_key = "share";
                        
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Facebook')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                    }

                    $url = $option->value."/api/facebook/getPostLCSCount";

                    // check facebook like
                    $curl = curl_init();
                    $postfields=[];
                    if(isset($facebookPostID)){
                        $postfields['post_id'] = $facebookPostID;
                    }
                    
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => $postfields,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$social_post_api_token
                        ),
                    ));
            
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);
                    
                    // if($response!=NULL){
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }

                        $count = 0;
                        if($task->task_id==2){
                            $count = $response['comments']['summary']['total_count'] ?? 0;
                            $socialCustomerCount->fb_comment_post_url_count = $response['comments']['summary']['total_count'] ?? 0;
                        }
                        else if($task->task_id==3){
                            $count = $response['likes']['summary']['total_count'] ?? 0;
                            $socialCustomerCount->fb_like_post_url_count = $response['likes']['summary']['total_count'] ?? 0;
                        }
                        else if($task->task_id==15){
                            $count = $response['shares']['summary']['total_count'] ?? 0;
                            $socialCustomerCount->fb_share_post_url_count = $response['shares']['summary']['total_count'] ?? 0;
                        }
                        
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $task->task_value;
                        $countData->instant_task_id = $task->id;
                        $countData->count = $count;
                        $countData->save();
                    // }
                    // else{
                    //     // return ['status'=> false, 'message'=> 'Facebook page not found!'];
                    // }
                }
                
                // TWITTER
                // #tw_username
                if($task->task_id == 6){
                    $uriSegments = explode("/", parse_url($task->task_value, PHP_URL_PATH));
                    $tweet_ID = array_pop($uriSegments);

                    $prefix = '@';
                    if (substr($tweet_ID, 0, strlen($prefix)) == $prefix) {
                        $tweet_ID = substr($tweet_ID, strlen($prefix));
                    } 

                    //get user id from username
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/users/by/username/'.$tweet_ID);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
                    $headers = array();
                    $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);
    
                    $business_tw = json_decode($result);
                    if(isset($business_tw->data)){
                        $tw_id = $business_tw->data->id;
                    }else{
                        return ['status'=> false,'message'=> 'Twitter account with this username not found.'];
                    }
    
                    //check follower list
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/users/'.$tw_id.'/followers?max_results=1000');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
                    $headers = array();
                    $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $followers = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                    $followersData = json_decode($followers);

                    if(isset($followersData['meta']['result_count'])){
                        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Twitter')->where('data_key','followers')->where('media_id',$tw_id)->orderBy('id','desc')->first();
                        if($countData == null){
                            $countData = new SocialChannel;
                            $countData->user_id = $offer->user_id;
                            $countData->channel = 'Twitter';
                            $countData->type = 'Profile';
                            $countData->data_key = 'followers';
                            $countData->media_id = $tw_id;
                            $countData->instant_task_id = $task->id;
                        }
                        $countData->count = $followersData['meta']['result_count'];
                        $countData->save();

                        $socialCustomerCount->tw_username_count = $followersData['meta']['result_count'];
                    }
                }
                // #tw_tweet_url
                if($task->task_id == 7){
                    $uriSegments = explode("/", parse_url($task->task_value, PHP_URL_PATH));
                    $tweet_ID = array_pop($uriSegments);
    
                    //get user id from username
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/tweets/'.$tweet_ID.'/liking_users');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $headers = array();
                    $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $result = curl_exec($ch);
                    curl_close($ch);
    
                    $likedData = json_decode($result);
                    if(isset($likedData->meta->result_count)){
                        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Twitter')->where('data_key','likes')->where('media_id',$tweet_ID)->orderBy('id','desc')->first();
                        if($countData == null){
                            $countData = new SocialChannel;
                            $countData->user_id = $offer->user_id;
                            $countData->channel = 'Twitter';
                            $countData->type = 'Tweet';
                            $countData->data_key = 'likes';
                            $countData->media_id = $tweet_ID;
                            $countData->instant_task_id = $task->id;
                        }
                        $countData->count = $likedData->meta->result_count;
                        $countData->save();

                        $socialCustomerCount->tw_tweet_url_count = $likedData->meta->result_count;
                    }
                }

                // INSTAGRAM
                // 4 => insta_profile_url => followers_count
                if($task->task_id == 4){  
                    $instagram_user_id = $userSocialConnection->instagram_user_id ?? NULL;

                    $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Instagram')->where('type', 'Post')->where('data_key', 'followers')->orderBy('id','desc')->first();

                    $url=$option->value."/api/instagram/getInstaFollowsFollowersCount";
                    $curl = curl_init();
                    $postfields=[];
                    if(isset($instagram_user_id)){
                        $postfields['instagram_user_id'] = $instagram_user_id;
                    }
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => $postfields,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$social_post_api_token
                        ),
                    ));
            
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);
                    if($response!=NULL){
                        if(isset($response['status']) && $response['status'] == 200 && !isset($response['data']['error'])){
                            $followers_count = $response['data']['followers_count'] ?? 0;
                            if($countData==NULL){
                                $countData = new SocialChannel;
                            }
                            $countData->user_id = $offer->user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = 'Post';
                            $countData->data_key = 'followers';
                            $countData->media_id = $instagram_user_id;
                            $countData->instant_task_id = $task->id;
                            $countData->count = $followers_count;
                            $countData->save();

                            $socialCustomerCount->insta_profile_url_count = $followers_count;
                        }
                    }
                }

                // 5 => #insta_post_url => like
                // 16 => #insta_post_url => comment
                if($task->task_id == 5 || $task->task_id == 16){
                    $countData=[];
                    $type = $data_key = "";
                    if($task->task_id == 5){
                        $type = "Post";
                        $data_key = "likes";
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Instagram')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                    }
                    else if($task->task_id == 16){
                        $type = "Post";
                        $data_key = "comments";
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Instagram')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                    }
                    
                    $url = $option->value."/api/instagram/getInstaPostDetails";

                    // check facebook like
                    $curl = curl_init();
                    $postfields=[];
                    if(isset($facebookPostID)){
                        $postfields['post_id'] = $facebookPostID;
                    }
                    
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => 1,
                        CURLOPT_POSTFIELDS => $postfields,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer '.$social_post_api_token
                        ),
                    ));
            
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response, true);

                    if($countData==NULL){
                        $countData = new SocialChannel;
                    }

                    $count = 0;
                    if($response!=NULL){
                        if(!isset($response['data']['error'])){
                            if($task->task_id == 5){
                                $type = "Post";
                                $data_key = "likes";
                                $count = $response['data']['like_count'] ?? 0;
                                $socialCustomerCount->insta_like_post_url_count = $count ?? 0;
                            }
                            else if($task->task_id == 16){
                                $type = "Post";
                                $data_key = "comments";
                                $count = $response['data']['comments_count'] ?? 0;
                                $socialCustomerCount->insta_comment_post_url_count = $count ?? 0;
                            }

                            $countData->user_id = $offer->user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = $type;
                            $countData->data_key = $data_key;
                            $countData->media_id = $task->task_value;
                            $countData->instant_task_id = $task->id;
                            $countData->count = $count;
                            $countData->save();
                        }
                    }
                }

                // YOUTUBE
                // #yt_channel_url
                if($task->task_id == 10){
                    $uriSegments = explode("/", parse_url($task->task_value, PHP_URL_PATH));
                    $channel_ID = array_pop($uriSegments);
                    
                    $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','subscribers')->orderBy('id','desc')->first();
                    //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';
    
                    //check follower list
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_ID.'&key='.$youtube->api_key);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    
                    $channel = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
    
                    $channelData = json_decode($channel);
                    if(isset($channelData->items)){
                        foreach($channelData->items as $data){
                            if($countData == null){
                                $countData = new SocialChannel;
                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->type = 'Channel';
                                $countData->data_key = 'subscribers';
                                $countData->instant_task_id = $task->id;
                            }
                            $countData->count = $data->statistics->subscriberCount ?? 0;
                            $countData->save();

                            $socialCustomerCount->yt_channel_url_count = $data->statistics->subscriberCount ?? 0;
                        }
                    }else{
                        // return ['status'=> false,'message'=> 'Youtube Channel Not Found.'];
                    }
                }

                // #yt_like_url
                if($task->task_id == 11){
                    $parts = parse_url($task->task_value);
                    parse_str($parts['query'], $query);
                    $videoID = $query['v'];
                    $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','likes')->where('media_id',$videoID)->orderBy('id','desc')->first();
                    //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';
    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $video = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
    
                    $videoData = json_decode($video);
                    if(isset($videoData->items)){
                        foreach($videoData->items as $data){
                            if($countData == null){
                                $countData = new SocialChannel;
                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->type = 'Video';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'likes';
                                $countData->instant_task_id = $task->id;
                            }
                            $countData->count = $data->statistics->likeCount ?? 0;
                            $countData->save();

                            $socialCustomerCount->yt_like_url_count = $data->statistics->likeCount ?? 0;
                        }
                    }else{
                        // return ['status'=> false,'message'=> 'Youtube Channel Not Found.'];
                    }
                }
                // #yt_comment_url
                if($task->task_id == 12){
                    $parts = parse_url($task->task_value);
                    parse_str($parts['query'], $query);
                    $videoID = $query['v'];
    
                    $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','comments')->where('media_id',$videoID)->orderBy('id','desc')->first();
                    //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';
    
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    $video = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);

                    $videoData = json_decode($video);
                    if(isset($videoData->items)){
                        foreach($videoData->items as $data){
                            if($countData == null){
                                $countData = new SocialChannel;
                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->type = 'Video';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'comments';
                                $countData->instant_task_id = $task->id;
                            }
                            $countData->count = $data->statistics->commentCount ?? 0;
                            $countData->save();

                            $socialCustomerCount->yt_comment_url_count = $data->statistics->commentCount ?? 0;
                        }
                    }else{
                        // return ['status'=> false,'message'=> 'Youtube Channel Not Found.'];
                    }
                }                
                // Google Review
                // if($task->task_id == 13){
                //     $media_id = $task->task_value;

                //     $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Google')->where('type', 'Review')->where('data_key', 'review_or_comment')->orderBy('id','desc')->first();

                //     $curl = curl_init();
                //     $postfields=[];
                //     if(isset($media_id)){
                //         $postfields['place_id'] = $media_id;
                //     }
                    
                //     $url=$option->value."/api/google/getGoogleReviews";

                //     curl_setopt_array($curl, array(
                //         CURLOPT_URL => $url,
                //         CURLOPT_POST => 1,
                //         CURLOPT_POSTFIELDS => $postfields,
                //         CURLOPT_RETURNTRANSFER => true,
                //         CURLOPT_HTTPHEADER => array(
                //             'Authorization: Bearer '.$social_post_api_token
                //         ),
                //     ));
                //     $response = curl_exec($curl);
                //     curl_close($curl);
                //     $response = json_decode($response, true);
                    
                //     if($response!=NULL){
                //         if($countData==NULL){
                //             $countData = new SocialChannel;
                //         }
                //         $count = $response['result']['user_ratings_total'] ?? 0;

                //         $countData->user_id = $offer->user_id;
                //         $countData->channel = 'Google';
                //         $countData->type = 'Review';
                //         $countData->data_key = 'review_or_comment';
                //         $countData->media_id = $media_id;
                //         $countData->instant_task_id = $task->id;
                //         $countData->count = $count;
                //         $countData->save();

                //         $socialCustomerCount->google_review_link_count = $count;
                //     }
                //     else{
                //         // return ['status'=> false, 'message'=> 'Facebook page not found!'];
                //     }
                // }
            }
            $socialCustomerCount->save();
        }
        return ['status'=> true,'message'=> 'Social Data Updated Successfully.'];
    }

    public function facebookPageLike(Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();
        if($userSocialConnection->is_facebook_auth==NULL || $userSocialConnection->facebook_page_id==NULL){
            return response()->json(['status'=> false,'message'=> 'Business not connected to Facebook Account!'], 200);
        }

        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Facebook')->where('type', 'Page')->where('data_key','likes')->where('media_id', $userSocialConnection->facebook_page_id)->orderBy('id','desc')->first();

        // if($countData != null){
        //     $old_like_count = (int)$countData->count;
        // }else{
        //     $old_like_count = 0;
        // }

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        if($socialCustomerCount != null){
            $old_like_count = (int)$socialCustomerCount->fb_page_url_count;
        }else{
            $old_like_count = 0;
        }

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/facebook/getPageLikeCount";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        // check facebook like
        $curl = curl_init();
        $postfields=[];
        if(isset($userSocialConnection->facebook_page_id)){
            $postfields['fb_page_id'] = $userSocialConnection->facebook_page_id;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // dd($response);
        $response = json_decode($response, true);

        $tasksCount=array();
        if($response!=NULL){
            $newCount = $response['fan_count'] ?? 0;
            if($old_like_count < $newCount){
                if($countData==NULL){
                    $countData = new SocialChannel;
                }
                
                $countData->user_id = $offer->user_id;
                $countData->channel = 'Facebook';
                $countData->type = 'Page';
                $countData->data_key = 'likes';
                $countData->media_id = $response['id'];
                $countData->instant_task_id = $request->instance_task_id;
                $countData->count = $response['fan_count'] ?? 0;
                $countData->save();

                $socialCustomerCount->fb_page_url_count = $response['fan_count'] ?? 0;
                $socialCustomerCount->save();

                $tasksCount['fb_page_url_count'] = $response['fan_count'] ?? 0;

                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'fb_page_url_count', $response['fan_count'] ?? 0);

                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
            }
            else{
                $tasksCount['fb_page_url_count'] = $newCount;
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['fb_page_url_count'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }

    public function facebookPostComment(Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();
        if($userSocialConnection->is_facebook_auth==NULL || $userSocialConnection->facebook_page_id==NULL){
            return response()->json(['status'=> false,'message'=> 'Business not connected to Facebook Account!'], 200);
        }

        $uriSegments = explode("/", parse_url($request->fb_business, PHP_URL_PATH));
        $media_id = array_pop($uriSegments);
        $facebookPostID = $offer->social_post__db_id ?? '';

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        
        $fb_task_ids = [2, 3, 15];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $fb_task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $fb_task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();
        
        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/facebook/getPostLCSCount";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        // check facebook like
        $curl = curl_init();
        $postfields=[];
        if(isset($facebookPostID)){
            $postfields['post_id'] = $facebookPostID;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        // dd($response, $postfields);

        $tasksCount=array();
        if($response!=NULL){

            $isPostCommentTaskUpdate = $isPostLikeTaskUpdate = $isPostShareTaskUpdate = 0;
            $updatedTasks=[];

            $tasksCount["fb_comment_post_url_count"] = $response['comments']['summary']['total_count'] ?? 0;
            $tasksCount["fb_like_post_url_count"] = $response['likes']['summary']['total_count'] ?? 0;
            $tasksCount["fb_share_post_url_count"] = $response['shares']['summary']['total_count'] ?? 0;

            foreach ($instantTasks as $key => $inTask){
                if($inTask->task_id==2){
                    $commentCount = $response['comments']['summary']['total_count'] ?? 0;
                    $old_fb_comment_post_url_count = $socialCustomerCount->fb_comment_post_url_count;
                    $socialCustomerCount->fb_comment_post_url_count = $commentCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,  'fb_comment_post_url_count', $commentCount);

                    if($old_fb_comment_post_url_count < $commentCount){
                        $isPostCommentTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "comments";
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel','Facebook')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->fb_business)->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $commentCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
                else if($inTask->task_id==3){
                    $likeCount = $response['likes']['summary']['total_count'] ?? 0;
                    $old_fb_like_post_url_count = $socialCustomerCount->fb_like_post_url_count;
                    $socialCustomerCount->fb_like_post_url_count = $likeCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_like_post_url_count', $likeCount);

                    if($old_fb_like_post_url_count < $likeCount){
                        $isPostLikeTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "likes";
                        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Facebook')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->fb_business)->orderBy('id','desc')->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $likeCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
                else if($inTask->task_id==15){
                    $shareCount = $response['shares']['summary']['total_count'] ?? 0;
                    $old_fb_share_post_url_count = $socialCustomerCount->fb_share_post_url_count;
                    $socialCustomerCount->fb_share_post_url_count = $shareCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_share_post_url_count', $shareCount);

                    if($old_fb_share_post_url_count < $shareCount){
                        $isPostShareTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "share";
                        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Facebook')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $shareCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
            }
            
            $socialCustomerCount->save();
            if($isPostCommentTaskUpdate==1 || $isPostLikeTaskUpdate==1 || $isPostShareTaskUpdate==1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['fb_comment_post_url_count'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }

    public function facebookPostLike(Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();
        if($userSocialConnection->is_facebook_auth==NULL || $userSocialConnection->facebook_page_id==NULL){
            return response()->json(['status'=> false,'message'=> 'Business not connected to Facebook Account!'], 200);
        }

        $uriSegments = explode("/", parse_url($request->fb_business, PHP_URL_PATH));
        $media_id = array_pop($uriSegments);
        $facebookPostID = $offer->social_post__db_id ?? '';

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();

        $fb_task_ids = [2, 3, 15];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $fb_task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $fb_task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }
        
        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/facebook/getPostLCSCount";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        // check facebook like
        $curl = curl_init();
        $postfields=[];
        if(isset($facebookPostID)){
            $postfields['post_id'] = $facebookPostID;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);

        $offer_user_id = $offer->user_id;

        $tasksCount=array();
        if($response!=NULL){        
            $isPostCommentTaskUpdate = $isPostLikeTaskUpdate = $isPostShareTaskUpdate = 0;
            $updatedTasks=[];

            $tasksCount["fb_comment_post_url_count"] = $response['comments']['summary']['total_count'] ?? 0;
            $tasksCount["fb_like_post_url_count"] = $response['likes']['summary']['total_count'] ?? 0;
            $tasksCount["fb_share_post_url_count"] = $response['shares']['summary']['total_count'] ?? 0;

            foreach ($instantTasks as $key => $inTask){
                if($inTask->task_id==2){
                    $commentCount = $response['comments']['summary']['total_count'] ?? 0;
                    $old_fb_comment_post_url_count = $socialCustomerCount->fb_comment_post_url_count;
                    $socialCustomerCount->fb_comment_post_url_count = $commentCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_comment_post_url_count', $commentCount);

                    if($old_fb_comment_post_url_count < $commentCount){
                        $isPostCommentTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "comments";
                        $countData = SocialChannel::where('user_id', $offer_user_id)->where('channel','Facebook')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->fb_business)->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }

                        $countData->user_id = $offer_user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $commentCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
                else if($inTask->task_id==3){
                    $likeCount = $response['likes']['summary']['total_count'] ?? 0;
                    $old_fb_like_post_url_count = $socialCustomerCount->fb_like_post_url_count;
                    $socialCustomerCount->fb_like_post_url_count = $likeCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_like_post_url_count', $likeCount);

                    if($old_fb_like_post_url_count < $likeCount){
                        $isPostLikeTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "likes";
                        $countData = SocialChannel::where('user_id',$offer_user_id)->where('channel','Facebook')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->fb_business)->orderBy('id','desc')->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        // dd($offer_user_id);
                        $countData->user_id = $offer_user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $likeCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
                else if($inTask->task_id==15){
                    $shareCount = $response['shares']['summary']['total_count'] ?? 0;
                    $old_fb_share_post_url_count = $socialCustomerCount->fb_share_post_url_count;
                    $socialCustomerCount->fb_share_post_url_count = $shareCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_share_post_url_count', $shareCount);

                    if($old_fb_share_post_url_count < $shareCount){
                        $isPostShareTaskUpdate = 1;

                        $type = "Post";
                        $data_key = "share";
                        $countData = SocialChannel::where('user_id', $offer_user_id)->where('channel', 'Facebook')->where('type', $type)->where('data_key', $data_key)->orderBy('id','desc')->first();
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }

                        $countData->user_id = $offer_user_id;
                        $countData->channel = 'Facebook';
                        $countData->type = $type;
                        $countData->data_key = $data_key;
                        $countData->media_id = $request->fb_business;
                        $countData->instant_task_id = $request->instance_task_id;
                        $countData->count = $shareCount;
                        $countData->save();

                        $updatedTasks[$inTask->task->task_key]=[
                            'task_id' => $inTask->task_id,
                            'task_key' => $inTask->task->task_key,
                            'instant_task_id' => $inTask->id,
                        ];
                    }
                }
            }
            
            $socialCustomerCount->save();
            if($isPostCommentTaskUpdate==1 || $isPostLikeTaskUpdate==1 || $isPostShareTaskUpdate==1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['fb_like_post_url_count'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }

    public function verifyTwFollow(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Twitter credentials not found.'], 200);
        }

        $uriSegments = explode("/", parse_url($request->tw_business, PHP_URL_PATH));
        $tweet_ID = array_pop($uriSegments);

        $prefix = '@';
        if (substr($tweet_ID, 0, strlen($prefix)) == $prefix) {
            $tweet_ID = substr($tweet_ID, strlen($prefix));
        }

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;

        // Get Count by V1
        $url = 'https://api.twitter.com/1.1/users/show.json?screen_name='.$tweet_ID;
        $postCount = $this->_getRequestCount($url, $headers);
        $postCount = json_decode($postCount, true);

        if(isset($postCount['followers_count'])){

            $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel','Twitter')->where('data_key','followers')->where('media_id', $tweet_ID)->orderBy('id','desc')->first();

            $customer_id = $subscription->customer_id ?? 0;
            $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
            
            $tw_tot_count = $postCount['followers_count'] ?? 0;
            $tasksCount['tw_username_count'] = $postCount['followers_count'] ?? 0;

            if($tw_tot_count > $socialCustomerCount->tw_username_count){
                if($countData == null){
                    $countData = new SocialChannel;
                    $countData->user_id = $offer->user_id;
                    $countData->channel = 'Twitter';
                    $countData->type = 'Profile';
                    $countData->data_key = 'followers';
                    $countData->media_id = $tweet_ID;
                    $countData->instant_task_id = $request->instance_task_id;
                }
                $countData->count = $tw_tot_count;
                $countData->save();

                $socialCustomerCount->tw_username_count = $tw_tot_count;
                $socialCustomerCount->save();

                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'tw_username_count', $tw_tot_count);

                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['tw_username_count'] = $postCount;
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    }
    
    /* public function verifyTwFollow(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Twitter credentials not found.'], 200);
        }

        $uriSegments = explode("/", parse_url($request->tw_business, PHP_URL_PATH));
        $tweet_ID = array_pop($uriSegments);

        $prefix = '@';
        if (substr($tweet_ID, 0, strlen($prefix)) == $prefix) {
            $tweet_ID = substr($tweet_ID, strlen($prefix));
        }

        //get user id from username
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/users/by/username/'.$tweet_ID);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);

        $business_tw = json_decode($result);

        // COMMENT FOR TEST CLICK FUNCTIONALITY
        if(isset($business_tw->data)){
            $tw_id = $business_tw->data->id;
        }else{
            return response()->json(['status'=> false,'message'=> 'Twitter account with this username not found.'], 200);
        }

        sleep(5);

        //check follower list
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/users/'.$tw_id.'/followers?max_results=1000');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $followers = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $followersData = json_decode($followers);  
        
        $tasksCount=array();
        if(isset($followersData->meta->result_count)){

            $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Twitter')->where('data_key','followers')->where('media_id',$tw_id)->orderBy('id','desc')->first();

            $customer_id = $subscription->customer_id ?? 0;
            $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
            
            $tw_tot_count = $followersData->meta->result_count;
            $tasksCount['tw_username_count'] = $followersData->meta->result_count;

            if($tw_tot_count > $socialCustomerCount->tw_username_count){
                if($countData == null){
                    $countData = new SocialChannel;
                    $countData->user_id = $offer->user_id;
                    $countData->channel = 'Twitter';
                    $countData->type = 'Profile';
                    $countData->data_key = 'followers';
                    $countData->media_id = $tw_id;
                    $countData->instant_task_id = $request->instance_task_id;
                }
                $countData->count = $followersData->meta->result_count;
                $countData->save();

                $socialCustomerCount->tw_username_count = $followersData->meta->result_count;
                $socialCustomerCount->save();

                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'tw_username_count', $followersData->meta->result_count);

                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }else{
            $tasksCount['tw_username_count'] = "response is null";
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    } */

    public function verifyTwTweetLikedBy(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Twitter credentials not found.'], 200);
        }

        $uriSegments = explode("/", parse_url($request->tw_business, PHP_URL_PATH));
        $tweet_ID = array_pop($uriSegments);

        sleep(5);

        //get user id from username
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/tweets/'.$tweet_ID.'/liking_users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        curl_close($ch);

        $likedData = json_decode($result);

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();

        $tasksCount=array();
        // COMMENT FOR TEST CLICK FUNCTIONALITY
        if(isset($likedData->meta->result_count) && $likedData->meta->result_count > $socialCustomerCount->tw_tweet_url_count){
            $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Twitter')->where('data_key','likes')->where('media_id',$tweet_ID)->orderBy('id','desc')->first();
            
            if($countData == null){
                $countData = new SocialChannel;
                $countData->user_id = $offer->user_id;
                $countData->channel = 'Twitter';
                $countData->type = 'Tweet';
                $countData->data_key = 'likes';
                $countData->media_id = $tweet_ID;
                $countData->instant_task_id = $task->id;
            }
            $countData->count = $likedData->meta->result_count ?? 0;
            $countData->save();

            $socialCustomerCount->tw_tweet_url_count = $likedData->meta->result_count ?? 0;
            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id, 'tw_tweet_url_count', $likedData->meta->result_count ?? 0);

            $socialCustomerCount->save();
            
            $tasksCount['tw_tweet_url_count'] = $likedData->meta->result_count ?? 0;
            return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
        }
        else{
            $tasksCount['tw_tweet_url_count'] = "response is null";
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    }

    public function instagramProfileFollowers (Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

        // $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Facebook')->where('type', 'Page')->where('data_key','likes')->where('media_id', $userSocialConnection->facebook_page_id)->orderBy('id','desc')->first();

        $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', 'Instagram')->where('type', 'Post')->where('data_key', 'followers')->where('media_id', $userSocialConnection->instagram_user_id)->orderBy('id','desc')->first();

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        if($socialCustomerCount != null){
            $old_followers_count = (int)$socialCustomerCount->insta_profile_url_count;
        }else{
            $old_followers_count = 0;
        }

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/instagram/getInstaFollowsFollowersCount";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        $curl = curl_init();
        $postfields=[];
        $postfields['instagram_user_id'] = $userSocialConnection->instagram_user_id;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        $tasksCount=array();
        if($response!=NULL){
            if(isset($response['status']) && $response['status'] == 200 && !isset($response['data']['error'])){
                $followers_count = $response['data']['followers_count'] ?? 0;
                $tasksCount['insta_profile_url_count'] = $followers_count;

                if($old_followers_count < $followers_count){
                    if($countData==NULL){
                        $countData = new SocialChannel;
                    }

                    $countData->user_id = $offer->user_id;
                    $countData->channel = 'Instagram';
                    $countData->type = 'Post';
                    $countData->data_key = 'followers';
                    $countData->media_id = $userSocialConnection->instagram_user_id;
                    $countData->instant_task_id = $request->instance_task_id;
                    $countData->count = $followers_count;
                    $countData->save();

                    $socialCustomerCount->insta_profile_url_count = $followers_count;
                    $socialCustomerCount->save();

                    app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'insta_profile_url_count', $followers_count);

                    return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
                }
                else{
                    return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
                }        
            }
            else{
                $tasksCount['insta_profile_url_count'] = "response is null";
                return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
            }
        }
        else{
            $tasksCount['insta_profile_url_count'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }

    public function instagramPostLike(Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        // $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

        $uriSegments = explode("/", parse_url($request->insta_business, PHP_URL_PATH));
        $media_id = array_pop($uriSegments);
        $offer_social_post_id = $offer->social_post__db_id ?? '';

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        
        $task_ids = [5, 16];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/instagram/getInstaPostDetails";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        // check facebook like
        $curl = curl_init();
        $postfields=[];
        if(isset($offer_social_post_id)){
            $postfields['post_id'] = $offer_social_post_id;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        // dd($response, $postfields, $url);

        $offer_user_id = $offer->user_id;

        $tasksCount=array();
        if($response!=NULL){ 
            $isPostLikeTaskUpdate = $isPostCommentTaskUpdate = 0;
            if(!isset($response['data']['error'])){
                $updatedTasks=[];

                $tasksCount['insta_like_post_url_count'] = $response['data']['like_count'] ?? 0;
                $tasksCount['insta_comment_post_url_count'] = $response['data']['comments_count'] ?? 0;

                foreach ($instantTasks as $key => $inTask){
                    if($inTask->task_id==5){
                        $likeCount = $response['data']['like_count'] ?? 0;
                        $old_insta_like_post_url_count = $socialCustomerCount->insta_like_post_url_count;
                        $socialCustomerCount->insta_like_post_url_count = $likeCount ?? 0;

                        app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_like_post_url_count', $likeCount ?? 0);

                        if($old_insta_like_post_url_count < $likeCount){
                            $isPostLikeTaskUpdate = 1;

                            $type = "Post";
                            $data_key = "likes";
                            $countData = SocialChannel::where('user_id',$offer_user_id)->where('channel','Instagram')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->insta_business)->orderBy('id','desc')->first();
                            if($countData==NULL){
                                $countData = new SocialChannel;
                            }

                            $countData->user_id = $offer_user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = $type;
                            $countData->data_key = $data_key;
                            $countData->media_id = $request->insta_business;
                            $countData->instant_task_id = $request->instance_task_id;
                            $countData->count = $likeCount;
                            $countData->save();

                            $updatedTasks[$inTask->task->task_key]=[
                                'task_id' => $inTask->task_id,
                                'task_key' => $inTask->task->task_key,
                                'instant_task_id' => $inTask->id,
                            ];
                        }
                    }
                    else if($inTask->task_id==16){
                        $commentCount = $response['data']['comments_count'] ?? 0;
                        $old_insta_comment_post_url_count = $socialCustomerCount->insta_comment_post_url_count;
                        $socialCustomerCount->insta_comment_post_url_count = $commentCount ?? 0;

                        app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_comment_post_url_count', $commentCount ?? 0);

                        if($old_insta_comment_post_url_count < $commentCount){
                            $isPostCommentTaskUpdate = 1;

                            $type = "Post";
                            $data_key = "comments";
                            $countData = SocialChannel::where('user_id',$offer_user_id)->where('channel','Instagram')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->insta_business)->orderBy('id','desc')->first();
                            if($countData==NULL){
                                $countData = new SocialChannel;
                            }

                            $countData->user_id = $offer_user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = $type;
                            $countData->data_key = $data_key;
                            $countData->media_id = $request->insta_business;
                            $countData->instant_task_id = $request->instance_task_id;
                            $countData->count = $commentCount;
                            $countData->save();

                            $updatedTasks[$inTask->task->task_key]=[
                                'task_id' => $inTask->task_id,
                                'task_key' => $inTask->task->task_key,
                                'instant_task_id' => $inTask->id,
                            ];
                        }
                    }
                }
            }
            $socialCustomerCount->save();
            if($isPostLikeTaskUpdate == 1 || $isPostCommentTaskUpdate == 1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                $tasksCount['res'] = "response is null";
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['res'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }

    public function instagramPostComment(Request $request)
    {
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        // $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

        $uriSegments = explode("/", parse_url($request->insta_business, PHP_URL_PATH));
        $media_id = array_pop($uriSegments);
        $offer_social_post_id = $offer->social_post__db_id ?? '';

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        
        $task_ids = [5, 16];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        $url=$option->value."/api/instagram/getInstaPostDetails";
        $social_post_api_token = $userDetail->social_post_api_token;

        sleep(5);

        // check facebook like
        $curl = curl_init();
        $postfields=[];
        if(isset($offer_social_post_id)){
            $postfields['post_id'] = $offer_social_post_id;
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        // dd($response, $postfields, $url);

        $offer_user_id = $offer->user_id;

        $tasksCount=array();
        if($response!=NULL){ 
            $isPostLikeTaskUpdate = $isPostCommentTaskUpdate = 0;
            if(!isset($response['data']['error'])){
                $updatedTasks=[];

                $tasksCount['insta_like_post_url_count'] = $response['data']['like_count'] ?? 0;
                $tasksCount['insta_comment_post_url_count'] = $response['data']['comments_count'] ?? 0;

                foreach ($instantTasks as $key => $inTask){
                    if($inTask->task_id==5){
                        $likeCount = $response['data']['like_count'] ?? 0;
                        $old_insta_like_post_url_count = $socialCustomerCount->insta_like_post_url_count;
                        $socialCustomerCount->insta_like_post_url_count = $likeCount ?? 0;

                        app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_like_post_url_count', $likeCount ?? 0);

                        if($old_insta_like_post_url_count < $likeCount){
                            $isPostLikeTaskUpdate = 1;

                            $type = "Post";
                            $data_key = "likes";
                            $countData = SocialChannel::where('user_id',$offer_user_id)->where('channel','Instagram')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->insta_business)->orderBy('id','desc')->first();
                            if($countData==NULL){
                                $countData = new SocialChannel;
                            }

                            $countData->user_id = $offer_user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = $type;
                            $countData->data_key = $data_key;
                            $countData->media_id = $request->insta_business;
                            $countData->instant_task_id = $request->instance_task_id;
                            $countData->count = $likeCount;
                            $countData->save();

                            $updatedTasks[$inTask->task->task_key]=[
                                'task_id' => $inTask->task_id,
                                'task_key' => $inTask->task->task_key,
                                'instant_task_id' => $inTask->id,
                            ];
                        }
                    }
                    else if($inTask->task_id==16){
                        $commentCount = $response['data']['comments_count'] ?? 0;
                        $old_insta_comment_post_url_count = $socialCustomerCount->insta_comment_post_url_count;
                        $socialCustomerCount->insta_comment_post_url_count = $commentCount ?? 0;

                        app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_comment_post_url_count', $commentCount ?? 0);

                        if($old_insta_comment_post_url_count < $commentCount){
                            $isPostCommentTaskUpdate = 1;

                            $type = "Post";
                            $data_key = "comments";
                            $countData = SocialChannel::where('user_id',$offer_user_id)->where('channel','Instagram')->where('type', $type)->where('data_key', $data_key)->where('media_id', $request->insta_business)->orderBy('id','desc')->first();
                            if($countData==NULL){
                                $countData = new SocialChannel;
                            }

                            $countData->user_id = $offer_user_id;
                            $countData->channel = 'Instagram';
                            $countData->type = $type;
                            $countData->data_key = $data_key;
                            $countData->media_id = $request->insta_business;
                            $countData->instant_task_id = $request->instance_task_id;
                            $countData->count = $commentCount;
                            $countData->save();

                            $updatedTasks[$inTask->task->task_key]=[
                                'task_id' => $inTask->task_id,
                                'task_key' => $inTask->task->task_key,
                                'instant_task_id' => $inTask->id,
                            ];
                        }
                    }
                }
            }
            $socialCustomerCount->save();
            if($isPostLikeTaskUpdate == 1 || $isPostCommentTaskUpdate == 1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }
        else{
            $tasksCount['insta_comment_post_url_count'] = "response is null";
            return ['status'=> false, 'message'=> 'Not verified!', 'tasksCount'=>$tasksCount];
        }
    }



    public function verifyYoutubeSubscribe(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
        if($youtube_data != null){
            $youtube = json_decode($youtube_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Youtube credentials not found.'], 200);
        }

        $uriSegments = explode("/", parse_url($request->yt_business, PHP_URL_PATH));
        $channel_ID = array_pop($uriSegments);
        //dd($channel_ID);
        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','subscribers')->orderBy('id','desc')->first();
        if($countData != null){
            $old_subscribers_count = (int)$countData->count;
        }else{
            $old_subscribers_count = 0;
        }

        //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';

        sleep(5);

        // COMMENT FOR TEST CLICK FUNCTIONALITY
        //check follower list
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_ID.'&key='.$youtube->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $channel = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $channelData = json_decode($channel);
        
        $tasksCount=array();
        if(isset($channelData->items)){
            $customer_id = $subscription->customer_id ?? 0;
            $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
            
            foreach($channelData->items as $data){
                if(isset($data->statistics->hiddenSubscriberCount) && $data->statistics->hiddenSubscriberCount == true){
                    return response()->json(['status'=> false,'message'=> 'Subscribers count is kept hidden on this channel.'], 200);
                }

                if($channel_ID == $data->id){
                    $subscriberCount = $data->statistics->subscriberCount ?? 0;
                    $old_yt_channel_url_count = $socialCustomerCount->yt_channel_url_count;
                    $socialCustomerCount->yt_channel_url_count = $subscriberCount;

                    $tasksCount['yt_channel_url_count'] = $subscriberCount;

                    if($old_yt_channel_url_count < $subscriberCount){
                        if($countData==NULL){
                            $countData = new SocialChannel;
                        }
                        
                        $countData->user_id = $offer->user_id;
                        $countData->channel = 'Youtube';
                        $countData->type = 'Channel';
                        $countData->data_key = 'subscribers';
                        $countData->instant_task_id = $request->instance_task_id;
                    
                        $countData->count = $data->statistics->subscriberCount ?? 0;
                        $countData->save();

                        $socialCustomerCount->save(); 

                        app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'yt_channel_url_count', $data->statistics->subscriberCount ?? 0);

                        return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
                    }
                }
            }

            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }else{
            $tasksCount['yt_channel_url_count'] = "response is null";
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    }

    public function verifyYoutubeComment(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
        if($youtube_data != null){
            $youtube = json_decode($youtube_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Youtube credentials not found.'], 200);
        }

        // COMMENT FOR TEST CLICK FUNCTIONALITY

        $parts = parse_url($request->yt_business);
        if(isset($parts['query'])){
            parse_str($parts['query'], $query);
            $videoID = $query['v'];
        }

        // $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','comments')->where('media_id',$videoID)->orderBy('id','desc')->first();
        // if($countData != null){
        //     $old_comment_count = (int)$countData->count;
        // }else{
        //     $old_comment_count = 0;
        // }

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        
        $youtube_task_ids = [11, 12];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $youtube_task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $youtube_task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();

        //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';
        sleep(5);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $video = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $videoData = json_decode($video);
        $tasksCount=array();
        if(isset($videoData->items)){
            $isPostCommentTaskUpdate = $isPostLikeTaskUpdate = 0;
            $updatedTasks=[];

            foreach($videoData->items as $data){
                foreach ($instantTasks as $key => $inTask){
                    if($inTask->task_id==11){

                        if($videoID == $data->id){
                            $likeCount = $data->statistics->likeCount ?? 0;
                            $old_yt_like_url_count = $socialCustomerCount->yt_like_url_count;
                            $socialCustomerCount->yt_like_url_count = $likeCount;

                            $tasksCount['yt_like_url_count'] = $likeCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_like_url_count', $likeCount);

                            if($old_yt_like_url_count < $likeCount){
                                $isPostLikeTaskUpdate = 1;

                                $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','likes')->where('media_id',$videoID)->orderBy('id','desc')->first();

                                if($countData==NULL){
                                    $countData = new SocialChannel;
                                }
                                
                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'likes';
                                $countData->instant_task_id = $request->instance_task_id;
                                $countData->count = $likeCount;
                                $countData->save();
                            
                                $updatedTasks[$inTask->task->task_key]=[
                                    'task_id' => $inTask->task_id,
                                    'task_key' => $inTask->task->task_key,
                                    'instant_task_id' => $inTask->id,
                                ];
                            }
                        }
                    }
                    else if($inTask->task_id==12){
                        if($videoID == $data->id){
                            $commentCount = $data->statistics->commentCount ?? 0;
                            $old_yt_comment_url_count = $socialCustomerCount->yt_comment_url_count;
                            $socialCustomerCount->yt_comment_url_count = $commentCount;

                            $tasksCount['yt_comment_url_count'] = $commentCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_comment_url_count', $commentCount);

                            if($old_yt_comment_url_count < $commentCount){
                                $isPostCommentTaskUpdate = 1;

                                $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','comments')->where('media_id',$videoID)->orderBy('id','desc')->first();

                                if($countData==NULL){
                                    $countData = new SocialChannel;
                                }

                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'comments';
                                $countData->instant_task_id = $request->instance_task_id;
                                $countData->count = $commentCount;
                                $countData->save();

                                $updatedTasks[$inTask->task->task_key]=[
                                    'task_id' => $inTask->task_id,
                                    'task_key' => $inTask->task->task_key,
                                    'instant_task_id' => $inTask->id,
                                ];
                            }
                        }
                    }
                }
            }
            // dd($updatedTasks);
            $socialCustomerCount->save();
            if($isPostCommentTaskUpdate==1 || $isPostLikeTaskUpdate==1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }else{
            $tasksCount['yt_comment_url_count'] = "response is null";
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    }

    public function verifyYoutubeLike(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }
        
        $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
        if($youtube_data != null){
            $youtube = json_decode($youtube_data->value);
        }else{
            return response()->json(['status'=> false,'message'=> 'Youtube credentials not found.'], 200);
        }

        $parts = parse_url($request->yt_business);
        $videoID="";
        if(isset($parts['query'])){
            parse_str($parts['query'], $query);
            $videoID = $query['v'];
        }

        // $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','likes')->where('media_id',$videoID)->orderBy('id','desc')->first();
        // if($countData != null){
        //     $old_like_count = (int)$countData->count;
        // }else{
        //     $old_like_count = 0;
        // }

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        
        $youtube_task_ids = [11, 12];

        $userInfo = user::find($offer->user_id);
        $isUserFree = $userInfo->current_account_status ?? NULL;
        $taskIds=[];
        if($isUserFree=="free"){
            $taskIds = Task::whereIn('id', $youtube_task_ids)->where('visible_to_free_user', 1)->pluck('id')->toArray();
        }else{
            $taskIds = Task::whereIn('id', $youtube_task_ids)->where('coming_soon', 0)->where('status', 1)->pluck('id')->toArray();
        }

        $instantTaskIds = InstantTask::with('task')->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->pluck('id')->toArray();

        // Check Completed Tasks
        $completeTasks = CompleteTask::whereIn('instant_task_id', $instantTaskIds)->where('user_id', $offer->user_id)->where('customer_id', $customer_id ?? 0)->pluck('instant_task_id')->toArray();
        
        $instantTasks = InstantTask::with('task')->whereNotIn('id', $completeTasks)->whereIn('task_id', $taskIds)->where('user_id', $offer->user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();

        //$api_key = 'AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8';
        sleep(5);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $video = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $videoData = json_decode($video);
        $tasksCount=array();
        if(isset($videoData->items)){
            $isPostCommentTaskUpdate = $isPostLikeTaskUpdate = 0;
            $updatedTasks=[];
            
            foreach($videoData->items as $data){
                foreach ($instantTasks as $key => $inTask){
                    if($inTask->task_id==11){
                        if($videoID == $data->id){
                            $likeCount = $data->statistics->likeCount ?? 0;
                            $old_yt_like_url_count = $socialCustomerCount->yt_like_url_count;
                            $socialCustomerCount->yt_like_url_count = $likeCount;

                            $tasksCount['yt_like_url_count'] = $likeCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_like_url_count', $likeCount);

                            if($old_yt_like_url_count < $likeCount){
                                $isPostLikeTaskUpdate = 1;

                                $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','likes')->where('media_id',$videoID)->orderBy('id','desc')->first();

                                if($countData==NULL){
                                    $countData = new SocialChannel;
                                }

                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->type = 'Video';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'likes';
                                $countData->instant_task_id = $request->instance_task_id;
                                $countData->count = $likeCount;
                                $countData->save();
                            
                                $updatedTasks[$inTask->task->task_key]=[
                                    'task_id' => $inTask->task_id,
                                    'task_key' => $inTask->task->task_key,
                                    'instant_task_id' => $inTask->id,
                                ];
                            }
                        }
                    }
                    else if($inTask->task_id==12){
                        if($videoID == $data->id){
                            $commentCount = $data->statistics->commentCount ?? 0;
                            $old_yt_comment_url_count = $socialCustomerCount->yt_comment_url_count;
                            $socialCustomerCount->yt_comment_url_count = $commentCount;

                            $tasksCount['yt_comment_url_count'] = $commentCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_comment_url_count', $commentCount);

                            if($old_yt_comment_url_count < $commentCount){
                                $isPostCommentTaskUpdate = 1;

                                $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Youtube')->where('data_key','comments')->where('media_id',$videoID)->orderBy('id','desc')->first();

                                if($countData==NULL){
                                    $countData = new SocialChannel;
                                }
                                
                                $countData->user_id = $offer->user_id;
                                $countData->channel = 'Youtube';
                                $countData->type = 'Video';
                                $countData->media_id = $videoID;
                                $countData->data_key = 'comments';
                                $countData->instant_task_id = $request->instance_task_id;
                                $countData->count = $commentCount;
                                $countData->save();

                                $updatedTasks[$inTask->task->task_key]=[
                                    'task_id' => $inTask->task_id,
                                    'task_key' => $inTask->task->task_key,
                                    'instant_task_id' => $inTask->id,
                                ];
                            }
                        }
                    }
                }
            }

            // dd($updatedTasks);
            $socialCustomerCount->save();
            if($isPostCommentTaskUpdate==1 || $isPostLikeTaskUpdate==1){
                return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'updatedTasks'=>$updatedTasks, 'tasksCount'=>$tasksCount], 200);
            }
            else{
                return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
            }
        }else{
            $tasksCount['yt_like_url_count'] = "response is null";
            return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
        }
    }

    // Google Review
    /*
    public function verifyGoogleReview(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $media_id = $request->google_business;
        $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Google')->where('type', 'Review')->where('data_key','review_or_comment')->where('media_id', $media_id)->orderBy('id','desc')->first();

        if($countData != null){
            $old_count = (int)$countData->count;
        }else{
            $old_count = 0;
        }

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);

        sleep(5);

        $curl = curl_init();
        $postfields=[];
        if(isset($media_id)){
            $postfields['place_id'] = $media_id;
        }
        if(isset($media_id)){
            $postfields['name'] = $request->google_username;
        }
        
        $url=$option->value."/api/google/getGoogleReviewsVerification";
        $social_post_api_token = $userDetail->social_post_api_token;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$social_post_api_token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);

        $status = $response['status']=="Verified" ? "Thank you for reviewing us!" : "You have not review yet!";
        $count = $response['newestdata']['result']['user_ratings_total'] ?? $response['most_relevant']['result']['user_ratings_total'];

        if($response['status']=="Verified"){
            if($countData==NULL){
                $countData = new SocialChannel;
            }
            
            $countData->user_id = $offer->user_id;
            $countData->channel = 'Google';
            $countData->type = 'Review';
            $countData->media_id = $media_id;
            $countData->data_key = 'review_or_comment';
            $countData->instant_task_id = $request->instance_task_id;
            $countData->count = $count;
            $countData->save();

            $customer_id = $subscription->customer_id ?? 0;
            $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
            $socialCustomerCount->google_review_link_count = $count;
            $socialCustomerCount->save();

            $customer = Customer::where('id',$subscription->customer_id)->first();

            // deduct message from message wallet
            $user_id = $offer->user_id;
            $channel_id = 2;
            $mobile = "91".$customer->mobile;
            $message = "Google Review";
            $related_to1 = "Google Review";
            $sent_via1 = "google_review";
            $status1 = 1;
            return response()->json(['status'=> true,'message'=> 'Verified successfully!'], 200);
        }
        else{
            return response()->json(['status'=> false,'message'=> 'Not verified!'], 200);
        }
    }
    */

    public function googleReviewAuth(Request $request){
        $google_id = $request->google_id ?? NULL;
        return view('instant-challenge.redirect-google-login', compact('google_id'));
    }

    public function verifyGoogleReview(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        // $media_id = $request->google_business;
        // $countData = SocialChannel::where('user_id',$offer->user_id)->where('channel','Google')->where('type', 'Review')->where('data_key','review_or_comment')->where('media_id', $media_id)->orderBy('id','desc')->first();
        $userDetail = User::find($offer->user_id);

        if($request->requestType == "sendUrl"){
            $one_extra_field_value = decrypt($request->one_extra_field_value);
            $option=Option::where('key', 'google_review_verify_url')->first();
            
            $sendUrl = $option->value ?? NULL;
            $checkGoogleReviewUrl = $sendUrl."google/getGoogleReviews?url=".$one_extra_field_value;
            $headers=[];
            $urlResult = $this->_getRequestCount($checkGoogleReviewUrl, $headers);
            if($urlResult==false){
                $urlResult=[];
            }
            else{
                // dd($urlResult, $headers, $checkGoogleReviewUrl);
                $urlResult = json_decode($urlResult);
                // Verify Google Review
                $review_id = $request->review_id ?? NULL;
                
                $tasksCount['review_id'] = $review_id;
                $tasksCount['urlResult'] = $urlResult;
                
                if($urlResult==NULL){
                    return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
                }elseif(in_array($review_id, $urlResult)){
                    return response()->json(['status'=> true,'message'=> 'Verified successfully!', 'tasksCount'=>$tasksCount], 200);
                }
                else{
                    return response()->json(['status'=> false,'message'=> 'Not verified!', 'tasksCount'=>$tasksCount], 200);
                }
            }
        }
        else{
            $option=Option::where('key', 'social_post_url')->first();

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$userDetail->social_post_api_token ?? NULL;

            $getContribId = $option->value."/api/google/connect?callback_url=".URL::to('/google-review-auth');
            $response = $this->_getRequestCount($getContribId, $headers);
            if($response==NULL){
                return response()->json(['status'=> true, 'message'=>"Data not found"], 200);
            }
            else{
                // return view('instant-challenge.redirect-google-login', compact('response'));
                return response()->json(['status'=> true, 'htmlAuth'=>$response], 200);
            }
        }
    }

    public function sendInstantCode(Request $request){

        $subscription = OfferSubscription::where('uuid',$request->uuid)->first();
        if($subscription == null){
            return response()->json(['status'=> true, 'type' => 'error', 'message'=> 'Subscription link is not valid!'], 200);
        }

        $redeem = Redeem::where('offer_subscription_id',$subscription->id)->orderBy('id','desc')->first();
        if($redeem != null){
            if($redeem->is_redeemed == 1){
                return response()->json(['status'=> true, 'type' => 'info', 'message'=> 'Already redeemed!'], 200);
            }else{
                return response()->json(['status'=> true, 'type' => 'info', 'message'=> 'Redeem code already sent!'], 200);
            }
        }


        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'instant_challenge_subscription');
        $messageWallet = MessageWallet::where('user_id', $subscription->user_id)->first();
        
        // dd($messageWallet, $deductionDetail);
        // if($deductionDetail->amount > $messageWallet->wallet_balance){
        //     return response()->json(['status'=> false, 'type' => 'info','message'=> 'Failed to send. Do not have enough balance.'], 200);
        // }
        

        $completed_count = CompleteTask::where('offer_subscription_id',$subscription->id)
                                        ->whereNull('deleted_at')
                                        ->count();

        $settings = OfferSubscriptionReward::where('offer_subscription_id',$subscription->id)->first();
        $settings->details = json_decode($settings->details, true);
        
        $targetData = $settings->details['minimum_task'];
        $targetData = (int)$targetData;
        $subscription->status = (int)$subscription->status;

        if(($completed_count >= $targetData) && $subscription->status != "2"){
            
            //create redeem
            //$redeem_code = $this->getRedeemCode($subscription->id);
            $redeem_code = $this->getRedeemCodeNew($subscription->id);
            
            $customer = Customer::where('id',$subscription->customer_id)->first();

            $businessData = BusinessDetail::where('user_id', $subscription->user_id)->first();
            $biz_name = $businessData->business_name ?? 'business owner';
            if(strlen($biz_name) > 28){
                $biz_name = substr($biz_name,0,28).'..';
            }


            //code commented by Pravin Makde
            $code = $redeem_code;
            /* Coupon Code Condition */
            /*if($businessData->user_id == 49){
                $code = 'INSTANT20';
            }*/


            $phoneNumber = '91'.$customer->mobile;

            if($settings->type == 'No Reward'){
                $message = $whatsapp_msg = "Thank you for taking the time to engage with us on social media!\nYour support and interest in ".$biz_name." mean a lot to us.\nOPNLNK";
            }else{
                $message = "Great! You have successfully completed the task!\nShare the redeem code ".$code." with ".$biz_name." and get your offer discount.\nOPNLNK";

                $whatsapp_msg = "Congratulations on completing the *Instant Challenge* for *".$biz_name."!*\n\nAs a prize for your efforts, we're excited to offer you a redeem code:\n\n*".$code."*\n\nthat you can use to claim your prize.\n\nSimply show/send this code at *".$biz_name."!* to confirm and avail your discount/gift.\n\nWe appreciate your support and are thrilled to have you as a part of our *Instant Challenge* program.\n\nThank you for spreading the word about our business and helping us grow. Keep up the great work!\n\nBest Regards,\n*".$biz_name."!*";
            }

            $params = [
                "mobile" => $phoneNumber,
                "message" => $message,
                "channel_id" => 2,
                'whatsapp_msg' => $whatsapp_msg,
                'sms_msg' => $message,
                "user_id" => $subscription->user_id
            ];
            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
            // dd($sendLink);
            $link_by_sms = $link_by_wa = false;
            $err_by_sms = $err_by_wa = '';
            if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                $link_by_wa = true;
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

            // dd($sendLink);
            if($link_by_sms == true || $link_by_wa == true){

                $user_id = $subscription->user_id;
                $channel_id = 2;
                $mobile = $phoneNumber;
                
                if($link_by_sms == true){
                    $related_to1 = "Generate redeem code";
                    $sent_via1 = "sms";
                    $status1 = 1;
                    $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                    //Deduct Message Cost
                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory->id, $customer->id, 0);
                }
                if($link_by_wa == true){
                    $related_to1 = "Generate redeem code";
                    $sent_via1 = "wa";
                    $status1 = 1;
                    $messageHistory = $this->_addMessageHistory($user_id, $channel_id, $mobile, $whatsapp_msg, $related_to1, $sent_via1, $status1);
                }
                
                $redeem = new Redeem;
                $redeem->user_id = $subscription->user_id;
                $redeem->offer_id = $subscription->offer_id;
                $redeem->offer_subscription_id = $subscription->id;
                $redeem->code = $code;
                $redeem->is_redeemed = 0;
                $redeem->save();


                // Instant challenge redeem cost
                $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'instant_challenge_subscription');
                DeductionHelper::deductWalletBalance($user_id, $deductionDetail->id ?? 0, $channel_id, 0, $customer->id, 0);

                $subscription->status = "2";
                $subscription->save();

                if($redeem){
                    $couponArray = array();
                    $couponArray = [
                        'reedemCode' => $redeem->code,
                        'type' => $settings->type,
                        'details' => $settings->details,
                        'phone' => $customer->mobile,
                    ];
                    
                    app('App\Http\Controllers\Admin\CouponController')->instantReedemCoupon($couponArray);
                }

                return response()->json(['status'=> true, 'type' => 'success', 'message'=> 'Redeem code sent successfully!'], 200);
            }
            else{
                Redeem::destroy($redeem->id);
                
                if($err_by_wa != "Route not active"){
                    return response()->json(["status" => false, "message" => $err_by_wa]);
                }
    
                if($link_by_sms != "Route not active"){
                    return response()->json(["status" => false, "message" => $link_by_sms]);
                }
    
                return response()->json(["status" => false, "message" => "Route not active"]);
            }

        }else{
            return response()->json(['status'=> false, 'type' => 'info','message'=> 'Please, first complete your tasks.'], 200);
        }
    }

    public function getRedeemCode($subsc_id){
        $code = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $check = Redeem::where('code',$code)->where('offer_subscription_id',$subsc_id)->first();
        if($check != null){
            $code = $this->getNewRedeemCode($subsc_id);
            return $code;
        }
        return $code;
    }

    public function getNewRedeemCode($subsc_id){
        $code = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $check = Redeem::where('code',$code)->where('offer_subscription_id',$subsc_id)->first();
        if($check != null){
            $code = $this->getRedeemCode($subsc_id);
            return $code;
        }
        return $code;
    }

    // Set Tasks Count in DB befor Verify
    public function checkInstantTasksCount(Request $request){
        $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
        if($subscription == null){
            return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
        }else{
            $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
        }

        if($offer==NULL){
            return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();
        // if($userSocialConnection->is_facebook_auth==NULL || $userSocialConnection->facebook_page_id==NULL){
        //     return response()->json(['status'=> false,'message'=> 'Business not connected to Facebook Account!'], 200);
        // }

        $customer_id = $subscription->customer_id ?? 0;
        $socialCustomerCount = SocialCustomerCount::where('user_id', $offer->user_id)->where('customer_id', $customer_id)->first();
        if($socialCustomerCount == null){
            $socialCustomerCount = new SocialCustomerCount;
        }

        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($offer->user_id);
        $social_post_api_token = $userDetail->social_post_api_token;

        $channel = $type = $data_key = $media_id = "";
        $newCount = 0;
        $postCount = $postfields = [];

        $postfields['social_post_api_token'] = $social_post_api_token ?? NULL;

        $tasksCount=array();
        
        if($request->task_key == 'fb_page_url'){
            $url=$option->value."/api/facebook/getPageLikeCount";
            if(isset($userSocialConnection->facebook_page_id)){
                $postfields['fb_page_id'] = $userSocialConnection->facebook_page_id ?? 0;
            }
            $postCount = $this->_getPostCount($url, $postfields);
            $postCount = json_decode($postCount, true);

            if($postCount!=NULL){
                $newCount = $postCount['fan_count'] ?? 0;

                $channel = 'Facebook';
                $type = 'Page';
                $data_key = "likes";
                $media_id = $postCount['id'] ?? NULL;
                $socialCustomerCount->fb_page_url_count = $newCount;

                $tasksCount["fb_page_url_count"] = $newCount;
                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'fb_page_url_count', $newCount);
            }
        }
        else if($request->task_key == 'fb_comment_post_url' || $request->task_key == 'fb_like_post_url' || $request->task_key == 'fb_share_post_url'){
            $url=$option->value."/api/facebook/getPostLCSCount";
            $socialPostId = $offer->social_post__db_id ?? '';
            if(isset($socialPostId)){
                $postfields['post_id'] = $socialPostId;
            }
            $postCount = $this->_getPostCount($url, $postfields);
            $postCount = json_decode($postCount, true);

            if($postCount!=NULL){
                $socialCustomerCount->fb_comment_post_url_count = $postCount['comments']['summary']['total_count'] ?? 0;
                $socialCustomerCount->fb_like_post_url_count = $postCount['likes']['summary']['total_count'] ?? 0;
                $socialCustomerCount->fb_share_post_url_count = $postCount['shares']['summary']['total_count'] ?? 0;

                $tasksCount["fb_comment_post_url_count"] = $postCount['comments']['summary']['total_count'] ?? 0;
                $tasksCount["fb_like_post_url_count"] = $postCount['likes']['summary']['total_count'] ?? 0;
                $tasksCount["fb_share_post_url_count"] = $postCount['shares']['summary']['total_count'] ?? 0;

                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_comment_post_url_count', $postCount['comments']['summary']['total_count'] ?? 0);

                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_like_post_url_count', $postCount['likes']['summary']['total_count'] ?? 0);

                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'fb_share_post_url_count', $postCount['shares']['summary']['total_count'] ?? 0);
            }
            
            if($request->task_key == "fb_comment_post_url"){
                if($postCount!=NULL){
                    $newCount = $postCount['comments']['summary']['total_count'] ?? 0;

                    $channel = 'Facebook';
                    $type = "Post";
                    $data_key = "comments";
                    $media_id = $request->task_value ?? NULL;
                }
            }
            else if($request->task_key == "fb_like_post_url"){
                if($postCount!=NULL){
                    $newCount = $postCount['likes']['summary']['total_count'] ?? 0;

                    $channel = 'Facebook';
                    $type = "Post";
                    $data_key = "likes";
                    $media_id = $request->task_value ?? NULL;
                }
            }
            else if($request->task_key == "fb_share_post_url"){
                if($postCount!=NULL){
                    $newCount = $postCount['shares']['summary']['total_count'] ?? 0;

                    $channel = 'Facebook';
                    $type = "Post";
                    $data_key = "share";
                    $media_id = $request->task_value ?? NULL;
                }
            }
        }
        else if($request->task_key == 'insta_profile_url'){
            $url=$option->value."/api/instagram/getInstaFollowsFollowersCount";
            $instagram_user_id = $userSocialConnection->instagram_user_id ?? NULL;
            if(isset($instagram_user_id)){
                $postfields['instagram_user_id'] = $instagram_user_id;
            }
            $postCount = $this->_getPostCount($url, $postfields);

            $postCount = json_decode($postCount, true);

            if($postCount!=NULL){
                $newCount = $postCount['data']['followers_count'] ?? 0;

                $channel = 'Instagram';
                $type = 'Post';
                $data_key = "followers";
                $media_id = $instagram_user_id;
                $socialCustomerCount->insta_profile_url_count = $newCount;

                $tasksCount["insta_profile_url_count"] = $newCount;

                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'insta_profile_url_count', $newCount);
            }
        }
        else if($request->task_key == 'insta_post_url' || $request->task_key == 'insta_comment_post_url'){
            $url = $option->value."/api/instagram/getInstaPostDetails";
            $socialPostId = $offer->social_post__db_id ?? '';
            if(isset($socialPostId)){
                $postfields['post_id'] = $socialPostId;
            }
            $postCount = $this->_getPostCount($url, $postfields);
            $postCount = json_decode($postCount, true);

            if($postCount!=NULL){
                $socialCustomerCount->insta_like_post_url_count = $postCount['data']['like_count'] ?? 0;
                $socialCustomerCount->insta_comment_post_url_count = $postCount['data']['comments_count'] ?? 0;

                $tasksCount["insta_like_post_url_count"] = $postCount['data']['like_count'] ?? 0;
                $tasksCount["insta_comment_post_url_count"] = $postCount['data']['comments_count'] ?? 0;

                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_like_post_url_count', $postCount['data']['like_count'] ?? 0);

                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'insta_comment_post_url_count', $postCount['data']['comments_count'] ?? 0);
            }

            if($request->task_key == "insta_post_url"){
                if($postCount!=NULL){
                    $newCount = $postCount['data']['like_count'] ?? 0;

                    $channel = 'Instagram';
                    $type = "Post";
                    $data_key = "likes";
                    $media_id = $request->task_value ?? NULL;
                }
            }
            else if($request->task_key == "insta_comment_post_url"){
                if($postCount!=NULL){
                    $newCount = $postCount['data']['comments_count'] ?? 0;

                    $channel = 'Instagram';
                    $type = "Post";
                    $data_key = "comments";
                    $media_id = $request->task_value ?? NULL;
                }
            }
        }
        else if($request->task_key == 'tw_username' || $request->task_key == 'tw_tweet_url'){
            $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
            if($twitter_data != null){
                $twitter = json_decode($twitter_data->value);
            }else{
                return ['status'=> false,'message'=> 'Twitter credentials not found.'];
            }

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;

            if($request->task_key == 'tw_username'){
                $uriSegments = explode("/", parse_url($request->task_value, PHP_URL_PATH));
                $tweet_ID = array_pop($uriSegments);

                $prefix = '@';
                if (substr($tweet_ID, 0, strlen($prefix)) == $prefix) {
                    $tweet_ID = substr($tweet_ID, strlen($prefix));
                } 

                // Get Count by V1
                $url = 'https://api.twitter.com/1.1/users/show.json?screen_name='.$tweet_ID;
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount, true);
                
                if(isset($postCount['followers_count'])){
                    $newCount = $postCount['followers_count'] ?? 0;

                    $channel = 'Twitter';
                    $type = 'Profile';
                    $data_key = "followers";
                    $media_id = $tweet_ID ?? NULL;
                    $socialCustomerCount->tw_username_count = $newCount;

                    $tasksCount["tw_username_count"] = $newCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'tw_username_count', $newCount);
                }

                /* // Get Count by V2
                $checkTwitterUserUrl = 'https://api.twitter.com/2/users/by/username/'.$tweet_ID;
                $isBusinessUserTwitter = $this->_getRequestCount($checkTwitterUserUrl, $headers);
                $business_tw = json_decode($isBusinessUserTwitter);
                
                $tw_id = "";
                if(isset($business_tw->data)){
                    $tw_id = $business_tw->data->id;
                }else{
                    return ['status'=> false,'message'=> 'Twitter account with this username not found.'];
                }

                $url = 'https://api.twitter.com/2/users/'.$tw_id.'/followers?max_results=1000';
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount, true);

                if(isset($postCount['meta']['result_count'])){
                    $newCount = $postCount['meta']['result_count'];

                    $channel = 'Twitter';
                    $type = 'Profile';
                    $data_key = "followers";
                    $media_id = $tw_id ?? NULL;
                    $socialCustomerCount->tw_username_count = $newCount;

                    $tasksCount["tw_username_count"] = $newCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'tw_username_count', $newCount);
                }
                */
            }
            else if($request->task_key == 'tw_tweet_url'){
                $uriSegments = explode("/", parse_url($request->task_value, PHP_URL_PATH));
                $tweet_ID = array_pop($uriSegments);
                $url = 'https://api.twitter.com/2/tweets/'.$tweet_ID.'/liking_users';
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount, true);

                if(isset($postCount['meta']['result_count'])){
                    $newCount = $postCount['meta']['result_count'];

                    $channel = 'Twitter';
                    $type = 'Tweet';
                    $data_key = "likes";
                    $media_id = $tweet_ID ?? NULL;
                    $socialCustomerCount->tw_tweet_url_count = $newCount;

                    $tasksCount["tw_tweet_url_count"] = $newCount;

                    app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'tw_tweet_url_count', $newCount ?? 0);
                }
            }
        }
        else if($request->task_key == 'yt_channel_url' || $request->task_key == 'yt_like_url' || $request->task_key == 'yt_comment_url'){
            $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
            if($youtube_data != null){
                $youtube = json_decode($youtube_data->value);
            }else{
                return ['status'=> false,'message'=> 'Youtube credentials not found.'];
            }
            
            $headers = array();
            if($request->task_key == 'yt_channel_url'){
                $uriSegments = explode("/", parse_url($request->task_value, PHP_URL_PATH));
                $channel_ID = array_pop($uriSegments);

                $url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_ID.'&key='.$youtube->api_key;
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount);
                if(isset($postCount->items)){
                    foreach($postCount->items as $data){
                        if($channel_ID == $data->id){
                            if($data->statistics->subscriberCount!=NULL){
                                $newCount = $data->statistics->subscriberCount ?? 0;
                            }
                            $channel = 'Youtube';
                            $type = 'Channel';
                            $data_key = "subscribers";
                            $media_id = NULL;

                            $socialCustomerCount->yt_channel_url_count = $newCount;

                            $tasksCount["yt_channel_url_count"] = $newCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($offer->user_id, 'yt_channel_url_count', $newCount);
                        }
                    }
                }
            }
            else if($request->task_key == 'yt_like_url'){
                $parts = parse_url($request->task_value);
                parse_str($parts['query'], $query);
                $videoID = $query['v'];

                $url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key;
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount);

                if(isset($postCount->items)){
                    foreach($postCount->items as $data){
                        if($videoID == $data->id){
                            if($data->statistics->likeCount!=NULL){
                                $newCount = $data->statistics->likeCount ?? 0;
                            }
                            $channel = 'Youtube';
                            $type = 'Video';
                            $data_key = "likes";
                            $media_id = $videoID;

                            $socialCustomerCount->yt_like_url_count = $newCount;
                            $socialCustomerCount->yt_comment_url_count = $data->statistics->commentCount ?? 0;

                            $tasksCount["yt_like_url_count"] = $newCount;
                            $tasksCount["yt_comment_url_count"] = $data->statistics->commentCount ?? 0;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_like_url_count', $newCount ?? 0);

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_comment_url_count', $data->statistics->commentCount ?? 0);
                        }
                    }
                }
            }
            else if($request->task_key == 'yt_comment_url'){
                $parts = parse_url($request->task_value);
                parse_str($parts['query'], $query);
                $videoID = $query['v'];

                $url = 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key;
                $postCount = $this->_getRequestCount($url, $headers);
                $postCount = json_decode($postCount);

                if(isset($postCount->items)){
                    foreach($postCount->items as $data){
                        if($videoID == $data->id){
                            if($data->statistics->commentCount!=NULL){
                                $newCount = $data->statistics->commentCount ?? 0;
                            }
                            $channel = 'Youtube';
                            $type = 'Video';
                            $data_key = "comments";
                            $media_id = $videoID;

                            $socialCustomerCount->yt_like_url_count = $data->statistics->likeCount ?? 0;
                            $socialCustomerCount->yt_comment_url_count = $newCount;

                            $tasksCount["yt_like_url_count"] = $data->statistics->likeCount ?? 0;
                            $tasksCount["yt_comment_url_count"] = $newCount;

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_like_url_count', $data->statistics->likeCount ?? 0);

                            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer->id, $offer->user_id,'yt_comment_url_count', $newCount ?? 0);
                        }
                    }
                }
            }
        }
        // else if($request->task_key == 'google_review_link'){
        //     $url=$option->value."/api/google/getGoogleReviews";
        //     $media_id = $request->task_value ?? NULL;
        //     if(isset($media_id)){
        //         $postfields['place_id'] = $media_id;
        //     }
        //     $postCount = $this->_getPostCount($url, $postfields);
        //     $postCount = json_decode($postCount, true);
            
        //     if($postCount!=NULL){
        //         $newCount = $postCount['result']['user_ratings_total'] ?? 0;
        //     }

        //     $channel = 'Google';
        //     $type = 'Review';
        //     $data_key = "review_or_comment";
        //     $media_id = $media_id;
        //     $socialCustomerCount->google_review_link_count = $newCount;

        //     $tasksCount["google_review_link_count"] = $newCount;
        // }

        if($postCount!=NULL){
            $socialCustomerCount->user_id = $offer->user_id;
            $socialCustomerCount->customer_id = $customer_id;
            $socialCustomerCount->save();

            // save or update count
            $countData = SocialChannel::where('user_id', $offer->user_id)->where('channel', $channel)->where('type', $type)->where('data_key',$data_key)->where('media_id', $media_id)->orderBy('id','desc')->first();

            if($countData==NULL){
                $countData = new SocialChannel;
            }
            $countData->user_id = $offer->user_id;
            $countData->channel =  $channel;
            $countData->type = $type;
            $countData->data_key = $data_key;
            $countData->media_id = $media_id;
            $countData->instant_task_id = $request->instant_task_id;
            $countData->count = $newCount;
            $countData->save();
        }

        return response()->json(['status'=> true, 'message'=> 'set data successfully', 'tasksCount'=>$tasksCount], 200);
    }

    private function _getPostCount($url="", $postfields=[])
    {
        sleep(5);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$postfields['social_post_api_token']
            ),
        ));
        curl_close($curl);
        $response = curl_exec($curl);
        return $response;
    }

    private function _getRequestCount($url="", $headers=[]){
        //get user id from username
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /*
    private function _updateInstantTasks($share_cnf="", $instance_task_id=0)
    {
        $services_url=Option::where('key','services_url')->first();
        $url = $services_url->value."/update-task-status";
        $postfields=[
            'share_cnf'=> $share_cnf,
            'instance_task_id'=> $instance_task_id
        ];

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true
        ));
        curl_close($curl);
        $response = curl_exec($curl);
        dd($response);
        return $response;
    }
    */

  
    private function _addMessageHistory($user_id, $channel_id, $mobile, $content, $related_to, $sent_via, $status, $offer_id='NULL')
    {

        /* Customer ID */
        $customer_id = 0;
        $mobile_number = substr($mobile, 2);
        $customer = Customer::where('mobile', $mobile_number)->first();
        if($customer != null){
            $customer_id = $customer->id;
        }


        $message = new MessageHistory;
        $message->user_id = $user_id;
        $message->channel_id = $channel_id;
        $message->customer_id = $customer_id;
        $message->offer_id = $offer_id;
        $message->mobile = $mobile;
        $message->content = $content;
        $message->related_to = $related_to;
        $message->sent_via = $sent_via;
        $message->status = $status;
        $message->save();

        // $messageWallet = MessageWallet::where('user_id',$user_id)
        //                 ->orderBy('id','desc')->first();
        // // dd($user_id);
        // $messageWallet->total_messages = $messageWallet->total_messages - 1;
        // $messageWallet->save();

        return $message;
    }
 
    public function getRedeemCodeNew($subsc_id){
        $letter='';
        for($i=0;$i<=1;$i++){
                $letter .= chr(rand(65,90));
            }
        $Numcode = str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
        $code=$letter.$Numcode;
        $check = Redeem::where('code',$code)->where('offer_subscription_id',$subsc_id)->first();
        if($check != null){
            $code = $this->getNewRedeemCodeNew($subsc_id);
            return $code;
        }

        return $code;
    }

    public function getNewRedeemCodeNew($subsc_id){
        $letter='';
        for($i=0;$i<=1;$i++){
                $letter .= chr(rand(65,90));
            }
        $Numcode = str_pad(mt_rand(1,9999),4,'0',STR_PAD_LEFT);
        $code=$letter.$Numcode;
        $check = Redeem::where('code',$code)->where('offer_subscription_id',$subsc_id)->first();
        if($check != null){
            $code = $this->getRedeemCodeNew($subsc_id);
            return $code;
        }

        return $code;
    }

    // setTaskStatistics
    public function setTaskStatistics(Request $request){
        if(isset($request->share_cnf) && $request->share_cnf!=""){
            $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
            if($subscription == null){
                return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
            }else{
                $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
            }

            if($offer==NULL){
                return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
            }

            $instantTaskStatInfo = InstantTaskStat::where('user_id', $subscription->user_id)->where('offer_subscription_id', $subscription->id)->where('customer_id', $subscription->customer_id)->orderBy('id', "DESC")->first();
            
            if($instantTaskStatInfo==NULL){
                $instantTaskStatInfo = new InstantTaskStat;

                $instantTaskStatInfo->user_id = $subscription->user_id;
                $instantTaskStatInfo->offer_subscription_id = $subscription->id;
                $instantTaskStatInfo->customer_id = $subscription->customer_id;
                $instantTaskStatInfo->task_statistics = $request->taskStatus;
            }
            else{
                $dbStatus = json_decode($instantTaskStatInfo->task_statistics);
                $requestStatus = json_decode($request->taskStatus);
                
                if($request->status == "new"){
                    $updateStatus=[];
                    foreach ($dbStatus as $dKey => $status) {
                        $updateUniq = [];
                        foreach ($requestStatus as $rKey => $req) {
                            $new=[
                                'task_key'=> $req->task_key,
                                'instant_task_id'=> $req->instant_task_id,
                                'status'=> $req->status ?? "normal",
                            ];
                            $updateUniq[] = ($new);
                        }
                        $updateStatus = $updateUniq;
                    }

                    // dd("new 1", $updateStatus);
                }
                else{
                    // dd("setTaskStatistics", $dbStatus, $requestStatus);

                    $updateStatus=[];
                    foreach ($dbStatus as $dKey => $status) {
                        $updateUniq = [];
                        foreach ($requestStatus as $rKey => $req) {
                            if($req->task_key == $status->task_key){
                                $new=[
                                    'task_key'=> $req->task_key,
                                    'instant_task_id'=> $req->instant_task_id,
                                    'status'=> $req->status ?? "normal",
                                ];
                                $updateUniq[] = ($new);
                                // echo "<br/> new 2 <pre>"; print_r($updateUniq);
                            }
                            else{
                                $new=[
                                    'task_key'=> $req->task_key,
                                    'instant_task_id'=> $req->instant_task_id,
                                    'status'=> $req->status ?? "normal",
                                ];
                                $updateUniq[] = ($new);

                                // echo "<br/> update 2 <pre>"; print_r($updateUniq);
                            }

                            // echo "<br/> "; print_r($req);
                        }

                        $updateStatus = $updateUniq;
                    }

                    // dd("update 1", $updateStatus, $dbStatus, $requestStatus);
                }

                $instantTaskStatInfo->user_id = $subscription->user_id;
                $instantTaskStatInfo->offer_subscription_id = $subscription->id;
                $instantTaskStatInfo->customer_id = $subscription->customer_id;
                $instantTaskStatInfo->task_statistics = $updateStatus;
                // dd("12", $instantTaskStatInfo);
            }
            
            $instantTaskStatInfo->save();

            return response()->json(['status'=> true, 'message'=> 'data update successfully'], 200);
        }
        else{
            return response()->json(['status'=> false, 'message'=> 'empty share_cnf'], 200);
        }
    }

    public function getTaskStatistics(Request $request){

        if(isset($request->share_cnf) && $request->share_cnf!=""){
            $subscription = OfferSubscription::where('uuid',$request->share_cnf)->orderBy('id','desc')->first();
            if($subscription == null){
                return response()->json(['status'=> false,'message'=> 'Subscription not found.'], 200);
            }else{
                $offer = Offer::where('id',$subscription->offer_id)->orderBy('id','desc')->first();
            }

            if($offer==NULL){
                return response()->json(['status'=> false,'message'=> 'Offer not found!'], 200);
            }

            $cName = 'oc-'.$request->share_cnf.'-tasks';

            $instantTaskStatInfo = InstantTaskStat::where('user_id', $subscription->user_id)->where('offer_subscription_id', $subscription->id)->where('customer_id', $subscription->customer_id)->orderBy('id', "DESC")->first();
            if($instantTaskStatInfo==NULL){
                return false;
            }

            $task_statistics = json_decode($instantTaskStatInfo->task_statistics);
            $newCookies = [];
            
            foreach ($task_statistics as $key => $stats) {
                $checkIsComeplet = CompleteTask::where('offer_subscription_id', $subscription->id)->where('instant_task_id', $stats->instant_task_id)->first();

                if($checkIsComeplet==NULL){
                    $c['task_key'] = $stats->task_key;
                    $c['instant_task_id'] = $stats->instant_task_id;
                    $c['status'] = $stats->status;
                    $newCookies[]=$c;
                }
                else{
                    $c['task_key'] = $stats->task_key;
                    $c['instant_task_id'] = $stats->instant_task_id;
                    $c['status'] = "verified";
                    $newCookies[]=$c;
                }

                // print_r($stats); 
            }
            // dd($task_statistics, $newCookies);
            return response()->json(['status'=> false, 'message'=> 'DB Cookies', 'data'=>$newCookies], 200);
        }
        else{
            return response()->json(['status'=> false, 'message'=> 'DB Cookies not found.'], 200);
        }
    }
    
}
