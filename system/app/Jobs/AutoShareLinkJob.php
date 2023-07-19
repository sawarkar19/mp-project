<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\Option;
use App\Models\Customer;
use App\Models\ShortLink;
use App\Models\OfferReward;
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

use DeductionHelper;

class AutoShareLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $msgHistory;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($msgHistory)
    {
        $this->msgHistory = $msgHistory;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get Customer Detail
        $customer_mobile = substr($this->msgHistory->mobile, -10);
        $customer = Customer::where('mobile', $customer_mobile)->first();
        $offer = Offer::where('user_id', $this->msgHistory->user_id)->where('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->first();
        
        if($customer != null){
            /*old subscription query*/
            $subscription = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $customer->id)->where('status','1')->first();

            /*new subscription query*/
            //$subscription = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $customer->id)->whereIn('status',['1','2'])->first();
            
            // Check Wallet using Route
            $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($offer->user_id, 3, ['send_sms', 'send_whatsapp', 'share_challenge_subscription']);

            /* Check whether customer subscribed in instant challenge for current offer */
            $activeInstantChallenge = OfferSubscription::where('user_id', $offer->user_id)->where('channel_id', 2)->where('customer_id', $customer->id)->whereIn('status',['1','2'])->first();
            
            if($subscription == '' && $activeInstantChallenge != ''){
                
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
                
                if($shortLinkData->original["success"] !== false){
                    $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',3)->first();
                    if($settings != null){
                        /* Share link */
                        $short_link = "https://opnl.in/".$shortLinkData->original["code"];
                        
                        $userData = BusinessDetail::where('user_id', $this->msgHistory->user_id)->first();
                        $biz_name = $userData->business_name ?? 'business owner';
                        if(strlen($biz_name) > 28){
                            $biz_name = substr($biz_name,0,28).'..';
                        }

                        $message = "You are eligible for Challenge\nClick: opnl.in/".$shortLinkData->original["code"]."\nShare to your contacts to get benefits on your next purchase with ".$biz_name."\nOPNLNK";
                        // dd($biz_name);
                        $followThisLink = "Follow this link:";

                        $whatsapp_msg = "Hello again!\n\nWe have another exciting and simple to do challenge for you. All you need to do is share the provided link with your friends and family, and get targeted clicks.\n\nOnce you've completed this task, you'll receive a prize as a benefit for your effort on your next purchase!\n\nDon't miss out on this opportunity to earn some extra prizes while supporting *".$biz_name."*. \n\n *".$followThisLink."* Click: opnl.in/".$shortLinkData->original["code"]."  to the offer page for more details on this task and the reward.\n\nThank you for your continued support!";


                        $params = [
                            "mobile" => "91".$customer_mobile,
                            "message" => $message,
                            "whatsapp_msg" => $whatsapp_msg,
                            "sms_msg" => $message,
                            "channel_id" => 3,
                            "user_id" => $offer->user_id
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
                        
                        if($link_by_sms == true || $link_by_wa == true){
                            $channel_id = 3;
                            $related_to = "Share and reward";

                            if($link_by_sms == true){
                                $messageHistory_id = DeductionHelper::setMessageHistory($offer->user_id, $channel_id, "91".$customer_mobile, $message, $related_to, 'sms', 1);
                                
                                // Insert in Deduction History Table
                                $checkWallet = DeductionHelper::getUserWalletBalance($offer->user_id);
                                if($checkWallet['status']==true && $checkWallet['wallet_balance'] <= 0){
                                    $sms_res = ['status'=> false, 'message' => "Unable to send sms due to low balance"];
                                }
                                else{
                                    $customer = Customer::where('mobile',$customer_mobile)->orderBy('id', 'desc')->first();

                                    $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                                    DeductionHelper::deductWalletBalance($offer->user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
                                }
                            }

                            if($link_by_wa == true){
                                $messageHistory_id = DeductionHelper::setMessageHistory($offer->user_id, $channel_id, "91".$customer_mobile, $message, $related_to, 'wa', 1);

                                // Insert in Deduction History Table
                                $customer = Customer::where('mobile',$customer_mobile)->orderBy('id', 'desc')->first();

                                // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_whatsapp');
                                // DeductionHelper::deductWalletBalance($offer->user_id, $deductionWaDetail->id ?? 0, $channel_id, $messageHistory_id, $customer->id ?? 0, 0);
                            }
                        
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

                            // Update message_histories row
                            $updatehistory = MessageHistory::where('id', $this->msgHistory->id)->first();
                            $updatehistory->is_sent_auto_msg = 1;
                            $updatehistory->save();

                            // Insert Subscription in Deduction History Table
                            $customer = Customer::where('mobile',$customer_mobile)->orderBy('id', 'desc')->first();

                            // $deductionWaDetail = DeductionHelper::getActiveDeductionDetail('slug', 'share_challenge_subscription');
                            // DeductionHelper::deductWalletBalance($offer->user_id, $deductionWaDetail->id ?? 0, $channel_id, 0, $customer->id ?? 0, 0);
                            
                        }
                    }
                }
            } 
        }
    }
}
