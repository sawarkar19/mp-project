<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Option;
use App\Models\Customer;
use App\Models\ShortLink;
use App\Models\InstantTask;
use App\Models\OfferReward;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\OfferTemplate;
use App\Models\ShareChallengeContact;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\OfferSubscription;
use Illuminate\Queue\SerializesModels;
use App\Models\OfferSubscriptionReward;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use DeductionHelper;

class ShareNewOfferLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $offer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $businessDetails = BusinessDetail::with('user')->has('user')->where('user_id', $this->offer->user_id)->select('id','user_id','selected_groups','business_name')->first();
        $groups = explode(',', $businessDetails->selected_groups);
        $customerIds = ShareChallengeContact::where('user_id', $this->offer->user_id)->where('offer_id', $this->offer->id)->where('status', 1)->pluck('customer_id')->toArray();
        $grpCustomers = GroupCustomer::whereIn('contact_group_id', $groups)->whereNotIn('customer_id', $customerIds)->groupBy('customer_id')->pluck('customer_id')->toArray();

        if(!empty($grpCustomers)){
            foreach($grpCustomers as $index => $customer_id){
                /* check if already subscribed */
                $subscription = OfferSubscription::where('user_id', $this->offer->user_id)->where('offer_id', $this->offer->id)->where('channel_id', 3)->where('customer_id', $customer_id)->where('status','1')->first();
                
                // Check Wallet using Route
                $checkWalletBalance = DeductionHelper::checkWalletBalanceWithChannel($this->offer->user_id, 3, ['send_sms']);

                if($subscription == '' && $checkWalletBalance['status'] == true){
                    
                    $type = 'future';
                    $randomString = UuidTokenController::eightCharacterUniqueToken(8);
                    $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
                    $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
    
                    /* Domain */
                    $option = Option::where('key', 'site_url')->first();
                    
                    if($this->offer->website_url == ''){
                        $share_link = '/f/'.$this->offer->uuid.'?share_cnf='.$tokenData['token'];
                    }else{
                        $url = rtrim($this->offer->website_url,"/");
                        $share_link = $url.'/?o='.$this->offer->uuid.'&share_cnf='.$tokenData['token'];
                    }
                    $uuid_code = $tokenData['token'];
    
                    /* Get Short Link */
                    if($this->offer->website_url != ''){
                        $long_link = $share_link;
                    }else{
                        $long_link = $option->value.$share_link;
                    }
                    $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $this->offer->user_id ?? 0, "share_new_offer");
    
                    if($shortLinkData->original["success"] !== false){
                        $settings = OfferReward::where('user_id', $this->offer->user_id)->where('channel_id',3)->first();
                        if($settings != null){
                            /* Share link */
                            $short_link = "https://opnl.in/".$shortLinkData->original["code"];
                            
                            $biz_name = $businessDetails->business_name ?? 'business owner';
                            if(strlen($biz_name) > 28){
                                $biz_name = substr($biz_name,0,28).'..';
                            }
    
                            $message = "You are eligible for Challenge\nClick: opnl.in/".$shortLinkData->original["code"]."\nShare to your contacts to get benefits on your next purchase with ".$biz_name."\nOPNLNK";
                            
                            $customerData = Customer::find($customer_id);
                            
                            $params = [
                                "mobile" => "91".$customerData->mobile,
                                "message" => $message,
                                "channel_id" => 3,
                                'whatsapp_msg' => $message,
                                'sms_msg' => $message,
                                "user_id" => $this->offer->user_id
                            ];
                            $sendSMS = app('App\Http\Controllers\MessageController')->sendOnlyMsg($params);
                            
                            $link_by_sms = false;
    
                            if(isset($sendSMS->original["sms"]["Status"]) && $sendSMS->original["sms"]["Status"] == "1"){
                                $link_by_sms = true;
                            }
                            
                            if($link_by_sms == true){
                                $channel_id = 3;
                                $related_to = "Share and reward";
                                
                                $messageHistory = DeductionHelper::setMessageHistory($this->offer->user_id, $channel_id, "91".$customerData->mobile, $message, $related_to, 'sms', 1);


                                $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                                    
                                DeductionHelper::deductWalletBalance($this->offer->user_id, $deductionSmsDetail->id ?? 0, $channel_id, $messageHistory, $customer_id, 0); 
                                    
                                $ShareChallengeContactstatus=1;

                                $shareContactData = ShareChallengeContact::where('user_id', $this->offer->user_id)->where('offer_id', $this->offer->id)->where('customer_id', $customer_id)->where('status', 0)->first();
                                
                                if($shareContactData != null){
                                    $offerHistory=DeductionHelper::setOfferContactHistory($this->offer->user_id,$customer_id,$this->offer->id,$ShareChallengeContactstatus,$shareContactData->id);
                                }else{
                                    $offerHistory=DeductionHelper::setOfferContactHistory($this->offer->user_id,$customer_id,$this->offer->id,$ShareChallengeContactstatus);
                                }
                                
    
                                $shortLink = new ShortLink;
                                $shortLink->uuid = $shortLinkData->original["code"];
                                $shortLink->link = $long_link;
                                $shortLink->save();
    
                                $subscription = new OfferSubscription;
                                $subscription->channel_id = 3;
                                $subscription->user_id = $this->offer->user_id;
                                $subscription->created_by = $this->offer->user_id;
                                $subscription->offer_id = $this->offer->id;
                                $subscription->short_link_id = $shortLink->id;
                                $subscription->customer_id = $customer_id;
                                $subscription->uuid = $uuid_code;
                                $subscription->share_link = $share_link;
                                $subscription->save();
                        
                                $offerSubscriptionReward = new OfferSubscriptionReward;
                                $offerSubscriptionReward->user_id = $this->offer->user_id;
                                $offerSubscriptionReward->offer_id = $this->offer->id;
                                $offerSubscriptionReward->offer_subscription_id = $subscription->id;
                                $offerSubscriptionReward->type = $settings->type;
                                $offerSubscriptionReward->details = $settings->details;
                                $offerSubscriptionReward->save();

                            }else{

                                $ShareChallengeContactstatus=0;
                                    
                                $offerHistory = DeductionHelper::setOfferContactHistory($this->offer->user_id,$customer_id,$this->offer->id,$ShareChallengeContactstatus);
                            }
                        }
                    }
                }else{
                    $ShareChallengeContactstatus=0;
                                    
                    $offerHistory = DeductionHelper::setOfferContactHistory($this->offer->user_id,$customer_id,$this->offer->id,$ShareChallengeContactstatus);
                }
            }
        }
    }
}
