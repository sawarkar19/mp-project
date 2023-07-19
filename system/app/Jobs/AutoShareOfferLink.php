<?php

namespace App\Jobs;

use DB;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Redeem;
use App\Models\Customer;
use App\Models\ShortLink;
use App\Models\OfferReward;

use App\Models\UserChannel;
use App\Models\MessageWallet;

use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\OfferSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Models\OfferSubscriptionReward;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;

use App\Http\Controllers\UuidTokenController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class AutoShareOfferLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        // Check plan expire condition

        $todays_date = date('Y-m-d');
        $users = UserChannel::where('channel_id', 3)->where('will_expire_on', '>=', $todays_date)->pluck('user_id')->toArray();
        $usersWithShareAuto = BusinessDetail::with('autoSharingTime')->has('autoSharingTime')->whereIn('user_id', $users)->where('share_to_subscribed_customers', 1)->get();

        foreach ($usersWithShareAuto as $key => $userData){
            
                $current_datetime = date('Y-m-d H:i:s');
                $minus_datetime = date("Y-m-d H:i:s", strtotime('-'.$userData->autoSharingTime->time_period.' hours', strtotime($current_datetime)));
                $start_datetime = date('Y-m-d 00:01:00');


                $msgHistories = MessageHistory::whereIn('channel_id', [2, 4])
                                            ->whereIn('related_to', ['Send Link', 'WhatsApp API'])
                                            ->where('created_at', '<', $minus_datetime)
                                            // ->where('created_at', '>', $start_datetime)
                                            // ->where('created_at', '<', $current_datetime)
                                            ->where('user_id', $userData->user_id)
                                            ->where('is_sent_auto_msg', 0)
                                            // ->groupBy('mobile')
                                            ->orderBy('id', 'desc')
                                            ->get();


                // get Business today running offers
                $offer = Offer::where('user_id', $userData->user_id)->where('start_date', '<=', $todays_date)->where('end_date', '>=', $todays_date)->first();

                if(!empty($msgHistories) && $offer != NULL){ 

                    foreach ($msgHistories as $historyKey => $msgHistory) {

                            // get Customer Detail
                            $customer_mobile = substr($msgHistory->mobile, -10);
                            $customer = Customer::where('mobile', $customer_mobile)->first();
                            //    dd($customer_mobile);
                            if($customer != null){
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
                                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $offer->user_id ?? 0, "shared_challenge");

                                    if($shortLinkData->original["success"] == false){
                                        // Log::debug('Shortlink not created.');
                                    }

                                    $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',3)->first();
                                    if($settings == null){
                                        // Log::debug('Please Update Share and Reward settings.');
                                    }

                                    /* Share link */
                                    $short_link = "https://opnl.in/".$shortLinkData->original["code"];
                                    
                                    $userData = BusinessDetail::where('user_id', $userData->user_id)->first();
                                    $biz_name = $userData->business_name ?? 'business owner';
                                    if(strlen($biz_name) > 28){
                                        $biz_name = substr($biz_name,0,28).'..';
                                    }

                                    $message = "You are eligible for Challenge\nClick: opnl.in/".$shortLinkData->original["code"]."\nShare to your contacts to get benefits on your next purchase with ".$biz_name."\nOPNLNK";

                                    $followThisLink = "Follow this link:";

                                    $whatsapp_msg = "Hello again!\n\nWe have another exciting and simple to do challenge for you. All you need to do is share the provided link with your friends and family, and get targeted clicks.\n\nOnce you've completed this task, you'll receive a prize as a benefit for your effort on your next purchase!\n\nDon't miss out on this opportunity to earn some extra prizes while supporting *".$biz_name."*. \n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]."  to the offer page for more details on this task and the reward.\n\nThank you for your continued support!";
                                    
                                    // $customerData = Customer::find($customer);
                                    
                                    $params = [
                                        "mobile" => "91".$customer_mobile,
                                        "message" => $message,
                                        "channel_id" => 3,
                                        'whatsapp_msg' => $whatsapp_msg,
                                        'sms_msg' => $message,
                                        "user_id" => $offer->user_id
                                    ];
                                    $sendLink = app('App\Http\Controllers\MessageController')->sendMsg($params);                    
                                    // Log::debug($sendLink);
                
                                    $link_by_sms = $link_by_wa = false;
                                    $err_by_sms = $err_by_wa = '';
                                    if(isset($sendLink->original["wa"]["status"]) && $sendLink->original["wa"]["status"] == "success"){
                                        $link_by_wa = true;
                                        
                                        $messageWallet = MessageWallet::where('user_id', $offer->user_id)->first();
                                        $messageWallet->total_messages = $messageWallet->total_messages - 1;
                                        $messageWallet->save();

                                    }else{
                                        // dd($sendLink);
                                        $err_by_wa = $sendLink->original["wa"]["message"];
                                    }

                                    if(isset($sendLink->original["sms"]["Status"]) && $sendLink->original["sms"]["Status"] == "1"){
                                        $link_by_sms = true;
                                        
                                        $messageWallet = MessageWallet::where('user_id', $offer->user_id)->first();
                                        $messageWallet->total_messages = $messageWallet->total_messages - 1;
                                        $messageWallet->save();

                                    }else{  
                                        if(isset($sendLink->original["sms"]["message"])){
                                            $err_by_sms = $sendLink->original["sms"]["message"];
                                        }else{
                                            $err_by_sms = $sendLink->original["sms"];
                                        }
                                    }
                                    
                                    // dd($sendLink);
                                    if($link_by_sms == true || $link_by_wa == true){
                                        if($link_by_sms == true){


                                            /* Customer ID */
                                            $customer_id = 0;
                                            $customer = Customer::where('mobile', $customer_mobile)->first();
                                            if($customer != null){
                                                $customer_id = $customer->id;
                                            }

                                            $wel_sms_message = new MessageHistory;
                                            $wel_sms_message->user_id = $offer->user_id;
                                            $wel_sms_message->channel_id = 3;
                                            $wel_sms_message->customer_id = $customer_id;
                                            $wel_sms_message->offer_id = $offer->id;
                                            $wel_sms_message->mobile = "91".$customer_mobile;
                                            $wel_sms_message->content = $message;
                                            $wel_sms_message->related_to = "Share and reward";
                                            $wel_sms_message->sent_via = 'sms';
                                            $wel_sms_message->status = 1;
                                            $wel_sms_message->save();
                                        }

                                        if($link_by_wa == true){

                                            /* Customer ID */
                                            $customer_id = 0;
                                            $customer = Customer::where('mobile', $customer_mobile)->first();
                                            if($customer != null){
                                                $customer_id = $customer->id;
                                            }
                                            

                                            $wel_wa_message = new MessageHistory;
                                            $wel_wa_message->user_id = $offer->user_id;
                                            $wel_wa_message->channel_id = 3;
                                            $wel_wa_message->customer_id = $customer_id;
                                            $wel_wa_message->offer_id = $offer->id;
                                            $wel_wa_message->mobile = "91".$customer_mobile;
                                            $wel_wa_message->content = $message;
                                            $wel_wa_message->related_to = "Share and reward";
                                            $wel_wa_message->sent_via = 'wa';
                                            $wel_wa_message->status = 1;
                                            $wel_wa_message->save();
                                        }                    
                                    
                                        
                                        $incomplete = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $customer->id)->where('status','3')->first();

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
                                        $offerSubscriptionReward->type = @$settings->type;
                                        $offerSubscriptionReward->details = @$settings->details;
                                        $offerSubscriptionReward->save();

                                        // Update message_histories row
                                        $updatehistory = MessageHistory::where('id', $msgHistory->id)->first();
                                        $updatehistory->is_sent_auto_msg = 1;
                                        $updatehistory->save();

                                    }
                                
                                }

                                sleep(30);
                            
                            }
                    }
                }
            
        }

    }
}
