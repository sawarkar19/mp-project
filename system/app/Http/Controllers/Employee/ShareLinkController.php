<?php

namespace App\Http\Controllers\Employee;

use URL;
use Auth;
use Carbon\Carbon;
// use DeductionHelper;
use App\Helper\Deductions\DeductionHelper;
use App\Models\Offer;
use App\Models\Option;

use App\Models\Redeem;

use App\Models\Target;
use App\Models\Customer;
use App\Models\Userplan;
use App\Models\InstantTask;
use App\Models\OfferReward;
use App\Models\CompleteTask;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\RedeemDetail;
use Illuminate\Http\Request;

use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;

use App\Http\Controllers\Controller;
use App\Models\OfferSubscriptionReward;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\Business\CommonSettingController;

class ShareLinkController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('employee');
    }
	
	public function index()
    {
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getEmployeePlanDetails(Auth::user()->created_by);

        /* Settings */
        $ask_for_invoice=Option::where('key','ask_for_invoice')->first();     
        $invoice_required=Option::where('key','invoice_required')->first();
        $ask_for_name=Option::where('key','ask_for_name')->first();
        $ask_for_dob=Option::where('key','ask_for_dob')->first();
        $ask_for_anniversary_date=Option::where('key','ask_for_anniversary_date')->first();
        $name_required=Option::where('key','name_required')->first();
        $dob_required=Option::where('key','dob_required')->first();
        $anniversary_date_required=Option::where('key','anniversary_date_required')->first();

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::user()->created_by);

        // dd($userBalance);

        return view('employee.share-links.index', compact('notification_list','planData', 'ask_for_invoice', 'invoice_required', 'ask_for_name', 'ask_for_dob', 'ask_for_anniversary_date', 'name_required', 'dob_required', 'anniversary_date_required','userBalance'));
    }

    public function isTaskAvailable($customer_id, $user_id, $settings)
    {

        $offerSubscriptionIds = OfferSubscription::where('customer_id', $customer_id)->where('user_id', $user_id)->pluck('id')->toArray();
        
        $total_task_ids = InstantTask::with('activeTask')->has('activeTask')->where('user_id', $user_id)->whereNull('deleted_at')->orderBy('id','desc')->pluck('id')->toArray();

        $completedTasks = CompleteTask::where('customer_id', $customer_id)->whereIn('offer_subscription_id', $offerSubscriptionIds)->pluck('instant_task_id')->toArray();

        if(!empty($completedTasks)){
            $notCompletedTasks = count(array_diff($total_task_ids, $completedTasks));
        }else{
            $notCompletedTasks = count($total_task_ids);
        }

        $rewardData = json_decode($settings->details, true);
        $req_task = (int)$rewardData['minimum_task'];

        if($notCompletedTasks < $req_task){
            return false;
        }else{
            return true;
        }
    }

    public function shareOffer(Request $request){
        $this->validate($request, [
            'name' => 'nullable|min:3|max:50',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
        ]);
        
        //save customer
        $customer = $this->customer($request);

        /* Customer Subscribing for the first time */
        $subCount = OfferSubscription::where('user_id', Auth::user()->created_by)->where('customer_id', $customer->id)->count();
        if($subCount == 0){
            $firstTime = true;
        }else{
            $firstTime = false;
        }

        //check for current offer
        $today = date("Y-m-d");
        $offer = Offer::where('user_id',Auth::user()->created_by)->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();
        if($offer == null){
            return response()->json(["status" => false, "message" => "Currently you don't have any Offer running."]);
        }

        // Check AutoPost Offer Available or not
        $isAutoPostOffer = 1;
        $autoInstantTask = InstantTask::where('offer_id', $offer->id)->whereNull('deleted_at')->first();
        if($autoInstantTask==NULL){
            return response()->json(["status" => false, "message" => "You have not posted your current offer to social media."]);
        }

        //get reward settings
        $settings = OfferReward::where('user_id',Auth::user()->created_by)->where('channel_id',2)->first();
        if($settings == null){
            return response()->json(["status" => false, "message" => "Please first update reward setting for Instant and Rewards."]);
        }

        $instantTasks = InstantTask::with('task')->where('user_id',$offer->user_id)->whereNotNull('task_id')->whereNull('deleted_at')->orderBy('task_id','ASC')->get();

        $subscription = OfferSubscription::where('channel_id',2)->where('user_id', Auth::user()->created_by)->where('offer_id', $offer->id)->where('customer_id', $customer->id)->where("status", '1')->first();
        
        if($subscription != null){
            return response()->json(["status" => false, "message" => "Mobile number is already subscribed."]);
        }

        $hasTasks = $this->isTaskAvailable($customer->id, $offer->user_id, $settings);
        if($hasTasks == false){
            return response()->json(["status" => false, "message" => "Required task to avail offer is more than task created."]);
        }

        // Check Wallet using Route
        $route = MessageRoute::where('user_id', Auth::user()->created_by)->where('channel_id', 2)->first();
        if($route->sms == 1){
            $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($offer->user_id, 2, ['send_sms']);
            if($checkWalletBalance['status'] != true){
                return response()->json(["status" => $checkWalletBalance['status'], "message" => $checkWalletBalance['message']]);
            }
        }
        

        /* Share Link */
        $type = 'instant';
        $randomString = UuidTokenController::eightCharacterUniqueToken(8);
        $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
        $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
        
        if($tokenData['status'] == true){
            $tokenData = UuidTokenController::findUniqueToken($type, $addedCharacter);
        }
        $link = '/i/'.$offer->uuid.'?share_cnf='.$tokenData['token'];

        $long_link = URL::to('/').$link;
        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $offer->user_id ?? 0, "instant_challenge");

        if($shortLinkData->original["success"] == false){
            return response()->json(["status" => false, "message" => "Shortlink not created."]);
        }

        /* Share link */
        $share_link = "https://opnl.in/".$shortLinkData->original["code"];
        
        // $message = MessageTemplateController::shareOfferLinkTemplate($share_link);
        // $message = "This is your instant reward link. Click here ".$share_link;
        $business_details = BusinessDetail::where('user_id', Auth::user()->created_by)->first();


        /* First Time */
        $user_id = Auth::user()->created_by;
        $channel_id = 2;
        $mobile = "91".$request->mobile;

        $business_details = BusinessDetail::where('user_id', $user_id)->first();
        $biz_name = $business_details->business_name ?? 'business owner';

        if(strlen($biz_name) > 28){
            $biz_name = substr($biz_name,0,28).'..';
        }


        if($firstTime == true){
            $message = "Welcome to ".$business_details->business_name."\nYou're eligible to get an offer today\nThanks for shopping with us.\nOPNLNK";

            $params = [
                "mobile" => "91".$request->mobile,
                "message" => $message,
                "channel_id" => 2,
                'whatsapp_msg' => $message,
                'sms_msg' => $message,
                "user_id" => Auth::user()->created_by
            ];
            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
            if(isset($sendLink->original["status"]) && $sendLink->original["status"] == false){
                return response()->json(["status" => false, "message" => $sendLink->original["message"]]);
            }
            
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

            if($link_by_sms == true){
                $related_to1 = "Share today offer link";
                $sent_via1 = "sms";
                $status1 = 1;
                // $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                    $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                }
                else{
                    $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
                }
            }

            if($link_by_wa == true){
                $related_to1 = "Share today offer link";
                $sent_via1 = "wa";
                $status1 = 1;
                // $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);

                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
            }
        }else{
            $message = "Congratulations, you are eligible to get an offer!\nClick: opnl.in/".$shortLinkData->original["code"]."\nComplete the task to get a discount instantly!\nOPNLNK";

            $followThisLink = "Follow this link:";

            $whatsapp_msg ="Hi there!\n\nWe hope you're enjoying your experience with *".$biz_name."*. We're excited to announce our *Instant Challenge* program,\n\nwhere you can get discounts/gifts Instantly by sharing our business with your friends and family or anyone in your network!\n\nAll you have to do is complete some easy social media tasks such as liking our Facebook page, subscribing to our Youtube channel, and leaving a review on Google. etc\n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]." to see all the details of the *Instant Challenge* program, including the tasks and discounts/gifts.\n\nThank you for supporting our business and helping us grow!";

            $params = [
                "mobile" => "91".$request->mobile,
                "message" => $message,
                "channel_id" => 2,
                'whatsapp_msg' => $whatsapp_msg,
                'sms_msg' => $message,
                "user_id" => Auth::user()->created_by
            ];
            $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
            if(isset($sendLink->original["status"]) && $sendLink->original["status"] == false){
                return response()->json(["status" => false, "message" => $sendLink->original["message"]]);
            }
            
            
            $link_by_sms = $link_by_wa = false;
            $err_by_sms = $err_by_wa = '';
            if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                $link_by_wa = true;
            }else{
                if(isset($sendLink->original["wa"]["message"])){
                    $err_by_wa = $sendLink->original["wa"]["message"];
                }else{
                    $err_by_wa = $sendLink->original["wa"];
                }
                
            }

            if(isset($sendLink->original["sms"]["Status"]) && $sendLink->original["sms"]["Status"] == "1"){
                $link_by_sms = true;
            }else{  

                if(isset($sendLink->original["sms"]["message"])){
                    $err_by_sms = $sendLink->original["sms"]["message"];
                }else{
                    
                    if(isset($sendLink->original["sms"]["message"])){
                        $err_by_sms = $sendLink->original["sms"]["message"];
                    }else{
                        $err_by_sms = $sendLink->original["sms"];
                    }
                }
            }

            if($link_by_sms == true){
                $related_to1 = "Send Link";
                $sent_via1 = "sms";
                $status1 = 1;
                // $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);
                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, 1);
                
                // Insert in Deduction History Table
                $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                    $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                }
                else{
                    $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
                }
            }

            if($link_by_wa == true){
                $related_to1 = "Send Link";
                $sent_via1 = "wa";
                $status1 = 1;
                // $this->_addMessageHistory($user_id, $channel_id, $mobile, $message, $related_to1, $sent_via1, $status1);
                $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $whatsapp_msg, $related_to1, $sent_via1, 1);

                // Insert in Deduction History Table
                $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
            }
        }
        
        // dd($sendLink);
        if($link_by_sms == true || $link_by_wa == true){
            if($firstTime == true){
                /* How it works */
                /* $how_to_link = URL::to('/');
                $shortLinkHowToData = ShortLinkController::callShortLinkApi($how_to_link, $offer->user_id ?? 0, "instant_challenge");

                if($shortLinkHowToData->original["success"] == false){
                    return response()->json(["status" => false, "message" => "Shortlink not created."]);
                }

                $business_details = BusinessDetail::where('user_id', Auth::user()->created_by)->first();
                $biz_name = $business_details->business_name ?? 'business';
                if(strlen($biz_name) > 28){
                    $biz_name = substr($biz_name,0,28).'..';
                }

                $second_message = "How it works:\n-Open the link\n-Finish the task\n-Share the code with ".$biz_name." to avail a discount\nMore info: opnl.in/".$shortLinkHowToData->original["code"]."\nOPNLNK";

                $params = [
                    "mobile" => "91".$request->mobile,
                    "message" => $second_message,
                    "channel_id" => 2,
                    "user_id" => Auth::user()->created_by
                ];
                $sendSecondLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
                
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
                        $this->_addMessageHistory($user_id, $channel_id, $mobile, $second_message, $related_to2, $sent_via2, $status2);
                    }

                    if($link_by_wa_second == true){
                        $related_to2 = "How it Work";
                        $sent_via2 = "wa";
                        $status2 = 1;
                        $this->_addMessageHistory($user_id, $channel_id, $mobile, $second_message, $related_to2, $sent_via2, $status2);
                    } */

                    /* Send Link */
                    $third_message = "Congratulations, you are eligible to get an offer!\nClick: opnl.in/".$shortLinkData->original["code"]."\nComplete the task to get a discount instantly!\nOPNLNK";

                    $followThisLink = "Follow this link:";

                    $whatsapp_msg ="Hi there!\n\nWe hope you're enjoying your experience with *".$biz_name."*. We're excited to announce our *Instant Challenge* program,\n\nwhere you can get discounts/gifts Instantly by sharing our business with your friends and family or anyone in your network!\n\nAll you have to do is complete some easy social media tasks such as liking our Facebook page, subscribing to our Youtube channel, and leaving a review on Google. etc\n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]." to see all the details of the *Instant Challenge* program, including the tasks and discounts/gifts.\n\nThank you for supporting our business and helping us grow!";

                    $params = [
                        "mobile" => "91".$request->mobile,
                        "message" => $third_message,
                        'whatsapp_msg' => $whatsapp_msg,
                        'sms_msg' => $third_message,
                        "channel_id" => 2,
                        "user_id" => Auth::user()->created_by
                    ];
                    $sendThirdLink = app('App\Http\Controllers\MessageController')->sendMsg($params);
                    
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
                        // $this->_addMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, $status3);
                        $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, 1);

                        // Insert in Deduction History Table
                        $checkWallet = DeductionHelper::getUserWalletBalance($user_id);
                        if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                            $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                        }
                        else{
                            $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                            $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                            DeductionHelper::deductWalletBalance($user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0);
                        }
                    }
                    if($link_by_wa_third == true){
                        $related_to3 = "Send Link";
                        $sent_via3 = "wa";
                        $status3 = 1;
                        // $this->_addMessageHistory($user_id, $channel_id, $mobile, $third_message, $related_to3, $sent_via3, $status3);
                        $messageHistory_id = DeductionHelper::setMessageHistory($user_id, $channel_id, $mobile, $whatsapp_msg, $related_to3, $sent_via3, 1);

                        // Insert in Deduction History Table
                        $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

                        // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                        // DeductionHelper::deductWalletBalance($user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0);
                    }
                //}
            }
            

            $subscription = new OfferSubscription;
            $subscription->channel_id = 2;
            $subscription->user_id = Auth::user()->created_by;
            $subscription->created_by = Auth::id();
            $subscription->offer_id = $offer->id;
            $subscription->short_link_id = $shortLinkData->original["id"];
            $subscription->customer_id = $customer->id;
            $subscription->uuid = $tokenData['token'];
            $subscription->share_link = $link;
            $subscription->save();
            
            $offerSubscriptionReward = new OfferSubscriptionReward;
            $offerSubscriptionReward->user_id = Auth::user()->created_by;
            $offerSubscriptionReward->offer_id = $offer->id;
            $offerSubscriptionReward->offer_subscription_id = $subscription->id;
            $offerSubscriptionReward->type = $settings->type;
            $offerSubscriptionReward->details = $settings->details;
            $offerSubscriptionReward->save();

            /* Add to Instant Contacts */
            $contactGroup = ContactGroup::where('user_id', Auth::user()->created_by)->where('channel_id', 2)->first();
            $contact = GroupCustomer::where('user_id', Auth::user()->created_by)->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
            if($contact == null){
                $contact = new GroupCustomer;
                $contact->user_id = Auth::user()->created_by;
                $contact->contact_group_id = $contactGroup->id;
                $contact->customer_id = $customer->id;
                $contact->save();
            }

            // Insert Subscription in Deduction History Table
            $customer = Customer::where('mobile',$request->mobile)->orderBy('id', 'desc')->first();

            // $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'instant_challenge_subscription');
            // DeductionHelper::deductWalletBalance($user_id, $deductionDetail->id ?? 0, $channel_id, 0, $customer->id ?? 0, 0);

            return response()->json(["status" => true, "message" => "Offer link shared successfully.", "link" => $share_link]);
        }else{
            if($err_by_wa != "Route not active"){
                return response()->json(["status" => false, "message" => $err_by_wa]);
            }

            if($link_by_sms != "Route not active"){
                return response()->json(["status" => false, "message" => $link_by_sms]);
            }

            return response()->json(["status" => false, "message" => "Route not active"]);
            
        }
        //dd('Done');
    }

    public function customerInfo(Request $request){
        // dd(Auth::user());
        $customer = Customer::with('customer_info')->where('mobile',$request->mobile)->first();
        if($customer == null){
            return response()->json(["status" => false, "message" => "Customer not found."]);
        }else{
            return response()->json(["status" => true, "message" => "Customer found.", "data" => $customer]);
        }
    }

    public function customer($request){
        
        $customer = Customer::with('customer_info')->where('mobile',$request->mobile)->first();
        if($customer == null){
            $customer= new Customer;
            $customer->mobile = $request->mobile;
            $customer->user_id = Auth::user()->created_by;
            $customer->created_by = Auth::id();
            $customer->save();

            $customer->uuid = $customer->id.'CUST'.date("Ymd");
            $customer->save();

            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = Auth::user()->created_by;
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary;
            $business_customer->save();

        }else{
            if($customer->customer_info == null){
                $business_customer = new BusinessCustomer;
                $business_customer->customer_id = $customer->id;
                $business_customer->user_id = Auth::user()->created_by;
                
            }else{
                $business_customer = BusinessCustomer::find($customer->customer_info->id);
                
            }
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary;
            $business_customer->save();
        }

        /* Add to Instant Contacts start */
        $contactGroup = ContactGroup::where('user_id', Auth::user()->created_by)->where('channel_id', 2)->first();
        $contact = GroupCustomer::where('user_id', Auth::user()->created_by)->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
        if($contact == null){
            $contact = new GroupCustomer;
            $contact->user_id = Auth::user()->created_by;
            $contact->contact_group_id = $contactGroup->id;
            $contact->customer_id = $customer->id;
            $contact->save();
        }
        /* Add to Instant Contacts end */

        $customer = Customer::with('customer_info')->where('id',$customer->id)->first();

        return $customer;
    }

    public function applyRedeemCode(Request $request){
        $this->validate($request, [
            'redeem_code' => 'required|min:6'
        ]);

        $redeem = Redeem::where('code',$request->redeem_code)->where('user_id', Auth::user()->created_by)->orderBy('id', 'desc')->first();
        if($redeem == null){
            return response()->json(["status" => false, "message" => "Redeem code is invalid."]);
        }else{
            if($redeem->is_redeemed != 0){
                return response()->json(["status" => false, "message" => "Offer is already redeemed."]);
            }else{
                $offer = Offer::find($redeem->offer_id);
                if($offer->end_date < date("Y-m-d")){
                    return response()->json(["status" => false, "message" => "Redeem code is invalid. Offer expired."]);
                }
                
                $subscription = OfferSubscription::where('id',$redeem->offer_subscription_id)->first();
                $clicks = Target::where('offer_subscription_id',$subscription->id)->where('repeated',0)->count();

                $redeemDetails = OfferSubscriptionReward::where('offer_subscription_id',$redeem->offer_subscription_id)->where('user_id', Auth::user()->created_by)->first();

                $redeemDetails['details'] = json_decode($redeemDetails['details'], true); 
                $redeemDetails['total_clicks'] = $clicks;
                $redeemDetails['redeem_id'] = $redeem->id;

                return response()->json(["status" => true, "message" => "Coupon is valid. Please Proceed.", "redeemDetails" => $redeemDetails]);
            }
        }
    }

    public function redeemOffer(Request $request){
        //dd($request->all());
        
        $redeem = Redeem::where('id', $request->redeem_id)->orderBy('id', 'desc')->first();

        $invoice_no = $this->getInvoiceNo($redeem->offer_id);
        if($request->invoice == ''){
            $redeem_invoice_no = $invoice_no;
        }else{
            $redeem_invoice_no = $request->invoice;
        }

        $redeem_detail  =  RedeemDetail::Create([
                            'user_id' => Auth::user()->created_by,
                            'offer_id' => $redeem->offer_id,
                            'offer_subscription_id' => $redeem->offer_subscription_id,
                            'redeem_id' => $redeem->id,  
                            'redeem_invoice_no' => $redeem_invoice_no,
                            'invoice_no' => $invoice_no,
                            'discount_type' => $request->type,
                            'discount_value' => $request->discount_value,
                            'no_of_clicks' => $request->no_of_clicks,
                            'actual_amount' => $request->actual_amount,
                            'redeem_amount' => $request->redeem_amount,
                            'calculated_amount' => $request->calculated_amount,
                            'discount_received' => $request->discount_received,
                            'redeem_by' => Auth::id()
                        ]);

        if($redeem_detail){
            $redeem->is_redeemed = 1;
            $redeem->save();

            $rewardSetting = OfferSubscriptionReward::where('offer_subscription_id', $redeem->offer_subscription_id)->first();
            $reward = json_decode($rewardSetting->details);

            if(isset($reward->pending_click)){
                $total_clicks = Target::where('offer_subscription_id', $redeem->offer_subscription_id)->count();
                $reward->pending_click = ($reward->maximum_click - $total_clicks) > 0 ? ($reward->maximum_click - $total_clicks) : 0;

                $rewardSetting->details = json_encode($reward);
                $rewardSetting->save();

                Target::where('offer_subscription_id', '=', $redeem->offer_subscription_id)->update(['repeated' => 1]);
            }

            /* Send redeem invoice to customer pending */

            return response()->json(["status" => true, "message" => "Redeemed Successfully."]);
        }

    }

    public function getInvoiceNo($offer_id){
        $invoice_no = '';
        $last = RedeemDetail::where('offer_id',$offer_id)->select('invoice_no')->latest()->orderBy('id', 'desc')->first();

        $offer_id_no = sprintf('%03d', $offer_id);

        if($last != null){
            $invoice_details = explode('-', $last->invoice_no);
            $prev = (int)$invoice_details[1];
            $prev++;
            $redeem_no = sprintf('%06d', $prev);
            $invoice_no = $offer_id_no.'-'.$redeem_no;
        }else{
            $redeem_no = sprintf('%06d', 1);
            $invoice_no = $offer_id_no.'-'.$redeem_no;
        }
        
        return $invoice_no;
    }

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

        $messageWallet = MessageWallet::where('user_id',$user_id)
                        ->orderBy('id','desc')->first();
        $messageWallet->total_messages = $messageWallet->total_messages - 1;
        $messageWallet->save();
    }

}
