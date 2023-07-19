<?php

namespace App\Http\Controllers\Business;

use DB;
use DOMDocument;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Offer;

use App\Models\Option;
use App\Models\Target;
use App\Models\Channel;
use App\Models\Customer;
use App\Models\EmailJob;
use App\Models\Deduction;
use App\Models\OfferReward;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;

use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\SocialPostCount;
use App\Models\WhatsappSession;
use App\Models\BusinessCustomer;
use App\Models\DeductionHistory;
use App\Models\SocialOfferCount;
use App\Models\UserNotification;
use App\Models\OfferSubscription;

use App\Models\SocialAccountCount;
use App\Models\SocialCustomerCount;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;
use Illuminate\Support\Facades\Auth;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\Business\CommonSettingController;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }
	
	public function dashboard()
    {
        /* Festival Changes */
        // $all_festival = DB::table('festivals')->where('status', 1)->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))->get();
    
        // $users = User::where('role_id', 2)->where('status', 1)->pluck('id')->toArray();
        
        // foreach($users as $user_id){
        //     $contactGroup = ContactGroup::where('user_id', $user_id)->pluck('id')->toArray();
        //     $groups_id = implode(',', $contactGroup);

        //     foreach ($all_festival as $festival) {
        //         $festivalTemp = MessageTemplateSchedule::where('user_id', $user_id)->where('message_template_category_id', $festival->message_template_category_id)->where('related_to', 'Festival')->first();
        //         if($festivalTemp == null){
        //             $festivalTemp = new MessageTemplateSchedule;
        //             $festivalTemp->user_id = $user_id;
        //             $festivalTemp->channel_id = 5;
        //             $festivalTemp->template_id = $festival->template_id;
        //             $festivalTemp->message_type_id = $festival->message_type_id;
        //             $festivalTemp->time_slot_id = $festival->time_slot_id;
        //             $festivalTemp->related_to = 'Festival';
        //             $festivalTemp->groups_id = $groups_id;
        //             $festivalTemp->scheduled = $festival->festival_date;
        //             $festivalTemp->message_template_category_id = $festival->message_template_category_id;
        //             $festivalTemp->save();
        //         }
        //     }
        // }
                
        /* Remove * from email content */
        // $emails = EmailJob::where('email_id', 7)->where('message', 'like', '%' . '*' . '%')->get();
        // if(!empty($emails)){
        //     foreach($emails as $email){
                
        //         $new_content = str_replace("*","",$email->message);
                
        //         $emailJob = EmailJob::find($email->id);
        //         $emailJob->message = $new_content;
        //         $emailJob->save();
                
        //     }
        // }

        /* Customer id 0 issue fixed */
        // $deductionHistories = DeductionHistory::where('customer_id', 0)->where('employee_id', 0)->get();
		// if(!empty($deductionHistories)){
		// 	foreach($deductionHistories as $dHistory){
		// 		$msgHistory = MessageHistory::find($dHistory->message_history_id);
		// 		if($msgHistory != null){
		// 			$mobile_no = substr($msgHistory->mobile, 2);

		// 			$customer = Customer::where('mobile', $mobile_no)->first();
					
		// 			if($customer != null){
		// 				$dHistoryData = DeductionHistory::find($dHistory->id);
		// 				$dHistoryData->customer_id = $customer->id;
		// 				$dHistoryData->save();
		// 			}
		// 		}
		// 	}
		// }


        /* Add Notification Entry */
        // $notifications = Notification::where('status', 1)->get();
		// foreach ($notifications as $notification) {
		// 	$users = User::where('status', 1)->get();

		// 	foreach($users as $user){
		// 		$user_notification = UserNotification::where('user_id', $user->id)->where('notification_id', $notification->id)->first();
		// 		if($user_notification == null){
		// 			$user_notification = new UserNotification;
		// 		}
				
		// 		$user_notification->notification_id = $notification->id;
		// 		$user_notification->user_id = $user->id;
		// 		$user_notification->save();
		// 	}
		// }


        /* Update Social Offer Count For Old Offers */
        // $offers = Offer::all();

        // foreach($offers as $offer){
        //     $social_offer_count = SocialOfferCount::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->first();
            
        //     if($social_offer_count == null){
        //         $social_offer_count = new SocialOfferCount;
        //         $social_offer_count->offer_id = $offer->id;
        //         $social_offer_count->user_id = $offer->user_id;
        //         $social_offer_count->fb_comment_post_url_count = 0;
        //         $social_offer_count->fb_like_post_url_count = 0;
        //         $social_offer_count->fb_share_post_url_count = 0;
        //         $social_offer_count->insta_like_post_url_count = 0;
        //         $social_offer_count->insta_comment_post_url_count = 0;
        //         $social_offer_count->tw_tweet_url_count = 0;
        //         $social_offer_count->yt_like_url_count = 0;
        //         $social_offer_count->yt_comment_url_count = 0;
        //         $social_offer_count->save();
        //     }
        // }


        /* Remove Customer Name */
        $emails = EmailJob::where('message', 'like', '%' . '{customer_name}' . '%')->get();

        if(!empty($emails)){
            foreach($emails as $email){

                $user = User::where('email', $email->email)->first();
                
                if($user != null){
                    $text = $user->name;
                }else{
                    $text = 'Customer';
                }
                
                $new_content = str_replace("{customer_name}", $text, $email->message);
                
                $emailJob = EmailJob::find($email->id);
                $emailJob->message = $new_content;
                $emailJob->save();
                
            }
        }


        /* Share New Offer Default groups */

        // $userIds = User::where('role_id', 2)->where('status', 1)->pluck('id')->toArray();
        // if(!empty($userIds)){
        //     foreach($userIds as $user_id){
        //         $contactGroups = ContactGroup::where('user_id', $user_id)->where('is_default', 1)->pluck('id')->toArray();

        //         if(!empty($contactGroups)){
        //             $groups_ids = implode(',', $contactGroups);
        //             $businessDetails = BusinessDetail::where('user_id', $user_id)->first();

        //             if($businessDetails != null && $businessDetails->selected_groups == ''){
        //                 $businessDetails->selected_groups = $groups_ids;
        //                 $businessDetails->save();
        //             }
        //         }
        //     }
        // }

        
        $userIdList = [];
        $userIds = User::where('role_id', 2)->pluck('id')->toArray();
        if(!empty($userIds)){
            foreach($userIds as $user_id){




                // $channels = Channel::all();
                // foreach($channels as $channel){
                //     $userChannel = UserChannel::where('user_id', $user_id)->first();
                //     if($userChannel == null){
                //         $userChannel = new UserChannel;
                //         $userChannel->user_id = $user_id;
                //         $userChannel->channel_id = $channel->id;
                        
                //         if($channel->id == 4){
                //             $userChannel->status = 0;
                //         }

                //         $userChannel->save();
                //     } 
                // }


                /* Update Social Account Counts */

                // $socialAccountCount = SocialAccountCount::where('user_id', $user_id)->first();
                // if($socialAccountCount == null){
                //     $socialAccountCount = new SocialAccountCount;
                //     $socialAccountCount->user_id = $user_id;
                //     $socialAccountCount->fb_page_url_count = 0;
                //     $socialAccountCount->insta_profile_url_count = 0;
                //     $socialAccountCount->tw_username_count = 0;
                //     $socialAccountCount->li_company_url_count = 0;
                //     $socialAccountCount->yt_channel_url_count = 0;
                //     $socialAccountCount->google_review_link_count = 0;
                //     $socialAccountCount->save();
                // }


                /* Update Customer ID in message history */

                // $messages = MessageHistory::where('user_id', $user_id)->where('customer_id', 0)->get();
                
                // if(!empty($messages)){
                //     foreach($messages as $message){

                //         if(strlen($message->mobile) == 12){
                //             $mobile = substr($message->mobile, 2);
                //         }else if(strlen($message->mobile) == 10) {
                //             $mobile = $message->mobile;
                //         }else{
                //             $mobile = '';
                //         }
                
                //         $customer = Customer::where('mobile', $mobile)->first();

                //         if($customer != null){
                //             $message->customer_id = $customer->id;
                //             $message->save();
                //         }else{
                //             if($mobile != '') {
                //                 $mobile = $message->mobile;

                //                 $new_customer= new Customer;
                //                 $new_customer->mobile = $mobile;
                //                 $new_customer->user_id = $message->user_id;
                //                 $new_customer->created_by = $message->user_id;
                //                 $new_customer->save();

                //                 $new_customer->uuid = $new_customer->id.'CUST'.date("Ymd");
                //                 $new_customer->save();

                //                 $message->customer_id = $new_customer->id;
                //                 $message->save();
                //             }
                //         }

                //     }
                // }


                /* Customer missing in Contact Groups */

                $bCustomers = BusinessCustomer::where('user_id', $user_id)->pluck('customer_id')->toArray();

                if(!empty($bCustomers)){
                    foreach($bCustomers as $bCustomer){
                        $gCustomer = GroupCustomer::where('user_id', $user_id)->where('customer_id', $bCustomer)->first();

                        if($gCustomer == null){
                            $contactGroup = ContactGroup::where('user_id', $user_id)->where('channel_id', 2)->first();

                            if($contactGroup != null){
                                $gCustomer = new GroupCustomer;
                                $gCustomer->user_id = $user_id;
                                $gCustomer->contact_group_id = $contactGroup->id;
                                $gCustomer->customer_id = $bCustomer;
                                $gCustomer->save();
                            }
                        }
                    }
                }

                /* Update Message Limit */

                // $message_wallets = MessageWallet::where('messaging_api_daily_limit', 0)->orWhere('messaging_api_daily_free_limit', 0)->get();
                // if(!empty($message_wallets)){
                //     $free_whatsapp_limit = Option::where('key', 'free_whatsapp_limit')->first();
                //     $messaging_api_limit = Option::where('key', 'messaging_api_limit')->first();

                //     foreach($message_wallets as $message_wallet){
                //         $message_wallet = MessageWallet::find($message_wallet->id);
                //         $message_wallet->messaging_api_daily_limit = $messaging_api_limit;
                //         $message_wallet->messaging_api_daily_free_limit = $free_whatsapp_limit;
                //         $message_wallet->save();
                //     }
                // }


                /* Messaging API */

                // $deductionHistories = DeductionHistory::where('channel_id', 4)->where('deduction_amount', '10.00')->get();
                // if(!empty($deductionHistories)){
                //     foreach($deductionHistories as $deductionHistory){
                //         $mWallet = MessageWallet::where('user_id', $deductionHistory->user_id)->first();
                //         $mWallet->wallet_balance = $mWallet->wallet_balance + 10;
                //         $mWallet->save();


                //         DeductionHistory::destroy($deductionHistory->id);
                //     }
                // }
                
                // dd($deductionHistories);


                /* Update Business Owner in Message History */

                // $mHistories = MessageHistory::where('content', 'like', '%business owner%')->get();
                // if(!empty($mHistories)){
                //     foreach($mHistories as $mHistory){
                //         $businessDetail = BusinessDetail::where('user_id', $mHistory->user_id)->first();

                //         if($businessDetail != null){
                //             $new_content = str_replace("business owner",$businessDetail->busniess_name,$mHistory->content);

                //             $mHistory = MessageHistory::find($mHistory->id);
                //             $mHistory->content = $new_content;
                //             $mHistory->save();
                //         }
                //     }
                // }

                /* Remove from Group Customers if does not exist in Business Customer */

                // $gCustomers = GroupCustomer::where('user_id', $user_id)->get();

                // if(!empty($gCustomers)){
                //     foreach($gCustomers as $gCustomer){
                //         $bCustomer = BusinessCustomer::where('user_id', $user_id)->where('customer_id', $gCustomer->customer_id)->first();

                //         $cust = Customer::find($gCustomer->customer_id);

                //         if($bCustomer == null || $cust == null){
                //             GroupCustomer::destroy($gCustomer->id);
                //         }
                        
                //     }
                // }

                // dd($gCustomers);

            }
        }
        

        

        /* Remove History for Deleted User */
        
        // $mHistories = MessageHistory::with('business')->where('customer_id', 0)->get();
        // if(!empty($mHistories)){
        //     foreach($mHistories as $mHistory){
        //         if($mHistory->business == null){
        //             MessageHistory::destroy($mHistory->id);
        //         }
        //     }
        // }

        /* Update Customer Info For All */
        // $bCustomers = BusinessCustomer::pluck('customer_id')->toArray();
        // if(!empty($bCustomers)){
        //     foreach($bCustomers as $bCustomer){
        //         $customers = BusinessCustomer::where('customer_id', $bCustomer)->get();

        //         $customerDetails = [
        //             'name' => '',
        //             'dob' => '',
        //             'anniversary_date' => ''
        //         ];
        //         if(!empty($customers)){
        //             foreach($customers as $customer){
        //                 if($customer->name != ''){
        //                     $customerDetails['name'] = $customer->name;
        //                 }

        //                 if($customer->dob != ''){
        //                     $customerDetails['dob'] = $customer->dob;
        //                 }

        //                 if($customer->anniversary_date != ''){
        //                     $customerDetails['anniversary_date'] = $customer->anniversary_date;
        //                 }
        //             }

        //             $bCustomer = BusinessCustomer::where('customer_id', $bCustomer)->update(['name' => $customerDetails['name'], 'dob' => $customerDetails['dob'], 'anniversary_date' => $customerDetails['anniversary_date']]);
                    
        //         }
        //         // dd($customerDetails);
        //     }
        // }
        
        
        /* Update UUID for customers */
        $customers = Customer::whereNull('uuid')->pluck('id')->toArray();
        if(!empty($customers)){

            foreach($customers as $customer){
                $customer = Customer::find($customer);
                $customer->uuid = $customer->id.'CUST'.date("Ymd");
                $customer->save();
            }
        }



        /* END UPDATE DATA FOR ALL */












        /* Current Offer data */
        $today = date("Y-m-d");
        // $offer = Offer::with('offer_template')->has('offer_template')->where('user_id',Auth::id())->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();

        $offer = Offer::where('user_id', Auth::id())
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

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        // Social Media Reach Bar Graph Count
        $social_customer = SocialCustomerCount::where('user_id', Auth::id())->first();
        $users = User::where('id', Auth::id())->first();
        // dd($users->current_account_status == 'free');

        $fb_page_url_count = 0;
        $insta_profile_url_count = 0;
        $tw_username_count = 0;
        $yt_channel_url_count = 0;
        $google_review_link_count = 0;


        $social_customer = SocialAccountCount::where('user_id', Auth::id())->first();
  
        if($social_customer != null){
            $fb_page_url_count = $social_customer->fb_page_url_count ?? 0;
            $insta_profile_url_count = $social_customer->insta_profile_url_count ?? 0;
            $tw_username_count = $social_customer->tw_username_count ?? 0;
            $yt_channel_url_count = $social_customer->yt_channel_url_count ?? 0;
            $google_review_link_count = $social_customer->google_review_link_count ?? 0;
        }

        if($offer != ''){

           // Social Media Impact Of Current Offer count
           $fb_comment_post_url_count = 0;
           $fb_like_post_url_count = 0;
           $insta_like_post_url_count = 0;
           $insta_comment_post_url_count = 0;
           $tw_tweet_url_count = 0;
           $yt_like_url_count = 0;
           $yt_comment_url_count = 0;

            $social_o_count  = SocialOfferCount::where('user_id', Auth::id())->where('offer_id', $offer->id)->first();
            if($social_o_count != null){

            $fb_comment_post_url_count = $social_o_count->fb_comment_post_url_count;
            $fb_like_post_url_count = $social_o_count->fb_like_post_url_count;
            $insta_like_post_url_count = $social_o_count->insta_like_post_url_count;
            $insta_comment_post_url_count = $social_o_count->insta_comment_post_url_count;
            $tw_tweet_url_count = $social_o_count->tw_tweet_url_count;
            $yt_like_url_count = $social_o_count->yt_like_url_count;
            $yt_comment_url_count = $social_o_count->yt_comment_url_count;
            }

            
            if($users->current_account_status == 'free'){
                $current_unique_clicks = 0;
            }
            else{
            $current_unique_clicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('targets.repeated', 0)
            ->count();
            }
            
          
            $current_total_clicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            // ->where('targets.repeated', 1)
            ->count();


            $current_instant_subscribers = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('offer_subscriptions.channel_id', 2)
            ->distinct()->count('offer_subscriptions.customer_id');

            $current_share_subscribers = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('offer_subscriptions.channel_id', 3)
            ->distinct()->count('offer_subscriptions.customer_id');

            $clicks = $this->currentLast7days($offer);
            $current_clicks = $this->currentOffer7days($offer);
            $total_subscriber = $this->total_subscriber7days($offer);

            $currentOfferDates = $clicks['labels'];
            $currentOfferUniqueClicks = $clicks['uniquedata'];
            $currentOfferTotalClicks = $clicks['totaldata'];

            $current7DaysOfferDates = $current_clicks['labels'];
            $current7DaysOfferUniqueClicks = $current_clicks['uniquedata'];
            $current7DaysOfferTotalClicks = $current_clicks['totaldata'];

            $totalsubscriber7DaysDates = $total_subscriber['labels'];
            $totalsubscriber7DaysInstantChallanges = $total_subscriber['uniquedata'];
            $totalsubscriber7DaysShareChallanges = $total_subscriber['totaldata'];

            
        }else{

            if($planData['current_offer'] != '' && $planData['current_offer']->start_date <= Carbon::now()->format('Y-m-d')){

                $clicks = $this->currentLast7days($planData['current_offer']);
                $current_clicks = $this->currentOffer7days($planData['current_offer']);

                $currentOfferDates = $clicks['labels'];
                $currentOfferUniqueClicks = $clicks['uniquedata'];
                $currentOfferTotalClicks = $clicks['totaldata'];

                $current7DaysOfferDates = $current_clicks['labels'];
                $current7DaysOfferUniqueClicks = $current_clicks['uniquedata'];
                $current7DaysOfferTotalClicks = $current_clicks['totaldata'];

                $totalsubscriber7DaysDates = $total_subscriber['labels'];
                $totalsubscriber7DaysInstantChallanges = $total_subscriber['uniquedata'];
                $totalsubscriber7DaysShareChallanges = $total_subscriber['totaldata'];

            }else{  
                $currentOfferDates = $currentOfferUniqueClicks = $currentOfferTotalClicks = $current7DaysOfferDates = $current7DaysOfferUniqueClicks = $current7DaysOfferTotalClicks = $totalsubscriber7DaysDates = $totalsubscriber7DaysInstantChallanges = $totalsubscriber7DaysShareChallanges = array();
            }
            
            $current_unique_clicks = $current_total_clicks = $current_instant_subscribers = $current_share_subscribers  =  $fb_comment_post_url_count = $fb_like_post_url_count = $insta_like_post_url_count = $insta_comment_post_url_count = $tw_tweet_url_count = $yt_like_url_count = $yt_comment_url_count = 0;
            
        }

        /* Message data */
        $message_wallet = MessageWallet::where('user_id', Auth::id())->first();
        if($message_wallet != null){
            $remaing_message_count = $message_wallet->wallet_balance;

            $totalMessageSent = DeductionHistory::where('user_id', Auth::id())->sum('deduction_amount');
            $deductionsTitles = Deduction::where('status', 1)->orderBy('id', "ASC")->pluck('name')->toArray();
            $deductionsCounts = Deduction::addSelect(['deductHistory' => DeductionHistory::selectRaw('sum(deduction_amount) as total')
                                        ->whereColumn('deduction_id', 'deductions.id')->where('deduction_histories.user_id', Auth::id())
                                    ])
                                    ->where('status', 1)->orderBy('id', "ASC")->pluck('deductHistory')->toArray();
    
            foreach ($deductionsCounts as $key => $count) {
                $count = number_format($count, 2);
                $channelMessages[] = (float) $count;
            }

        }else{
            $remaing_message_count = $totalMessageSent = 0;
            $channelMessages = $deductionsTitles = $deductionsCounts = array();
        }

        /* Social Post Count */
        $fb_post_unique_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'facebook')->where('is_repeated', '0')->count();
        
        $fb_post_extra_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'facebook')->where('is_repeated', '1')->count();

        $tw_post_unique_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'twitter')->where('is_repeated', '0')->count();

        $tw_post_extra_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'twitter')->where('is_repeated', '1')->count();
        
        $li_post_unique_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'linkedin')->where('is_repeated', '0')->count();
        $li_post_extra_click = SocialPostCount::where('user_id', Auth::id())->where('media', 'linkedin')->where('is_repeated', '1')->count();

        $fb_total = ($fb_post_unique_click + $fb_post_extra_click);
        $tw_total = ($tw_post_unique_click + $tw_post_extra_click);
        $li_total = ($li_post_unique_click + $li_post_extra_click);

        $social_percent_data = array();
        $social_percent_data['fb_unique_percent'] = ($fb_total > 0) ? (($fb_post_unique_click / $fb_total) * 100).'%' : 0;
        $social_percent_data['fb_extra_percent'] = ($fb_total > 0) ? (($fb_total / $fb_total) * 100).'%' : 0;

        $social_percent_data['tw_unique_percent'] = ($tw_total > 0) ? (($tw_post_unique_click / $tw_total) * 100).'%' : 0;
        $social_percent_data['tw_extra_percent'] = ($tw_total > 0) ? (($tw_total / $tw_total) * 100).'%' : 0;

        $social_percent_data['li_unique_percent'] = ($li_total > 0) ? (($li_post_unique_click / $li_total) * 100).'%' : 0;
        $social_percent_data['li_extra_percent'] = ($li_total > 0) ? (($li_post_extra_click / $li_total) * 100).'%' : 0;

        // $socialChartData = [$fb_total, $tw_total, $li_total];
        $socialChartData = [$fb_total, $tw_total];

        /* Total Click Chart Data */
        $chartData = $this->last7days();
        $clickChartDates = $chartData['labels'];
        $chartUniqueClicks = $chartData['data'][0];
        $chartTotalClicks = $chartData['data'][1];        
        // Update Social Connections
        app('App\Http\Controllers\Business\SocialConnectController')->updateUserConnections();

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first(); 
        $isConnectAnySocialMedia = 1;
        if($userSocialConnection!=NULL){
            if(
                ($userSocialConnection->is_facebook_auth ==0 || $userSocialConnection->is_facebook_auth == NULL) && 

                ($userSocialConnection->is_twitter_auth ==0) && 

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
        // dd($socialChartData);
        return view('business.dashboard', compact('notification_list', 'planData', 'current_unique_clicks', 'current_total_clicks', 'current_share_subscribers', 'current_instant_subscribers', 'currentOfferDates', 'currentOfferUniqueClicks','currentOfferTotalClicks','current7DaysOfferDates','current7DaysOfferUniqueClicks',
        'current7DaysOfferTotalClicks','totalsubscriber7DaysDates','totalsubscriber7DaysInstantChallanges',
        'totalsubscriber7DaysShareChallanges','remaing_message_count','channelMessages', 'totalMessageSent', 'fb_post_unique_click', 'fb_post_extra_click', 'tw_post_unique_click', 'tw_post_extra_click', 'li_post_unique_click', 'li_post_extra_click', 'socialChartData', 'clickChartDates', 'chartUniqueClicks', 'chartTotalClicks','social_percent_data','offer', 'isConnectAnySocialMedia', 'deductionsTitles', 'deductionsCounts','fb_page_url_count',   'insta_profile_url_count','tw_username_count','yt_channel_url_count','google_review_link_count','fb_comment_post_url_count','fb_like_post_url_count','insta_like_post_url_count','insta_comment_post_url_count', 'tw_tweet_url_count', 'yt_like_url_count','yt_comment_url_count','fb_total'));
    }


/* Current offer statistics last 7 days on page load start */
    public function currentLast7days($offer)
    {
         $users = User::where('id', Auth::id())->first();
        $labels = $this->getSevenDaysLb();
        if($users->current_account_status== 'free'){
            $uniquedata = 0;
        }else{
            $uniquedata = $this->getCurrent7DayUniqueRecords($offer);
        }
        $totaldata = $this->getCurrent7DayTotalRecords($offer);

        return [
                'labels'=>$labels,
                'uniquedata'=>$uniquedata,
                'totaldata'=>$totaldata
            ];
    }


    public function getCurrent7DayUniqueRecords($offer)
    {
        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            // $updatedClicks = $updatedClicks + $dailyDatas;
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }


    public function getCurrent7DayTotalRecords($offer)
    {
        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }
    /* Current offer statistics last 7 days on page load end */



    /* Static Graph 7 days data on page load start */
    public function last7days()
    {
    // yaha

        $user = Auth::user();
        $labels = $this->getSevenDaysLb();
      
        $data = $this->get7DayRecords();
        
        if($user->current_account_status == 'free'){
            $data[0] = 0;
        }
        return [
                'labels'=>$labels,
                'data'=>$data
            ];
    }

    public function getSevenDaysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }

    public function get7DayRecords(){

        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */
        $uniqueClicks = array(); 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            
  
            $dailyClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            ->where('targets.repeated', 0)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count(); 
            if(!empty($uniqueClicks)){
                $lastCountInstant = end($uniqueClicks);
            }else{
                $lastCountInstant = 0;
            }
            $uniqueClicks[] = $lastCountInstant + $dailyClicks;
        }
        $datas[] = $uniqueClicks;
     
        /* Extra Clicks */
        $extraClicks = array(); 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $DailyExtraClicks = Target::leftjoin('offer_subscriptions', 'targets.offer_subscription_id', '=', 'offer_subscriptions.id')
            ->leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->leftjoin('users', 'offers.user_id', '=', 'users.id')
            ->where('offers.user_id', $user->id)
            // ->where('targets.repeated', 1)
            ->where('targets.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->count();
            if(!empty($extraClicks)){
                $lastCountInstant = end($extraClicks);
            }else{
                $lastCountInstant = 0;
            }
            $extraClicks[] = $lastCountInstant + $DailyExtraClicks;
        }
        $datas[] = $extraClicks;

        return $datas;
    }
    /* Static Graph 7 days data on page load end */

   
    public function currentOffer7days($offer)
    {
        $labels = $this->getOfferSevenDaysLb();
        $uniquedata = $this->getOfferCurrent7DayUniqueRecords($offer);
        $totaldata = $this->getOfferCurrent7DayTotalRecords($offer);
        
        return [
                'labels'=>$labels,
                'uniquedata'=>$uniquedata,
                'totaldata'=>$totaldata
            ];
    }
    

    public function getOfferSevenDaysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }


    public function getOfferCurrent7DayUniqueRecords($offer){

        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }


    public function getOfferCurrent7DayTotalRecords($offer)
    {
        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Unique clicks */ 
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyDatas = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.offer_id', $offer->id)
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            $uniqueClicks[] = $dailyDatas;
        }

        return $datas = $uniqueClicks;
    }

    /* total Subscriber start */

    public function total_subscriber7days($offer)
    {
    
        $labels = $this->get_total_subscriber7daysLb();
        $uniquedata = $this->get_total_subscriber7daysInstantChallanges($offer);
        $totaldata = $this->get_total_subscriber7daysShareChallanges($offer);
        
        return [
                'labels'=>$labels,
                'uniquedata'=>$uniquedata,
                'totaldata'=>$totaldata
            ];
    }


    /* Instant & share Challengers last 7 days on page load start */

    public function get_total_subscriber7daysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }


    public function get_total_subscriber7daysInstantChallanges($offer){

        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Instant Challanges */ 
        foreach ($labels as $day) {
            $dailyDatas = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 2)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id');
            if(!empty($instantChallanges)){
                $lastCountInstant = end($instantChallanges);
            }else{
                $lastCountInstant = 0;
            }
            $instantChallanges[] = $lastCountInstant + $dailyDatas;
        }

        return $datas = $instantChallanges;
    }
    public function get_total_subscriber7daysShareChallanges($offer){

        $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

        /* Share Challanges */ 
        foreach ($labels as $day) {
            $dailyDatas = OfferSubscription::leftjoin('offers', 'offer_subscriptions.offer_id', '=', 'offers.id')
            ->where('offer_subscriptions.user_id', Auth::id())
            ->where('offer_subscriptions.channel_id', 3)
            ->where('offer_subscriptions.created_at', 'LIKE', Carbon::parse($day)->format("Y-m-d").'%')
            ->distinct()->count('offer_subscriptions.customer_id'); 
            
            if(!empty($ShareChallanges)){
                $lastCountInstant = end($ShareChallanges);
            }else{
                $lastCountInstant = 0;
            }
            $ShareChallanges[] = $lastCountInstant + $dailyDatas;
        }

        return $datas = $ShareChallanges;
    }
    /* Instant & share Challengers last 7 days on dashboard load end */

}
