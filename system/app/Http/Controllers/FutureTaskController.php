<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Offer;
use App\Models\InstantTask;
use App\Models\State;
use App\Models\Option;
use App\Models\Redeem;
use App\Models\Target;
use App\Models\Customer;
use App\Models\Template;
use App\Models\ShortLink;
use App\Models\SocialPost;

use App\Models\OfferReward;
use Illuminate\Http\Request;
use App\Models\MessageWallet;
use App\Models\OfferTemplate;
use App\Models\SocialChannel;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\SocialPlatform;
use App\Models\SocialPostCount;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Models\OfferSubscriptionReward;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

use App\Helper\Deductions\DeductionHelper;

class FutureTaskController extends Controller
{

    public function offerPage(Request $request){
        $uuid = \Request::segment(2);

        // Update Social Count
        $is_social_post = false;
        if(isset($request->media)){
            $is_social_post = true;
        }

        $show_meta = 1;
        $only_view = $show_header = 0;

        
        $offer = Offer::with('offer_template')->where('uuid', $uuid)->first();
        $business = '';
        $is_posted = InstantTask::where('user_id', Auth::id())->where('offer_id', $offer->id)->whereNull('deleted_at')->count();
        
        $today = date("Y-m-d");
        $domain = URL::to('/');
        // dd($offer);
        if($offer == null){
            return Response(view('errors.401'));
        }else if($offer != null && $is_social_post == false){

            $business = BusinessDetail::where('user_id',$offer->user_id)->orderBy('id','desc')->first();
            $business['state'] = State::where('id', $business['state'])->pluck('name')->first();

            if($today > $offer->end_date && $offer->end_date != ''){
                
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
                    // dd($business);
                    if($business->vcard_type == 'webpage'){
                        $url = $business->webpage_url;
                    }else{
                        $url = $domain.'/business/info/'.$business->uuid;
                    }
                    
                }
                
                return Redirect::to($url);
            }
        }else if($offer != null && $is_social_post == true){
            $business = BusinessDetail::where('user_id',$offer->user_id)->orderBy('id','desc')->first();
            $business['state'] = State::where('id', $business['state'])->pluck('name')->first();
        }

        $edit_url = route('business.offerEdit', $offer->id);

        $popup_cookie_name = "social_post_popup";
        $popup_cookie_value = $uuid;

        $isShowPopup = 0;
        if($request->get('media')){
            $isShowPopup = 1;
        }
        if(isset($_COOKIE[$popup_cookie_name]) && $_COOKIE[$popup_cookie_name] == $popup_cookie_value){
            $isShowPopup = 0;
        }

        if($offer->type == 'custom'){
            if($offer->website_url == ''){
                return view('builder.custom-preview', compact('business','only_view','show_meta','offer','edit_url','show_header', 'isShowPopup','is_posted'));
            }else{
                return Redirect::to($offer->website_url);
            }
        }else{
            $offer->offer_template->contact_icons = json_decode($offer->offer_template->contact_icons);
        
            $video_id = '';
            if($offer->offer_template->video_url != null){
                $youtube_url = strpos($offer->offer_template->video_url, 'youtube.com');
                if ($youtube_url === false) {
                    $uriSegments = explode("/", parse_url($offer->offer_template->video_url, PHP_URL_PATH));
                    $video_id = array_pop($uriSegments);
                }else{
                    $video_params = explode("?v=", $offer->offer_template->video_url);
                    $video_id = $video_params[1];
                }
            }

            $g = $t = 1;
            $gallery_color_titles = $tag_1_bg_colors = $tag_2_bg_colors = array();
            foreach($offer->offer_template->offer_gallery as $key => $gallery){
                //Image Title Color
                if(isset($gallery->title_color) && $gallery->title_color != ''){
                    $gallery_color_titles[$g] = $gallery->title_color;
                }else{
                    $gallery_color_titles[$g] = '#000000';
                }

                $g++;

                //Tag Background Color
                if(isset($gallery->tag_1_bg_color) && $gallery->tag_1_bg_color != ''){
                    $tag_1_bg_colors[$t] = $gallery->tag_1_bg_color;
                }else{
                    $tag_1_bg_colors[$t] = '#ed3535';
                }

                if(isset($gallery->tag_2_bg_color) && $gallery->tag_2_bg_color != ''){
                    $tag_2_bg_colors[$t] = $gallery->tag_2_bg_color;
                }else{
                    $tag_2_bg_colors[$t] = '#ed3535';
                }

                $t++;
            }


            //Text Content Color
            $text_colors = array();
            $c = 1;
            foreach($offer->offer_template->content as $key => $text){
                if(isset($text->content_color) && $text->content_color != ''){
                    $text_colors[$c] = $text->content_color;
                }else{
                    $text_colors[$c] = '#000000';
                }

                $c++;
            }

            //Button Color
            $button_colors = $button_bg_colors = $btn_style_types = array();
            $b = 1;
            foreach($offer->offer_template->button as $key => $button){
                if(isset($button->btn_text_color) && $button->btn_text_color != ''){
                    $button_colors[$b] = $button->btn_text_color;
                }else{
                    $button_colors[$b] = '#000000';
                }

                if(isset($button->btn_style_color) && $button->btn_style_color != ''){
                    $button_bg_colors[$b] = $button->btn_style_color;
                }else{
                    $button_bg_colors[$b] = '#000000';
                }

                if(isset($button->btn_style_type) && $button->btn_style_type != ''){
                    $btn_style_types[$b] = $button->btn_style_type;
                }else{
                    $btn_style_types[$b] = 'Background';
                }

                $b++;
            }

            $template = $offer->offer_template;
            $id = $template->slug;

            return view('builder.preview', compact('id', 'template', 'business','only_view','show_meta','offer','video_id','gallery_color_titles','tag_1_bg_colors','tag_2_bg_colors','edit_url','text_colors','show_header', 'button_colors', 'button_bg_colors', 'btn_style_types', 'isShowPopup','is_posted'));
        }
    }

    public function updateCount($uuid = null, $mediaId = null){
        
        $offer = Offer::where('uuid', $uuid)->first();
        if($offer == null){
        	return ['status' => false];
        }

        $post = SocialPost::where('offer_id', $offer->id)->first();
        if($post == null){
        	return ['status' => false];
        }

        $mediaData = SocialPlatform::where('social_post_id', $post->id)->where('value', $mediaId)->first();
        if($mediaData == null){
        	return ['status' => false];
        }

        $media = $mediaData->platform_key;

        // dd($media);
        
        $cookie_name = "social_post_".$media;
        $cookie_value = $media;

        $popup_cookie_name = "social_post_popup";
        $popup_cookie_value = $uuid;
        
		if(isset($_SERVER['HTTP_USER_AGENT']) && !empty($media)){	
            $is_bot = false;		
            $bots = ['LinkedInBot', 'facebookexternalhit', 'Twitterbot', 'help@dataminr.com', 'applebot'];
            foreach($bots as $bot){
                if($is_bot === false){
                    $is_bot = strpos($_SERVER['HTTP_USER_AGENT'], $bot);
                }
            }

			if ($is_bot === false) {
				
                $count = new SocialPostCount;
                $count->social_post_id = $post->id;
                $count->user_id = $post->user_id;
                $count->media = $media;
                $count->device= $_SERVER['HTTP_USER_AGENT'];

                if(!isset($_COOKIE[$cookie_name])) {
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
					setcookie($popup_cookie_name, $popup_cookie_value, time() + (86400 * 30), "/");

					$count->is_repeated = '0';
					$count->save();
				}else if($_COOKIE[$cookie_name] == $cookie_value){
					$count->is_repeated = '1';
					$count->save();
				} 
			}
		}

        return ['status' => true];
    }

    public function random_strings($length)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length);
    }

    public function guidePage($uuid){
        $domain = URL::to('/');
        $guide = Customer::where('uuid',$uuid)->orderBy('id','desc')->first();
        
        if($guide != null){

            $active_offers =    OfferSubscription::with(['offer_details','is_redeemed','reward'])
                                ->has('offer_details')
                                ->withCount(['targets','completed_task','targets_parent'])
                                ->where('customer_id',$guide->id)
                                ->where('status','1')
                                ->latest()->paginate(6);
// dd($active_offers);
            $completed_offers =   OfferSubscription::with(['offer_details','is_redeemed','reward'])
                                ->has('offer_details')
                                ->withCount(['targets','completed_task','targets_parent'])
                                ->where('customer_id',$guide->id)
                                ->where('status','2')
                                ->latest()->paginate(6);

            $all_offers =   OfferSubscription::with(['offer_details','is_redeemed','reward'])
                            ->has('offer_details')
                            ->withCount(['targets','completed_task','targets_parent'])
                            ->where('customer_id',$guide->id)
                            ->latest()->paginate(6);   


            $businessIds = BusinessCustomer::where('customer_id', $guide->id)->pluck('user_id')->toArray();

            $today = date("Y-m-d");
            $my_stores = Offer::with(['business','offer_template'])->whereIn('user_id',$businessIds)->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->latest()->paginate(6);

            $userOfferIds = OfferSubscription::where('customer_id',$guide->id)->where('status','1')->pluck('offer_id')->toArray();

            $currentURL = URL::full();
            $explodeUrl = explode('?', $currentURL);
            $guide_url = $explodeUrl[0] ?? '';
    
// dd($explodeUrl);

            $total_count = OfferSubscription::where('customer_id',$guide->id)->count();
            $active_count = OfferSubscription::where('customer_id',$guide->id)->where('status','1')->count();
            $share_and_reward = OfferSubscription::where('customer_id',$guide->id)->where('channel_id',3)->count();
            $instant_reward = OfferSubscription::where('customer_id',$guide->id)->where('channel_id',2)->count();
            
            return view('front.info_pages.guide', compact(['domain','guide','total_count','active_count','share_and_reward','instant_reward','all_offers','completed_offers','active_offers','my_stores','userOfferIds', 'guide_url']));
        }else{
            return Response(view('errors.401'));
        }
    }

    public function subscribeAndShare(Request $request){

        $offer = Offer::find($request->offer_id);
        $customer = Customer::find($request->customer_id);
        
        /* check if already subscribed */
        $subscription = OfferSubscription::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('channel_id', 3)->where('customer_id', $customer->id)->where('status','1')->first();

        $redeem = '';
        if($subscription != ''){
            $redeem = Redeem::where('user_id', $offer->user_id)->where('offer_id', $offer->id)->where('offer_subscription_id',$subscription->id)->where('is_redeemed', 1)->first();
        }
        
        if($subscription == '' || ($subscription != '' && $redeem != '')){
            $type = 'future';
            $randomString = UuidTokenController::eightCharacterUniqueToken(8);
            $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
            $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
            
            if($tokenData['status'] == true){
                $tokenData = UuidTokenController::findUniqueToken($type, $addedCharacter);
            }

            /* Domain */
            $option = Option::where('key', 'site_url')->first();
            
            if($redeem != null){
                $share_link = $subscription->share_link;
                $uuid_code = $subscription->uuid;
            }else{
                if($offer->website_url == ''){
                    $share_link = '/f/'.$offer->uuid.'?share_cnf='.$tokenData['token'];
                }else{
                    $url = rtrim($offer->website_url,"/");
                    $share_link = $url.'/?o='.$offer->uuid.'&share_cnf='.$tokenData['token'];
                }
                $uuid_code = $tokenData['token'];
            }

            /* Get Short Link */
            if($offer->website_url != ''){
                $long_link = $share_link;
            }else{
                $long_link = $option->value.$share_link;
            }
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $offer->user_id ?? 0, "shared_challenge");

            if($shortLinkData->original["success"] == false){
                Log::debug('Shortlink not created.');
            }

            /* Share link */
            $short_link = "https://opnl.in/".$shortLinkData->original["code"];

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

            $settings = OfferReward::where('user_id', $offer->user_id)->where('channel_id',3)->first();
    
            $offerSubscriptionReward = new OfferSubscriptionReward;
            $offerSubscriptionReward->user_id = $offer->user_id;
            $offerSubscriptionReward->offer_id = $offer->id;
            $offerSubscriptionReward->offer_subscription_id = $subscription->id;
            $offerSubscriptionReward->type = $settings->type;
            $offerSubscriptionReward->details = $settings->details;
            $offerSubscriptionReward->save();

            return Redirect::to($short_link);
        }

        return Redirect::back();
    }    

    public function sendCashbackRedeem(Request $request,$uuid){

        $subscription = OfferSubscription::where('uuid',$uuid)->first();
        $settings = OfferSubscriptionReward::where('offer_subscription_id',$subscription->id)->first();
        $userId = $subscription->user_id;

        if($subscription->parent_id != ''){
            $completed_count = Target::whereIn('offer_subscription_id',[$subscription->id, $subscription->parent_id])->where('repeated',0)->count();
        }else{
            $completed_count = Target::where('offer_subscription_id',$subscription->id)->where('repeated',0)->count();
        }

        if($completed_count < 1){
            return ['status' => false, 'response' => 'Please increase your clicks count first.', 'count'=>'failed', 'code' => 400];
        }

        $redeem = Redeem::where('offer_subscription_id',$subscription->id)->where('is_redeemed',0)->orderBy('id','desc')->first();
        if($redeem != null && $redeem->for_clicks == $completed_count){
            return ['status' => false, 'response' => 'Redeem code already sent.', 'count'=>'failed', 'code' => 400];
        }

        $offer = Offer::where('id',$subscription->offer_id)->first();
        $customer = Customer::find($subscription->customer_id);
        $shortLink = ShortLink::where('id',$customer->short_link_id)->orderBy('id','desc')->first();
        
        //$redeem_code = $this->getRedeemCode($subscription->id);
        $redeem_code = $this->getRedeemCodeNew($subscription->id);
        $code = $redeem_code;
        
        /* Send Code */
        // $message = "Please share this redeem code ".$code;
// dd($subscription->user_id);
        $business_details = BusinessDetail::where('user_id', $userId)->first();
        $biz_name = $business_details->business_name ?? 'business owner';
        if(strlen($biz_name) > 28){
            $biz_name = substr($biz_name,0,28).'..';
        }

        /* Coupon Code Condition */
        /*if($business_details->user_id == 49){
            $code = 'SHARE500';
        }*/

        if($settings->type == 'No Reward'){
            $message = $whatsapp_msg = "Thank you for supporting us and sharing the word about ".$biz_name."!\nYour generosity is greatly appreciated.\nOPNLNK";
        }else{
            $message = "Awesome! You have completed the task!\nShare the code ".$code." with ".$biz_name." to get a discount on your next purchase!\nOPNLNK";

            $whatsapp_msg = "Hey,\n\nYou've done it again.Congratulations on completing the *Share Challenge* too for *".$biz_name."*!\n\nAs a prize for your efforts, we're excited to offer you a redeem code:\n\n*".$code."*\n\nthat you can use to claim your prize.\n\nSimply show/send this code at *".$biz_name."* to confirm and avail your discount/gift.\n\nWe appreciate your support and are thrilled to have you as a part of our *Share Challenge* program.\n\nThank you for spreading the word about our business and helping us grow. We will keep you informed about our upcoming offers.\n\nBest Regards,\n\n".$biz_name;
        }
        
        $params = [
            "mobile" => "91".$customer->mobile,
            "message" => $message,
            "whatsapp_msg" => $whatsapp_msg,
            "sms_msg" => $message,
            "channel_id" => 3,
            "user_id" => $userId
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

            if($link_by_sms == true){
                $mobile = "91".$customer->mobile;
                $related_to1 = "Click url to redeem";
                $sent_via1 = "sms";
                
                $customer = Customer::where('mobile', $customer->mobile)->first();
                $customer_id = (isset($customer) && $customer->id) ? $customer->id : 0;

                $messageHistory_id = DeductionHelper::setMessageHistory($userId, 3, $mobile, $message, $related_to1, $sent_via1, 1, $subscription->offer_id);

                $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                DeductionHelper::deductWalletBalance($userId, $deductionSmsDetail->id ?? 0, 3, $messageHistory_id, $customer_id, 0);

                // $messageHistoryParams=[
                //     'user_id' => $userId,
                //     'channel_id' => 3,
                //     'mobile' => "91".$customer->mobile,
                //     'content' => $message,
                //     'related_to' => "Click url to redeem",
                //     'sent_via' => "sms",
                //     'status' => 1,
                // ];
                // $this->_addMessageHistory($messageHistoryParams);
            }
            if($link_by_wa == true){
                $messageHistoryParams=[
                    'user_id' => $userId,
                    'channel_id' => 3,
                    'mobile' => "91".$customer->mobile,
                    'content' => $message,
                    'related_to' => "Click url to redeem",
                    'sent_via' => "wa",
                    'status' => 1,
                ];
                $this->_addMessageHistory($messageHistoryParams);
            }

            if($redeem != null){
                $redeem->code = $code;
                $redeem->save();
            }else{
                $redeem = new Redeem;
                $redeem->user_id = $userId;
                $redeem->offer_id = $subscription->offer_id;
                $redeem->offer_subscription_id = $subscription->id;
                $redeem->code = $code;
                $redeem->is_redeemed = 0;
                $redeem->for_clicks = $completed_count;
                $redeem->save();
            }
            
            $message = new MessageHistory;
            $message->user_id = $params['user_id'];
            $message->channel_id = $params['channel_id'];
            $message->customer_id = $customer_id;
            $message->offer_id = $offer_id;
            $message->mobile = $params['mobile'];
            $message->content = $params['content'];
            $message->related_to = $params['related_to'];
            $message->sent_via = $params['sent_via'];
            $message->status = $params['status'];
            $message->save();
            
            return ['status' => true, 'response' => 'Redeem code sent.', 'count'=>'code', 'code' => 200];
        }else{
            return ['status' => false, 'response' => 'Redeem code not shared.', 'count'=>'failed', 'code' => 400];
        }

        return response()->json(['status'=> false,'message'=> 'Failed to redeem.'], 200);

        //dd($subscription);
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

    private function _addMessageHistory($params)
    {

        /* Customer ID */
        $customer_id = 0;
        $mobile_number = substr($params['mobile'], 2);
        $customer = Customer::where('mobile', $mobile_number)->first();
        if($customer != null){
            $customer_id = $customer->id;
        }

        $offer_id = 'NULL';
        if(isset($params['offer_id'])){
            $offer_id = $params['offer_id'];
        }

        $message = new MessageHistory;
        $message->user_id = $params['user_id'];
        $message->channel_id = $params['channel_id'];
        $message->customer_id = $customer_id;
        $message->offer_id = $offer_id;
        $message->mobile = $params['mobile'];
        $message->content = $params['content'];
        $message->related_to = $params['related_to'];
        $message->sent_via = $params['sent_via'];
        $message->status = $params['status'];
        $message->save();

        $messageWallet = MessageWallet::where('user_id', $params['user_id'])
                        ->orderBy('id','desc')->first();
        $messageWallet->total_messages = $messageWallet->total_messages - 1;
        $messageWallet->save();
    }

    public function updateSocialCount(Request $request)
    {
        if($request->uuid && $request->media){
            $updateCount = $this->updateCount($request->uuid, $request->media);
        }
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
}
