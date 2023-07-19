<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;
use App\Http\Controllers\CommonMessageController;

use App\Models\OfferSubscription;
use Illuminate\Http\Request;
use App\Models\OfferFuture;
use App\Models\Offer;
use App\Models\InstantTask;
use App\Models\State;
use App\Models\City;
use App\Models\Customer;
use App\Models\BusinessCustomer;
use App\Models\Redeem;
use App\Models\RedeemDetail;
use App\Models\Template;
use App\Models\BusinessDetail;
use App\Models\Userplan;
use App\Models\Business;
use App\Models\User;
use App\Models\Target;
use App\Models\OfferTemplate;
use App\Models\GalleryImage;
use App\Models\ShortLink;
use App\Models\WhatsappSession;
use App\Models\BusinessTemplate;

use Carbon\Carbon;
use Image;
use Auth;
use File;
use URL;
use Datatables;
use Session;
use DB;
use Redirect;
use Storage;

class FutureOfferController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(Request $request)
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.

        $user_id = Auth::id();      

        /*mark expired offers*/
        CommonSettingController::expiredOffers();
        $get_default_off = Offer::where('user_id',Auth::id())->where('is_default','1')->first();
        if($get_default_off == null){
            $live_offer = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->first();
            if($live_offer != null){
                $live_offer->is_default = '1';
                $live_offer->save();
            }
        }
        
        
        $domain = URL::to('/');
        $request_data = $request->all();

        Session()->forget('last_offer_id');

        $checkBusiness = $this->checkBusinessDetails();
        if($checkBusiness['status'] == false){
            return redirect()->route('business.settings');
        }

        $offer_type=$request->offer_type ?? 'all';
        if($offer_type == "publish"){
            $find = "status";
        }else{
            $find = "is_draft";
        }

        $type = 'future';
        $current_date = date("Y-m-d");

        $search = $request->search;
        if($search != ''){
            if ($offer_type === 'all') {
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->latest()->paginate(20);
            }elseif ($offer_type === 'expired') {
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->where('end_date','<',$current_date)->latest()->paginate(20);
            }else{
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->where($find,1)->latest()->paginate(20);
            }
        }else{
            if ($offer_type === 'all') {
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('user_id',$user_id)->latest()->paginate(20);
            }elseif ($offer_type === 'expired') {
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('user_id',$user_id)->where('end_date','<',$current_date)->latest()->paginate(20);
            }else{
                $records = Offer::with('subscription','future_offer','offer_template')->withCount('users')->where('type',$type)->where('sub_type',$request->type)->where('user_id',$user_id)->where($find,1)->latest()->paginate(20);
            }
        }
        
        foreach ($records as $k_record => $v_record) {
            $total_visits = 0;
            foreach ($v_record->subscription as $key => $val) {
                $total_visits = $total_visits + count($val->achived_target);
            }
            $records[$k_record]['total_visits'] = $total_visits;
        }

        $all=Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('sub_type',$request->type)->count();
        $published=Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('sub_type',$request->type)->where('status',1)->count();
        $draft=Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('sub_type',$request->type)->where('is_draft',1)->count();
        $expired = Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('sub_type',$request->type)->where('end_date','<',$current_date)->count();

        //business details
        $bussiness_detail = BusinessDetail::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();


        /*whatsapp login check*/
        $whatsappSession = WhatsappSession::where('user_id', Auth::user()->id)
        ->where('instance_id', '<>', null)
        ->where('instance_id', '<>', '')
        ->orderBy('id', 'desc')
        ->first();

        if(isset($whatsappSession->wa_number)){
            $wa_number = substr($whatsappSession->wa_number, 2);
        }else{
            $wa_number = '';
        }
        

        // dd($whatsappSession);
        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }
        
        $purchaseHistory = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','share_rewards')->where('userplans.user_id',Auth::id())->count();

        //set pagination URL
        $records->withPath($domain.'/business/offers/future?type='.$request->type);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $businessSettings = CommonSettingController::businessSettings();

        return view('business.offers.future.index', compact(['request_data','records','current_date','search','offer_type','all','published','draft','expired','bussiness_detail','notification_list','planData','businessSettings','wa_number','current_plan_id','rest_plan_id','purchaseHistory']));
    }

    public function checkBusinessDetails(){
        $business_id = Auth::user()->id;
        $business = BusinessDetail::where('user_id',$business_id)->select('*')->orderBy('id', 'desc')->first();
        if($business != null){
            if($business->business_name != null &&  $business->state != null && $business->city != null && $business->pincode != null && $business->address_line_1 != null){
                return ['status' => true];
            }else{
                return ['status' => false];
            }
        }else{
            return ['status' => false];
        }
    }

    public function create(Request $request){
        $states = State::where('status', 1)->get(['name','id']);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.future.create', compact(['states','location','notification_list','planData']));
    }

    public function show(Request $request, $id){
        $request_data = $request->all();
        $offer = Offer::with('subscription')->withCount('users')->with('future_offer')->findorFail($id);

        $total_visits = 0;
        foreach ($offer->subscription as $key => $val) {
            $total_visits = $total_visits + count($val->achived_target);
        }
        $offer->total_visits = $total_visits;

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        if($offer->future_offer->promotion_url == ''){
            $template = OfferTemplate::where('offer_id',$offer->id)->orderBy('id','desc')->first();
            $previewOffer = "business/offer-preview/".$offer->id."/".$template->slug;

            return view(
                'business.offers.future.view',
                compact(
                    'offer',
                    'previewOffer',
                    'notification_list',
                    'planData',
                    'request_data',
                    'current_plan_id',
                    'rest_plan_id'
                )
            );
        }else{
            return view(
                'business.offers.future.view',
                compact(
                    'offer',
                    'notification_list',
                    'planData',
                    'request_data',
                    'current_plan_id',
                    'rest_plan_id'
                )
            );
        }
        
    }

    public function setDefault(Request $request, $offer_id){
        $setDefault = Offer::find($offer_id);
        if($setDefault->is_default == "1"){
            return response()->json(["status" => true, "message" => "Offer set as default."]);
        }

        if($setDefault->is_draft == 1){
            return response()->json(["status" => false, "message" => "Offer is not published yet."]);
        }

        $current_date = date('Y-m-d');
        if($current_date > $setDefault->end_date){
            return response()->json(["status" => false, "message" => "Offer is already expired."]);
        }

        $offers = Offer::where('user_id',Auth::user()->id)->where('is_default', '1')->pluck('id')->toArray();
        
        if(!empty($offers)){
            foreach ($offers as $key => $v_offer_id) {
                $offer = Offer::find($v_offer_id);
                $offer->is_default = '0';
                $offer->save();
            }
        }
        
        $setDefault->is_default = '1';
        $setDefault->save();

        return response()->json(["status" => true, "message" => "Offer set as default."]);
        
    }

    public function offerSuccess($offerId){
        $offer = Offer::with('future_offer')->findorFail($offerId);
        if($offer->future_offer->template_type == 'square'){
            $templates = Template::where('status',1)->get();
        }else{
            $templates = Template::where('type', $offer->future_offer->template_type)->where('status',1)->get();
        }
        
        $businesses = Business::all();
        
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.future.success', compact(['offer', 'templates','businesses','notification_list','planData']));
    }

    public function destroy(Request $request){
        //
    }

    /*public function uploadImage($request){

        if($request->hasFile('offer_banner'))
        {
            $image = $request->file('offer_banner');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize(); 

            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){
                $height = Image::make($image)->height();
                $width = Image::make($image)->width();

                if($size <= 2097152){

                    $image = $request->file('offer_banner');
                    $extension = $image->getClientOriginalExtension();
                    $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;
                    $destinationPath = base_path('../assets/offers/banners/');
                    if(!File::isDirectory($destinationPath)){
                        File::makeDirectory($destinationPath, 0777, true, true);
                    }
                    $image_resize = Image::make($image->getRealPath());
                    //$image_resize->resize(1440,720);
                    $image_resize->save($destinationPath. $fileName);

                    return ['status'=>true, 'file' => $fileName, 'height' => $height, 'width' => $width];

                }else{
                    return ['status'=>false, 'message'=> 'Offer Image size must be smaller than 2MB or equal.'];
                }

            }else{
                return ['status'=>false, 'message'=> 'Offer Image File must be an image (jpg, jpeg or png).'];
            }

        }else{
            return ['status'=>false, 'message'=> 'Please select an Offer Image.'];
        }
    }*/


    public function getCities(Request $request){
        $cities = City::where('state_id', $request->state_id)->where('status', 1)->get(['name', 'id']);
        if($cities != null){
            return ['status'=>true, 'cities' => $cities];
        }else{
            return ['status'=>false, 'cities' => []];
        }
    }

    public function shareToCustomer(Request $request, $offer_id){

        $offer = Offer::where('id', $offer_id)->orderBy('id', 'desc')->first();
        $current_date = date('Y-m-d');
        $domain = URL::to('/');
        
        if($offer->is_draft == 1){
            return response()->json(["success" => false, "message" => "Offer is not published yet."]);
        }

        if($offer->start_date->format('Y-m-d') > $current_date){
            return response()->json(["success" => false, "message" => "Offer is not started yet."]);
        }

        if($offer == null){
            return response()->json(["success" => false, "message" => "Offer not found."]);
        }elseif ($offer->end_date < $current_date) {
            return response()->json(["success" => false, "message" => "Offer is expired."]);
        }else{
            $business_id = $created_by = Auth::user()->id;

            /*whatsapp login check*/
            $whatsappSession = WhatsappSession::where('user_id', $business_id)->orderBy('id', 'desc')->first();
            if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
                return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
            }

            //get customer or create if not exist
            $customer = $this->getCustomer($request, $created_by, $business_id);
            if(isset($customer->customer_id)){
                $customer_id = $customer->customer_id;
            }else{
                $customer_id = $customer->id;
            }               

            $offerData = OfferFuture::where('offer_id',$offer->id)->orderBy('id', 'desc')->first();
            if($offerData->promotion_url == null){
                $type = 'template';
            }else{
                $type = 'website';
            }

            //get subscription or create if not exist
            $OfferSubscription = $this->getSubscription($offer_id, $customer_id, $created_by,$type,$offerData->promotion_url);
            if($OfferSubscription['status'] == false){
                return response()->json(["success" => false, "message" => $OfferSubscription['message']]);
            }

            if($type == 'template'){
                //template
                $offerTemplate = OfferTemplate::where('offer_id',$offer_id)->orderBy('id','desc')->first();
                $img = $domain."/assets/offer-thumbnails/".$offerTemplate->thumbnail;
            }else{
                $img = asset('system/public/assets/business/Website-offer-thumb-'.$OfferSubscription['data']->user_id.'.jpg');
            }

            //share link code here
            $url = "https://waba.360dialog.io/v1/messages";
            $method = "POST";
            
            $code = $OfferSubscription['shortcode']->uuid;
            $phoneNumber = '91'.$request->number;
            
            /*  Check message limit */
            $data = CommonSettingController::checkSendFlag($business_id,4);
            if($offer->sub_type != 'MadeShare'){
                if(!$data['sendFlag']){
                    return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
                }
            }

            if($offer->sub_type == 'PerClick'){
                $payload = WhatsAppMsgController::cashPerClickSubscription($code);
            }elseif($offer->sub_type == 'Percentage'){
                $payload = WhatsAppMsgController::percentageDiscountSubscription($code);
            }elseif($offer->sub_type == 'Fixed'){
                $payload = WhatsAppMsgController::fixedAmountSubscription($code);
            }elseif($offer->sub_type == 'MadeShare'){
                $payload = WhatsAppMsgController::MadeShareSubscription($code);
            }


            if($offer->sub_type == 'MadeShare'){
                $wpa_res = CommonMessageController::sendMessage($phoneNumber, $payload);
            }else{
                $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload);
            }
            
            $res = json_decode($wpa_res);
            // dd($wpa_res);
    
            if($res != '' && $res->status == 'success'){
                $subscrData = OfferSubscription::find($OfferSubscription['data']->id);
                $subscrData->link_shared = "1";
                $subscrData->save();
            }else{
                OfferSubscription::destroy($OfferSubscription['data']->id);
                return response()->json(["success" => false, "message" => "Something went wrong. Please try again."]);
            }

            if(isset($OfferSubscription['data']->share_link)){
                $share_link = $domain.$OfferSubscription['data']->share_link;
            }else{
                $share_link = $domain;
            }

            if($offer->sub_type != 'MadeShare'){
                //
            }

            return response()->json(["success" => true, "message" => "Offer shared successfully.", "share_link" => $share_link]);
        }
    }


    public function getCustomer($request, $created_by, $business_id){

        $checkWithBusiness = Customer::with('businesses')
                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                ->where('customers.mobile',$request->number)
                ->where('business_customers.business_id',Auth::id())
                ->orderBy('customers.id', 'desc')
                ->first();

        if($checkWithBusiness != null){
            //return $checkWithBusiness;
        }

        $customer = Customer::where('mobile',$request->number)->orderBy('id', 'desc')->first();
        if($customer == null){
            $customer= new Customer;
            $customer->mobile = $request->number;
            $customer->user_id = $created_by;
            $customer->created_by = $created_by;
            $customer->save();

            $customer->uuid = $customer->id.'CUST'.date("Ymd");
            $customer->save();

            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->business_id = $business_id;
            $business_customer->name = $request->customerName;
            $business_customer->dob = $request->customerDOB;
            $business_customer->anniversary_date = $request->customerADate;
            $business_customer->save();
        }else{
            
            $businessCustomer = BusinessCustomer::where('business_id',Auth::id())->where('customer_id',$customer->id)->orderBy('id', 'desc')->first();

            if($businessCustomer != null){
                $business_customer = BusinessCustomer::find($businessCustomer->id);
            }else{
                $business_customer = new BusinessCustomer;
            }  
            $business_customer->customer_id = $customer->id;
            $business_customer->business_id = $business_id;
            $business_customer->name = $request->customerName;
            $business_customer->dob = $request->customerDOB;
            $business_customer->anniversary_date = $request->customerADate;
            $business_customer->save();
        }

        return $customer;
    }

    public function getSubscription($offer_id, $customer_id, $created_by,$offer_type,$url){

        $subscription = OfferSubscription::where('offer_id', $offer_id)->where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        $domain = URL::to('/');

        if($subscription != null){
            $redeem = Redeem::where('offer_subscribe_id',$subscription->id)->orderBy('id', 'desc')->first();
        }else{
            $redeem = null;
        }
        

        if(($subscription != null && $redeem == null) || ($redeem != null && $redeem->is_redeemed == 0)){

            return ['status' => false, 'message' => 'Already subscribed to the offer.', 'data' => $subscription, 'shortcode' => ''];
        }else{
            $type = 'future';
            $randomString = UuidTokenController::eightCharacterUniqueToken(8);
            $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
            $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
           
            if($tokenData['status'] == true){
                $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
            }

            $offer = Offer::with('future_offer')->where('id',$offer_id)->orderBy('id', 'desc')->first();

            $url = rtrim($url,"/");

            if($redeem != null && $redeem->is_redeemed == 1){
                $share_link = $subscription->share_link;
                $uuid_code = $subscription->uuid;
            }else{
                if($offer_type == 'template'){
                    $share_link = '/f/'.$offer->uuid.'?share_cnf='.$tokenData['token'];
                }else{
                    $share_link = $url.'/?o='.$offer->uuid.'&share_cnf='.$tokenData['token'];
                }
                $uuid_code = $tokenData['token'];
            }

            $checkPendingClicks = $this->checkPendingClicks($created_by,$customer_id);
            if($checkPendingClicks['status'] == true){  
                $parent_id = $checkPendingClicks['data']->id;
            }else{
                $parent_id = '';
            }

            $subscription = new OfferSubscription;
            $subscription->user_id = Auth::id();
            $subscription->offer_id = $offer_id;
            $subscription->customer_id = $customer_id;
            $subscription->parent_id = $parent_id;
            $subscription->created_by = $created_by;
            $subscription->uuid = $uuid_code;
            $subscription->share_link = $share_link;
            $subscription->target = $offer->future_offer->share_target;
            $subscription->save();
            
            //API call to get shortlink         
            if($offer_type == 'website'){
                $long_link = $share_link;
            }else{
                $long_link = $domain.$share_link;
            }
                  
            $postData = array(
                'opnlkey' => env('SHORTNER_API_KEY'),
                'secret' => env('SHORTNER_SECRET_KEY'),
                'long_link' => $long_link
            );

            /*$postData = array(
                'opnlkey' => 'ol-PFAb3O0wGo2hHnQY',
                'secret' => 'mEFgF1niz9L6PGuOgaeCet3CgjJ6X4DrpT4T6U3v',
                'long_link' => $domain.$share_link,
            );*/

            //API URL
            $url="https://opnl.in/api/v1/opnl-short-link";

            //init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData
                //,CURLOPT_FOLLOWLOCATION => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //Get response
            $response = curl_exec($ch);
            $output = json_decode($response);
            curl_close($ch);

            if($output->status == true){
                $uriSegments = explode("/", parse_url($output->link, PHP_URL_PATH));
                $link_uuid = array_pop($uriSegments);

                $shortLink = new ShortLink;
                $shortLink->uuid = $link_uuid;
                $shortLink->link = $long_link;
                $shortLink->save();

                $subscription->short_link_id = $shortLink->id;
                $subscription->save();

                return ['status' => true, 'message' => 'Offer subscribed successfully.', 'data' => $subscription, 'shortcode' => $shortLink];
            }else{
                OfferSubscription::destroy($subscription->id);
                return ['status' => false, 'message' => 'Offer not subscribed.', 'data' => '', 'shortcode' => ''];
            }
        }
    }

    public function checkPendingClicks($business_id,$customer_id){
        $incomplete = OfferSubscription::where('created_by',$business_id)->where('customer_id',$customer_id)->where('status','3')->orderBy('id','desc')->first();
        if($incomplete != null){
            return ['status' => true, 'data' => $incomplete];
        }else{
            return ['status' => false, 'data' => ''];
        }
    }

    public function redeemOffer(Request $request, $offer_id){
        
        $offerIds = Offer::where('user_id',Auth::id())->pluck('id')->toArray();

        $offer = Offer::with('future_offer')->where('id', $offer_id)->orderBy('id', 'desc')->first();
        if($offer == null){
            return response()->json(["success" => false, "message" => "Offer not found."]);
        }else{

            $redeem = Redeem::where('code',$request->code)->orderBy('id', 'desc')->first();
            if($redeem == null){
                return response()->json(["success" => false, "message" => "Coupon is invalid."]);
            }else{
                $todays_date = date("Y-m-d");
                if($todays_date > $offer->redeem_date){
                    return response()->json(["success" => false, "message" => "Coupon has Expired."]);
                }

                $subscription = OfferSubscription::where('id', $redeem->offer_subscribe_id)->orderBy('id', 'desc')->first();
                if(($subscription == null) || ($subscription->offer_id != $offer_id)){
                    return response()->json(["success" => false, "message" => "Coupon is invalid."]);
                }else{
                    return $this->verifyCoupon($redeem, $offer);
                }
            }
        }
    }

    public function verifyCoupon($redeem, $offer){
        if($redeem->is_redeemed != 0){
            return response()->json(["success" => false, "message" => "Offer is already redeemed."]);
        }else{
            $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();
            if($subscription->parent_id != ''){
              $targets = Target::whereIn('offer_subscribe_id',[$subscription->id, $subscription->parent_id])->where('repeated',0)->count();
            }else{
              $targets = Target::where('offer_subscribe_id',$redeem->offer_subscribe_id)->where('repeated',0)->count();
            }

            $data = ['offer' => $offer, 'redeem_id' => $redeem->id, 'targets' => $targets];
            return response()->json(["success" => true, 'data' => $data, "message" => "Coupon is valid. Please Proceed Payment."]);
        }
    }

    public function proceedRedeem(Request $request, $redeem_id){
        
        $data = $request->data;
        if(!empty($data)){
            
            $redeem = Redeem::where('id', $redeem_id)->orderBy('id', 'desc')->first();

            if($redeem){

                $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();

                //get achieved unique clicks count
                $clicks = Target::where('offer_subscribe_id',$redeem->offer_subscribe_id)->where('repeated',0)->orderBy('id','desc')->count();

                $invoice_no = $this->getInvoiceNo($data['offer_id']);
                if($data['invoice'] == ''){
                    $redeem_invoice_no = $invoice_no;
                }else{
                    $redeem_invoice_no = $data['invoice'];
                }

                $redeem_detail  =  RedeemDetail::Create([
                                    'offer_id' => $data['offer_id'],
                                    'offer_subscribe_id' => $redeem->offer_subscribe_id,
                                    'redeem_id' => $redeem_id,  
                                    'redeem_invoice_no' => $redeem_invoice_no,
                                    'invoice_no' => $invoice_no,
                                    'no_of_clicks' => $clicks,
                                    'actual_amount' => $data['actualAmount'],
                                    'discount_type' => $data['discount_type'],
                                    'discount_value' => $data['discount_value'],
                                    'redeem_amount' => $data['redeem_amount'],
                                    'calculated_amount' => $data['calculated_amount'],
                                ]);


                if(!$redeem_detail){
                    return response()->json(["success" => false, 'data' => [], "message" => "Saving redeem details failed."]);
                }



                /*whatsapp login check*/
                $whatsappSession = WhatsappSession::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
                if($whatsappSession == '' || (isset($whatsappSession->instance_id) && $whatsappSession->instance_id == '')){
                    return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
                }

                /* Message Limit Check */
                $message_data = CommonSettingController::checkSendFlag(Auth::id(),4);
                if(!$message_data['sendFlag']){
                    return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
                }

                $msg = '';
                $businessDetail = BusinessDetail::where("user_id",Auth::id())->orderBy('id','desc')->first();
                if($businessDetail != ''){
                    $msg = $businessDetail->business_msg;
                }

                /* Send Redeem Details on Whatsapp */
                $customer = Customer::where('id',$subscription->customer_id)->orderBy('id','desc')->first();
                $phoneNumber = '91'.$customer->mobile;

                $payload = WhatsAppMsgController::afterRedeemedMsg($data['discount_type'], ucfirst($businessDetail->business_name), $msg, $data['actualAmount'], $data['discount_value'], ($data['actualAmount'] - $data['redeem_amount']), $data['redeem_amount']);
                $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload);
                $res = json_decode($wpa_res);

                if($res != '' && $res->status == 'success'){
                    //
                }else{
                    return response()->json(["success" => false, "message" => "Redeem invoice failed to send on Whatsapp."]);
                }

                
                $redeem->is_redeemed = 1;
                if($redeem->save()){

                    //cashback offer
                    $offerFuture = OfferFuture::where('offer_id',$data['offer_id'])->first();
                    if(($offerFuture != null) && ($offerFuture->max_promo_count != '')){

                        $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->first();
                        $subscription->code_sent = '0';
                        $subscription->save();
                        
                        /*Update max clicks*/
                        $total_clicks = Target::where('offer_subscribe_id', '=', $redeem->offer_subscribe_id)->count();
                        $offerFuture->pending_clicks = $offerFuture->max_promo_count - $total_clicks;
                        $offerFuture->save();

                        /*Update previous clicks*/
                        Target::where('offer_subscribe_id', '=', $redeem->offer_subscribe_id)
                        ->update(['repeated' => 1]);
                    }


                    return response()->json(["success" => true, 'data' => $redeem_detail, "message" => "Redeemed Successfully."]);
                }
            }else{
                return response()->json(["success" => false, 'data' => [], "message" => "Redeeem Failed."]);
            }
        }else{
            return response()->json(["success" => false, 'data' => [], "message" => "Something went wrong."]);
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

    //template builder
    public function createWithTemplate(Request $request){
        $request_data = $request->all();
        Session(['type' => 'template']);
        Session()->forget(['template_data','images']);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $businesses = Business::all();

        /*Plan*/
        $todays_date = date('Y-m-d');
        $userPlan = Userplan::where('user_id',Auth::id())->where('will_expire_on','>=',$todays_date)->whereIn('feature_id', [3,4,5,6,7,8])->first();
        
        if($userPlan == null){
            $templates = Template::where('status',1)->orderBy('id','asc')->limit(5)->get();
        }else{
            if(isset($request_data['business_type_id']) && isset($request_data['template_type_id'])){
                $template_ids = BusinessTemplate::where('business_id',$request_data['business_type_id'])->pluck('template_id')->toArray();

                $templates = Template::where('status',1)->whereIn('id',$template_ids)->where('template_type',$request_data['template_type_id'])->orderBy('id','asc')->paginate(9);

            }else if(isset($request_data['business_type_id']) && !isset($request_data['template_type_id'])){
                $template_ids = BusinessTemplate::where('business_id',$request_data['business_type_id'])->pluck('template_id')->toArray();

                $templates = Template::where('status',1)->whereIn('id',$template_ids)->orderBy('id','asc')->paginate(9);

            }else if(!isset($request_data['business_type_id']) && isset($request_data['template_type_id'])){

                $templates = Template::where('status',1)->where('template_type',$request_data['template_type_id'])->orderBy('id','asc')->paginate(9);

            }else{
                $templates = Template::where('status',1)->orderBy('id','asc')->paginate(9);
            }
        }
        //dd($templates);
        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('business.offers.future.template', compact('templates','businesses','notification_list','planData','request_data','userPlan','current_plan_id','rest_plan_id'));
    }

    //webpage
    public function createWithWebpage(Request $request){
        $request_data = $request->all();
        Session(['type'=> 'webpage']);
        $page_type = 'webpage';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('business.offers.future.offer-details',compact('page_type','notification_list','planData','request_data','current_plan_id','rest_plan_id'));
    }

    public function builder(Request $request, $id){
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.

        $request_data = $request->all();
        $video_id = '';
        $business = BusinessDetail::where('user_id',Auth::id())->orderBy('id','desc')->first();
        $template = Template::with('gallery')->where('id',$id)->orderBy('id','desc')->first();

        if(Session('template_data')){
            $template_data = Session('template_data');
            $gallery = array();

            if(Session('images')){
                $images = Session('images');

                if(isset($template->gallery) && !empty($template->gallery)){

                    $g = 0;
                    for ($i=1; $i <= count($template->gallery); $i++) { 
                        $template->gallery[$gallery_key]->title = isset($template_data['image_title_'.$g]) ? $template_data['image_title_'.$g] : '';

                        $template->gallery[$gallery_key]->title_color = isset($template_data['image_'.$g.'_color']) ? $template_data['image_'.$g.'_color'] : '';

                        $template->gallery[$gallery_key]->image_path = isset($images['image_'.$g]) ? $images['image_'.$g] : $gallery_img->image_path;

                        $g++;
                    }
                }
            }

            $template->thumbnail = isset($template_data['thumbnail']) ? $template_data['thumbnail'] : $template->thumbnail;
            $template->bg_image = isset($images['background_image']) ? $images['background_image'] : $template->bg_image;
            $template->bg_color = isset($template_data['background_color']) ? $template_data['background_color'] : $template->bg_color;
            $template->default_color = isset($template_data['default_color']) ? $template_data['default_color'] : $template->default_color;
            $template->business_name_color = isset($template_data['business_name_color']) ? $template_data['business_name_color'] : $template->business_name_color;
            $template->tag_line_color = isset($template_data['tag_line_color']) ? $template_data['tag_line_color'] : $template->tag_line_color;
            $template->hero_image = isset($images['main_image']) ? $images['main_image'] : $template->hero_image;
            $template->hero_title = isset($template_data['heading']) ? $template_data['heading'] : $template->hero_title;
            $template->hero_title_color = isset($template_data['heading_color']) ? $template_data['heading_color'] : $template->hero_title_color;
            $template->hero_text = isset($template_data['text']) ? $template_data['text'] : $template->hero_text;
            $template->hero_text_color = isset($template_data['text_color']) ? $template_data['text_color'] : $template->hero_text_color;
            $template->video_url = isset($template_data['video_url']) ? $template_data['video_url'] : $template->video_url;
            $template->video_autoplay = isset($template_data['video_autoplay']) ? $template_data['video_autoplay'] : $template->video_autoplay;

            
            $template->extra_heading_1 = isset($template_data['extra_heading_1']) ? $template_data['extra_heading_1'] : $template->extra_heading_1;
            $template->extra_heading_1_color = isset($template_data['extra_heading_1_color']) ? $template_data['extra_heading_1_color'] : $template->extra_heading_1_color;
            $template->extra_text_1 = isset($template_data['extra_text_1']) ? $template_data['extra_text_1'] : $template->extra_text_1;
            $template->extra_text_1_color = isset($template_data['extra_text_1_color']) ? $template_data['extra_text_1_color'] : $template->extra_text_1_color;
            

            $template->contact_icons = json_encode(['contact_icon_color' => $template_data['contact_icon_color'], 'whatsapp_icon_color' => $template_data['whatsapp_icon_color'], 'location_icon_color' => $template_data['location_icon_color'], 'website_icon_color' => $template_data['website_icon_color']]);
        }

        $template->contact_icons = json_decode($template->contact_icons);
        if($template->video_url != null){
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode("/", parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            }else{
                $video_params = explode("?v=", $template->video_url);
                $video_id = $video_params[1];
            }
        }


        $g = $t = 1;
        $gallery_color_titles = $tag_bg_colors = array();
        foreach($template->gallery as $key => $gallery){
            //Image Title Color
            if(isset($gallery->title_color) && $gallery->title_color != ''){
                $gallery_color_titles[$g] = $gallery->title_color;
            }else{
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if(isset($gallery->tag_bg_color) && $gallery->tag_bg_color != ''){
                $tag_bg_colors[$t] = $gallery->tag_bg_color;
            }else{
                $tag_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }

        //Session()->forget(['template_data','images']);

        $offer_id = '';
        $action = route('business.enterOfferDetails','type='.$request_data['type']);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('builder.t-build', compact('id','business','template','offer_id','video_id','action','notification_list','planData','request_data','current_plan_id','rest_plan_id','gallery_color_titles','tag_bg_colors'));
    }

    public function viewTemplate($id){

        $is_posted = InstantTask::where('user_id', Auth::id())->where('offer_id', $id)->whereNull('deleted_at')->count();

        $template = Template::with('gallery')->where('id',$id)->orderBy('id','desc')->first();
        $template->contact_icons = json_decode($template->contact_icons);

        $business = BusinessDetail::where('user_id',Auth::id())->orderBy('id','desc')->first();
        $only_view = 1;
        $show_meta = 0;

        $video_id = '';
        if($template->video_url != null){
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode("/", parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            }else{
                $video_params = explode("?v=", $template->video_url);
                $video_id = $video_params[1];
            }
        }

        $g = $t = 1;
        $gallery_color_titles = $tag_bg_colors = array();
        foreach($template->gallery as $key => $gallery){
            //Image Title Color
            if(isset($gallery->title_color) && $gallery->title_color != ''){
                $gallery_color_titles[$g] = $gallery->title_color;
            }else{
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if(isset($gallery->tag_bg_color) && $gallery->tag_bg_color != ''){
                $tag_bg_colors[$t] = $gallery->tag_bg_color;
            }else{
                $tag_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }
        //dd($template);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('builder.preview', compact('id','template', 'business','only_view','show_meta','video_id','notification_list','planData','gallery_color_titles','tag_bg_colors','is_posted'));
    }

    public function previewTemplate($offer_id,$id){
        $is_posted = InstantTask::where('user_id', Auth::id())->where('offer_id', $offer_id)->whereNull('deleted_at')->count();

        $offer = Offer::with('future_offer')->where('id', $offer_id)->orderBy('id','desc')->first();
        $show_meta = 1;

        $template = OfferTemplate::with('gallery')->where('offer_id',$offer_id)->orderBy('id','desc')->first();

        $template->social_links = json_decode($template->social_links);
        $template->contact_icons = json_decode($template->contact_icons);
        //\dd($template);
        $video_id = '';
        if($template->video_url != null){
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode("/", parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            }else{
                $video_params = explode("?v=", $template->video_url);
                $video_id = $video_params[1];
            }
        }

        $business = BusinessDetail::where('user_id',Auth::id())->orderBy('id','desc')->first();
        $only_view = 0;

        $g = $t = 1;
        $gallery_color_titles = $tag_bg_colors = array();
        foreach($template->gallery as $key => $gallery){
            //Image Title Color
            if(isset($gallery->title_color) && $gallery->title_color != ''){
                $gallery_color_titles[$g] = $gallery->title_color;
            }else{
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if(isset($gallery->tag_bg_color) && $gallery->tag_bg_color != ''){
                $tag_bg_colors[$t] = $gallery->tag_bg_color;
            }else{
                $tag_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('builder.preview', compact('id','template', 'business','only_view','show_meta','offer','video_id','notification_list','planData','gallery_color_titles','tag_bg_colors','is_posted'));
    }

    public function enterOfferDetails(Request $request){
        $request_data = $request->all();
        
        $images = array();
        if($request->background_image || $request->main_image || $request->image_1 || $request->image_2 || $request->image_3){
            $images = $this->uploadOfferImage($request);
        }
        
        $data = $request->except('_token','background_image','main_image','image_1','image_2','image_3');
        Session(['template_data'=> $data, 'images' => $images]);
        
        $page_type = Session('type');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.future.offer-details',compact('page_type','notification_list','planData','request_data'));
    }

    public function scriptPage($offer_id){
        $offer = Offer::with('future_offer')->findorFail($offer_id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.future.scripts', compact('offer','notification_list','planData'));
    }

    public function store(Request $request){

        $user_id = Auth::user()->id;

        if($request->discount_type == 'MadeShare'){
            $validate = $this->validateCreateMadeShareOffer($request);
        }else{
            $validate = $this->validateCreateOffer($request);
        }
        
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message']]
                );
        }

        if($request->is_draft == 1){
            $status = 0;
            $draftOffer = Offer::where('is_draft',1)->where('user_id',$user_id)->count();
            if($draftOffer > 50){
                return response()->json(
                        ['status'=> false,'message'=> "Draft offer limit is exceeded."]
                    );
            }
        }else{
            $status = 1;
            $activeOffer = Offer::where('status',1)->where('user_id',$user_id)->count();
            if($activeOffer > 50){
                return response()->json(
                        ['status'=> false,'message'=> "Active offer limit is exceeded."]
                    );
            }
        }

        if(Session('last_offer_id')){
            $last_offer_id = Session('last_offer_id');
            $offer = Offer::where('id',$last_offer_id)->orderBy('id','desc')->first();
        }else{
            $offer = new Offer;
        }

        if($request->discount_type == 'MadeShare'){
            $start_date = date("Y-m-d");
            $end_date = date('Y-m-d', strtotime('+100 years'));
            $redeem_date = date('Y-m-d', strtotime('+100 years'));
        }else{
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $redeem_date = $request->redeem_date;
        }

        
        $offer->title = $request->title;
        $offer->user_id = $user_id;
        $offer->type = 'future';
        $offer->sub_type = $request->discount_type;
        $offer->start_date = $start_date;
        $offer->end_date = $end_date;
        $offer->redeem_date = $redeem_date;
        $offer->status = $status;
        $offer->is_draft = $request->is_draft;
        $offer->save();

        if($offer != null){
            $offerId = Offer::find($offer->id);
            $offerId->uuid = 'SHR'.$user_id.'F'.$offer->id;
            $offerId->save();

            if($request->discount_type == 'Fixed'){
                $discount_value = $request->discount_amount;
            }elseif($request->discount_type == 'Percentage'){
                $discount_value = $request->discount_percent;
            }else{
                $discount_value = $request->discount_perclick;
            }

            if($request->promo_url != ''){
                $promo_url = rtrim($request->promo_url,"/");
            }else{
                $promo_url = '';
            }

            if(Session('last_offer_id')){
                $last_offer_id = Session('last_offer_id');
                $offer_detail = OfferFuture::where('offer_id',$last_offer_id)->orderBy('id','desc')->first();
            }else{
                $offer_detail = new OfferFuture;
            }
            
            $offer_detail->offer_id = $offer->id;
            $offer_detail->share_target = $request->promo_count;
            $offer_detail->max_promo_count = $request->max_promo_count;
            $offer_detail->pending_clicks = $request->max_promo_count;
            $offer_detail->minimum_click = $request->minimum_click;
            $offer_detail->offer_description = $request->offer_description;
            $offer_detail->discount_type = $request->discount_type;
            $offer_detail->discount_value = round($discount_value, 2);
            $offer_detail->promotion_url = $promo_url;
            $offer_detail->save();

            $offer_type = Session('type');

            if($offer_type == 'template'){
                if(Session('last_offer_id')){
                    $saveTemplate = $this->saveTemplate($request,$offer->id,'OfferTemplate');
                }else{
                    $saveTemplate = $this->saveTemplate($request,$offer->id,'');
                }
                
            }
        }

        /*Set Default*/
        $offers_count = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->count();
        if($offers_count == 1){
            $current_off = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->first();
            $current_off->is_default = '1';
            $current_off->save();
        }

        //save offer id to prevent repeat offer creation
        Session(['last_offer_id' => $offer->id]);

        if($offer_type == 'template'){
            $redirect_url = route('business.future.index','type='.$request->discount_type);

            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Offer Created Successfully!',
                    'redirect_url' => $redirect_url,
                    'type' => 'template'
                ]
            );
        }else{
            $redirect_url = route('business.scriptPage',$offer->id);
            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Offer Created Successfully!',
                    'redirect_url' => $redirect_url,
                    'type' => 'webpage'
                ]
            );
        } 

    }

    public function uploadOfferImage($request){

        $image_types = ['background_image','main_image','image_1','image_2','image_3'];
        $images = array();
        
        foreach($image_types as $image_file){

            if($request->hasFile($image_file))
            {
                $image = $request->file($image_file);
                $extension = $image->getClientOriginalExtension();
                $size = $image->getSize(); 

                $data = $request->all();

                $extension = strtolower($extension);
                if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'png'){

                    $folderPath = base_path('../assets/templates/'.$request->template_id.'/');
                    $image_parts = explode(";base64,", $data['string_'.$image_file]);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    $fileName = $image_file.'-'.date('dmYhis',time()) . '.jpg';
                    $file = $folderPath . $fileName;
                    file_put_contents($file, $image_base64);
                    $img = Image::make($file);
                    $img->encode('jpg', 75)->save($file);

                    $images[$image_file] = $fileName;
                    
                    //dd($img);
                    /* if($size <= 2097152){
                        $fileName = $image_file.'-'.date('dmYhis',time()) . '.' . $extension;
                        $destinationPath = base_path('../assets/templates/'.$request->template_id.'/');
                        if(!File::isDirectory($destinationPath)){
                            File::makeDirectory($destinationPath, 0777, true, true);
                        }
                        $image_resize = Image::make($image->getRealPath());

                        //$image_resize->resize(1440,720);
                        $image_resize->save($destinationPath. $fileName);

                        $images[$image_file] = $fileName;

                    }else{
                        $images[$image_file] = 'Offer Image size must be smaller than 2MB or equal.';
                    } */

                }else{
                    $images[$image_file] = 'Offer Image File must be an image (jpg, jpeg or png).';
                }
            }
        }

        return $images;

    }

    public function saveTemplate($request,$offer_id,$model_name){

        $sessionData = Session()->all();
        $images = Session('images');

        if($model_name != ''){
            $template = OfferTemplate::with('gallery')->where('offer_id',$offer_id)->orderBy('id','desc')->first();
        }else{
            $template = Template::with('gallery')->where('id',$sessionData['template_data']['template_id'])->orderBy('id','desc')->first();
        }
        
        $social_links = json_encode([
                                'facebook_link' => $sessionData['template_data']['facebook_link'],
                                'instagram_link' => $sessionData['template_data']['instagram_link'],
                                'twitter_link' => $sessionData['template_data']['twitter_link'],
                                'linkedin_link' => $sessionData['template_data']['linkedin_link'],
                                'youtube_link' => $sessionData['template_data']['youtube_link']
                            ]);

        if(array_key_exists("same_color",$sessionData['template_data'])){
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'location_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'website_icon_color' => $sessionData['template_data']['contact_icon_color'],
            ]);
        }else{
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data']['whatsapp_icon_color'],
                'location_icon_color' => $sessionData['template_data']['location_icon_color'],
                'website_icon_color' => $sessionData['template_data']['website_icon_color'],
            ]);
        }

        $saveTemplate = new OfferTemplate;
        $saveTemplate->offer_id = $offer_id;
        $saveTemplate->name = $template->name;
        $saveTemplate->slug = $template->slug;
        $saveTemplate->thumbnail = $sessionData['template_data']['thumbnail'] ?? $template->thumbnail;

        $saveTemplate->video_url = $sessionData['template_data']['video_url'] ?? $template->video_url;
        if(isset($sessionData['template_data']['video_autoplay'])){
            $saveTemplate->video_autoplay = '1' ?? $template->video_autoplay;
        }

        if($sessionData['template_data']['bg_type'] != ''){
            if($sessionData['template_data']['bg_type'] == 'image'){
                if(array_key_exists("background_image",$images)){
                    $saveTemplate->bg_image = $images['background_image'];
                }else{
                    $saveTemplate->bg_color = $template->bg_image;
                }
            }else{
                $saveTemplate->bg_color = $sessionData['template_data']['background_color'];
            }
        }else{
            $saveTemplate->bg_image = $template->bg_image;
            $saveTemplate->bg_color = $template->bg_color;
        }

        $saveTemplate->default_color = $sessionData['template_data']['default_color'] ?? $template->default_color;

        $saveTemplate->business_name_color = $sessionData['template_data']['business_name_color'] ?? $template->business_name_color;
        $saveTemplate->tag_line_color = $sessionData['template_data']['tag_line_color'] ?? $template->tag_line_color;

        $saveTemplate->hero_image = $images['main_image'] ?? $template->hero_image;
        $saveTemplate->hero_title = $sessionData['template_data']['heading'] ?? $template->hero_title;
        $saveTemplate->hero_title_color = $sessionData['template_data']['heading_color'] ?? $template->hero_title_color;
        $saveTemplate->hero_text = $sessionData['template_data']['text'] ?? $template->hero_text;
        $saveTemplate->hero_text_color = $sessionData['template_data']['text_color'] ?? $template->hero_text_color;

        $saveTemplate->extra_heading_1 = $sessionData['template_data']['extra_heading_1'] ?? $template->extra_heading_1;
        $saveTemplate->extra_heading_1_color = $sessionData['template_data']['extra_heading_1_color'] ?? $template->extra_heading_1_color;
        $saveTemplate->extra_text_1 = $sessionData['template_data']['extra_text_1'] ?? $template->extra_text_1;
        $saveTemplate->extra_text_1_color = $sessionData['template_data']['extra_text_1_color'] ?? $template->extra_text_1_color;

        $saveTemplate->social_links = $social_links;
        $saveTemplate->contact_icons = $contact_icons;
        $saveTemplate->save();

        if($saveTemplate != null){

            if(isset($template->gallery) && !empty($template->gallery)){

                $g = 0;
                for ($i=1; $i <= count($template->gallery); $i++) { 
                    $image = new GalleryImage;
                    $image->offer_template_id = $saveTemplate->id;
                    $image->title = $sessionData['template_data']['image_title_'.$i] ?? $template->gallery[$g]->title;
                    $image->title_color = $sessionData['template_data']['image_'.$i.'_color'] ?? $template->gallery[$g]->title_color;

                    $image->tag_1 = $sessionData['template_data']['gallery_tag_1_'.$i] ?? $template->gallery[$g]->tag_1;
                    $image->tag_2 = $sessionData['template_data']['gallery_tag_2_'.$i] ?? $template->gallery[$g]->tag_2;
                    $image->tag_bg_color = $sessionData['template_data']['tag_bg_'.$i.'_color'] ?? $template->gallery[$g]->tag_bg_color;
                    $image->price = $sessionData['template_data']['gallery_price_'.$i] ?? $template->gallery[$g]->price;
                    $image->sale_price = $sessionData['template_data']['gallery_sale_price_'.$i] ?? $template->gallery[$g]->sale_price;

                    if(array_key_exists("image_".$i,$images)){
                        $image->image_path = $images['image_'.$i];
                    }else{
                        $image->image_path = $template->gallery[$g]->image_path;
                    }

                    $image->save();

                    $g++;
                }
            }

            Session()->forget(['template_data','type','images']);
            return ['status' => true, 'message' => 'Template saved.'];
        }else{
            return ['status' => false, 'message' => 'Template not saved.'];
        }
            
    }

    public function edit(Request $request, $offer_id){
        $request_data = $request->all();
        $offer = Offer::with('future_offer')->where('id',$offer_id)->orderBy('id','desc')->first();
        if($offer->future_offer->promotion_url != ''){
            Session(['type' => 'webpage']);
        }else{
            Session(['type' => 'template']);
        }

        $business = BusinessDetail::where('user_id',Auth::id())->orderBy('id','desc')->first();

        $video_id = '';
        $template = OfferTemplate::with('gallery')->where('offer_id',$offer_id)->orderBy('id','desc')->first();
        $template->social_links = json_decode($template->social_links);
        $template->contact_icons = json_decode($template->contact_icons);
        if($template->video_url != null){
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode("/", parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            }else{
                $video_params = explode("?v=", $template->video_url);
                $video_id = $video_params[1];
            }
        }

        $id = $template->slug;

        $action = route('business.editOfferDetails', $offer_id.'?type='.$request_data['type']);

        Session()->forget(['template_data','images']);

        $g = $t = 1;
        $gallery_color_titles = $tag_bg_colors = array();
        foreach($template->gallery as $key => $gallery){
            //Image Title Color
            if(isset($gallery->title_color) && $gallery->title_color != ''){
                $gallery_color_titles[$g] = $gallery->title_color;
            }else{
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if(isset($gallery->tag_bg_color) && $gallery->tag_bg_color != ''){
                $tag_bg_colors[$t] = $gallery->tag_bg_color;
            }else{
                $tag_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }
        
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('builder.t-build', compact('id','offer','business','template','offer_id','video_id','action','notification_list','planData','request_data','current_plan_id','rest_plan_id','gallery_color_titles','tag_bg_colors'));
    }


    public function editOfferDetails(Request $request,$offer_id){
        $request_data = $request->all();
        $images = array();

        if($request->background_image || $request->main_image || $request->image_1 || $request->image_2 || $request->image_3){
            $images = $this->uploadOfferImage($request);
        }
        
        $data = $request->except('_token','background_image','main_image','image_1','image_2','image_3');
        Session(['template_data'=> $data, 'images' => $images]);
        
        $page_type = Session('type');

        $offer = Offer::with('future_offer')->findorFail($offer_id);
        $start_date = $offer->start_date->format('Y-m-d');
        $end_date = $offer->end_date->format('Y-m-d');
        $redeem_date = $offer->redeem_date->format('Y-m-d');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('business.offers.future.edit-offer-details',compact('page_type','offer','end_date','start_date','offer_id','notification_list','planData','request_data','redeem_date','current_plan_id','rest_plan_id'));
    }

    public function editWebpageOfferDetails(Request $request, $offer_id){
        $request_data = $request->all();
        $offer = Offer::with('future_offer')->findorFail($offer_id);
        $start_date = $offer->start_date->format('Y-m-d');
        $end_date = $offer->end_date->format('Y-m-d');
        $redeem_date = $offer->redeem_date->format('Y-m-d');
        $page_type = 'webpage';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $current_plan_id = $rest_plan_id = ['0' => 0];
        
        if($request_data['type'] != 'MadeShare'){
            $current_plan_id = ['0' => 4];
        }else{
            $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];
        }

        return view('business.offers.future.edit-offer-details',compact('page_type','offer','end_date','start_date','offer_id','notification_list','planData','request_data','redeem_date','current_plan_id','rest_plan_id'));
    }

    public function update(Request $request, $id){

        $offerData = Offer::with('future_offer')->where('id', $id)->orderBy('id', 'desc')->first();

        if($offerData->future_offer->promotion_url != ''){
            $offer_type = 'webpage';
        }else{
            $offer_type = 'template';
        }
        Session(['type'=> $offer_type]);
        
        if($request->discount_type == 'MadeShare'){
            $validate = $this->validateCreateMadeShareOffer($request);
        }else{
            $validate = $this->validateCreateOffer($request);
        }
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message']]
                );
        }

        $template_id = $offerData->future_offer->template_id;
        $offer_banner = '';

        $user_id = Auth::user()->id;

        if($request->is_draft == 1){
            $status = 0;
            $draftOffer = Offer::where('is_draft',1)->where('user_id',$user_id)->count();
            if($draftOffer > 50){
                return response()->json(
                        ['status'=> false,'message'=> "Draft offer limit is exceeded."]
                    );
            }
        }else{
            $status = 1;
            $activeOffer = Offer::where('status',1)->where('user_id',$user_id)->count();
            if($activeOffer > 50){
                return response()->json(
                        ['status'=> false,'message'=> "Active offer limit is exceeded."]
                    );
            }
        }

        $offer = Offer::where('id',$id)->orderBy('id', 'desc')->first();
        if($request->discount_type != 'MadeShare'){
            $offer->end_date = $request->end_date;
            $offer->redeem_date = $request->redeem_date;
        }

        $offer->title = $request->title;
        $offer->user_id = $user_id;
        $offer->type = 'future';
        $offer->status = $status;
        $offer->is_draft = $request->is_draft;
        $offer->save();

        if($request->discount_type == 'Fixed'){
            $discount_value = $request->discount_amount;
        }elseif($request->discount_type == 'Percentage'){
            $discount_value = $request->discount_percent;
        }else{
            $discount_value = $request->discount_perclick;
        }

        if($request->promo_url != ''){
            $promo_url = rtrim($request->promo_url,"/");
        }else{
            $promo_url = '';
        }

        $offer_detail = OfferFuture::where('offer_id', $id)->orderBy('id', 'desc')->first();
        $offer_detail->offer_id = $offer->id;

        if($status != 1){
            $offer_detail->share_target = $request->promo_count;
            $offer_detail->max_promo_count = $request->max_promo_count;
            $offer_detail->pending_clicks = $request->max_promo_count;
            $offer_detail->minimum_click = $request->minimum_click;
            $offer_detail->discount_type = $request->discount_type;
            $offer_detail->discount_value = round($discount_value, 2);
        }
        
        $offer_detail->offer_description = $request->offer_description;
        $offer_detail->promotion_url = $promo_url;
        $offer_detail->save();


        /*Set Default*/
        $offers_count = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->count();
        if($offers_count == 1){
            $current_off = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->first();
            $current_off->is_default = '1';
            $current_off->save();
        }

        if($offer_type == 'template'){
            $saveTemplate = $this->updateTemplate($request,$offer->id);
        }

        if($offer_type == 'template'){
            $redirect_url = route('business.future.index','type='.$request->discount_type);

            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Offer Updated Successfully!',
                    'redirect_url' => $redirect_url,
                    'type' => 'template'
                ]
            );
        }else{
            $redirect_url = route('business.scriptPage',$offer->id);
            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Offer Updated Successfully!',
                    'redirect_url' => $redirect_url,
                    'type' => 'webpage'
                ]
            );
        } 

    }


    public function updateTemplate($request,$offer_id){

        $saveTemplate = OfferTemplate::with('gallery')->where('offer_id',$offer_id)->orderBy('id','desc')->first();

        $sessionData = Session()->all();
        $images = Session('images');

        $social_links = json_encode([
                                'facebook_link' => $sessionData['template_data']['facebook_link'],
                                'instagram_link' => $sessionData['template_data']['instagram_link'],
                                'twitter_link' => $sessionData['template_data']['twitter_link'],
                                'linkedin_link' => $sessionData['template_data']['linkedin_link'],
                                'youtube_link' => $sessionData['template_data']['youtube_link']
                            ]);

        if(array_key_exists("same_color",$sessionData['template_data'])){
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'location_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'website_icon_color' => $sessionData['template_data']['contact_icon_color'],
            ]);
        }else{
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data']['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data']['whatsapp_icon_color'],
                'location_icon_color' => $sessionData['template_data']['location_icon_color'],
                'website_icon_color' => $sessionData['template_data']['website_icon_color'],
            ]);
        }

        $saveTemplate->thumbnail = $sessionData['template_data']['thumbnail'] ?? $saveTemplate->thumbnail;

        $saveTemplate->video_url = $sessionData['template_data']['video_url'] ?? $saveTemplate->video_url;
        if(isset($sessionData['template_data']['video_autoplay'])){
            $saveTemplate->video_autoplay = '1' ?? $template->video_autoplay;
        }
//dd($sessionData['template_data']['bg_type']);
        if($sessionData['template_data']['bg_type'] != ''){
            if($sessionData['template_data']['bg_type'] == 'image'){
                if(array_key_exists("background_image",$images)){
                    $saveTemplate->bg_image = $images['background_image'];
                }else{
                    $saveTemplate->bg_color = $saveTemplate->bg_image;
                }
            }else{
                $saveTemplate->bg_color = $sessionData['template_data']['background_color'];
            }
        }else{
            $saveTemplate->bg_image = $saveTemplate->bg_image;
            $saveTemplate->bg_color = $saveTemplate->bg_color;
        }

        $saveTemplate->default_color = $sessionData['template_data']['default_color'] ?? $saveTemplate->default_color;

        $saveTemplate->business_name_color = $sessionData['template_data']['business_name_color'] ?? $saveTemplate->business_name_color;
        $saveTemplate->tag_line_color = $sessionData['template_data']['tag_line_color'] ?? $saveTemplate->tag_line_color;

        $saveTemplate->hero_image = $images['main_image'] ?? $saveTemplate->hero_image;
        $saveTemplate->hero_title = $sessionData['template_data']['heading'] ?? $saveTemplate->hero_title;
        $saveTemplate->hero_title_color = $sessionData['template_data']['heading_color'] ?? $saveTemplate->hero_title_color;
        $saveTemplate->hero_text = $sessionData['template_data']['text'] ?? $saveTemplate->hero_text;
        $saveTemplate->hero_text_color = $sessionData['template_data']['text_color'] ?? $saveTemplate->hero_text_color;

        $saveTemplate->extra_heading_1 = $sessionData['template_data']['extra_heading_1'] ?? $saveTemplate->extra_heading_1;
        $saveTemplate->extra_heading_1_color = $sessionData['template_data']['extra_heading_1_color'] ?? $saveTemplate->extra_heading_1_color;
        $saveTemplate->extra_text_1 = $sessionData['template_data']['extra_text_1'] ?? $saveTemplate->extra_text_1;
        $saveTemplate->extra_text_1_color = $sessionData['template_data']['extra_text_1_color'] ?? $saveTemplate->extra_text_1_color;

        $saveTemplate->social_links = $social_links;
        $saveTemplate->contact_icons = $contact_icons;
        $saveTemplate->save();

        if($saveTemplate != null){

            if(isset($template->gallery) && !empty($template->gallery)){

                $g = 0;
                for ($i=1; $i <= count($template->gallery); $i++) { 
                    $image1 = new GalleryImage;
                    $image1->offer_template_id = $saveTemplate->id;
                    $image1->title = $sessionData['template_data']['image_title_'.$i] ?? $template->gallery[$g]->title;
                    $image1->title_color = $sessionData['template_data']['image_'.$i.'_color'] ?? $template->gallery[$g]->title_color;
                    if(array_key_exists("image_".$i,$images)){
                        $image1->image_path = $images['image_'.$i];
                    }else{
                        $image1->image_path = $template->gallery[$g]->image_path;
                    }
                    $image1->save();

                    $g++;
                }
            }

            Session()->forget(['template_data','type']);
            return ['status' => true, 'message' => 'Template saved.'];
        }else{
            return ['status' => false, 'message' => 'Template not saved.'];
        }
    }

    public function validateCreateOffer($request){
        $current_date = date('Y-m-d');
        $page_type = Session('type');
        
        if($page_type != "template"){
            if($request->promo_url == ''){
                return ['status'=> false,'message'=> 'Website link can not be empty'];
            }

            if (filter_var($request->promo_url, FILTER_VALIDATE_URL) === FALSE) {
                return ['status'=> false,'message'=> 'Website link is not valid'];
            }

            if (strpos($request->promo_url, 'https') === false) {
                return ['status'=> false,'message'=> 'Website link is not secure'];
            }
        }

        if($request->title == ''){
            return ['status'=> false,'message'=> 'Offer title can not be empty'];
        }

        if($request->start_date == '' && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please select Offer Start Date'];
        }

        if($request->end_date == ''){
            return ['status'=> false,'message'=> 'Please select Offer End Date'];
        }

        if($request->end_date < $request->start_date  && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'End Date should be greater than or Equal to Start date'];
        }

        if($request->redeem_date == ''){
            return ['status'=> false,'message'=> 'Please select Offer Redeem Date'];
        }

        /*dd($request->all());*/

        if($request->redeem_date < $request->end_date){
            return ['status'=> false,'message'=> 'Redeem Date should be greater than or Equal to End date'];
        }

        if($request->offer_description == ''){
            return ['status'=> false,'message'=> 'Offer description can not be empty'];
        }

        if($request->discount_type == ''){
            return ['status'=> false,'message'=> 'Please select Discount Type'];
        }

        if($request->discount_type == 'Fixed' && $request->discount_amount == '' && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter Discount Amount'];
        }

        if($request->discount_type == 'Fixed' && (is_numeric($request->discount_amount) == false || $request->discount_amount == 0) && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter valid Discount Amount'];
        }

        if($request->discount_type == 'Percentage' && $request->discount_percent == '' && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter Discount Percentage'];
        }

        if($request->discount_type == 'Percentage' && (is_numeric($request->discount_percent) == false || $request->discount_percent > 100 || $request->discount_percent == 0) && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter valid Discount Percentage'];
        }

        if($request->discount_type == 'PerClick' && $request->discount_perclick == '' && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter Discount PerClick Amount'];
        }

        if($request->discount_type == 'PerClick' && (is_numeric($request->discount_perclick) == false || $request->discount_perclick == 0) && !isset($request->offer_id)){
            return ['status'=> false,'message'=> 'Please enter valid Discount PerClick Amount'];
        }

        if($request->discount_type == 'PerClick' && !isset($request->offer_id)){
            if(is_numeric($request->minimum_click) == false){
                return ['status'=> false,'message'=> 'Please enter valid Minimum Clicks Require to Redeem.'];
            }

            if(is_numeric($request->max_promo_count) == false){
                return ['status'=> false,'message'=> 'Please enter valid Maximum Clicks.'];
            }

            if($request->minimum_click >= $request->max_promo_count){
                return ['status'=> false,'message'=> 'Minimum Clicks can not be equal or greater than Maximum clicks.'];
            }
        }else{
            if(is_numeric($request->promo_count) == false && !isset($request->offer_id)){
                return ['status'=> false,'message'=> 'Please enter valid Minimum Clicks Required.'];
            }
        }

        return ['status'=> true,'message'=> 'Validated Successfully.'];
    }


    public function validateCreateMadeShareOffer($request){
        $current_date = date('Y-m-d');
        $page_type = Session('type');
        
        if($page_type != "template"){
            if($request->promo_url == ''){
                return ['status'=> false,'message'=> 'Website link can not be empty'];
            }

            if (filter_var($request->promo_url, FILTER_VALIDATE_URL) === FALSE) {
                return ['status'=> false,'message'=> 'Website link is not valid'];
            }

            if (strpos($request->promo_url, 'https') === false) {
                return ['status'=> false,'message'=> 'Website link is not secure'];
            }
        }

        if($request->title == ''){
            return ['status'=> false,'message'=> 'Offer title can not be empty'];
        }

        if($request->offer_description == ''){
            return ['status'=> false,'message'=> 'Offer description can not be empty'];
        }

        return ['status'=> true,'message'=> 'Validated Successfully.'];
    }

    public function saveOfferThumbnail(Request $request){
        //dd($request->imgBase64);
        define('UPLOAD_DIR', 'assets/offer-thumbnails/');  
        $img = $_POST['imgBase64'];  
        $img = str_replace('data:image/png;base64,', '', $img);  
        $img = str_replace(' ', '+', $img);  
        $data = base64_decode($img);  
        $file = UPLOAD_DIR . 'thumb-'.date('dmYhis',time()) . '.jpg';  
        $success = file_put_contents($file, $data); 

        $path = explode("/", parse_url($file, PHP_URL_PATH));
        $filepath = '';
        foreach($path as $val){
            $filepath .= '/'.$val;
        }
//dd(filesize($filepath));

        $filename = array_pop($path);

        if($success){
            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Thumbnail Saved Successfully!',
                    'filename' => $filename
                ]
            );
        }else{
            return response()->json(
                [
                    'status'=> false, 
                    'message'=> 'Unable to save the Thumbnail.',
                    'filename' => ''
                ]
            );
        } 
    }

    public function saveVideoThumbnail($video_id){
        $video_id = 'urtA0ht0nEE';
        $data = file_get_contents("https://www.googleapis.com/youtube/v3/videos?key=AIzaSyD1k72dPFJUHe7uxxRIvWGr10nSFFUY5e8&part=snippet&id=".$video_id);
        $json = json_decode($data);
        $img = base64_encode(file_get_contents($json->items[0]->snippet->thumbnails->maxres->url));

        define('UPLOAD_DIR', 'assets/video-thumbnails/');  
        #$img = $_POST['imgBase64'];  
        $img = str_replace('data:image/png;base64,', '', $img);  
        $img = str_replace(' ', '+', $img);  
        $data = base64_decode($img);  
        $file = UPLOAD_DIR . 'thumb-'.date('dmYhis',time()) . '.jpg';  
        $success = file_put_contents($file, $data); 

        $path = explode("/", parse_url($file, PHP_URL_PATH));
        $filename = array_pop($path);

        if($success){
            return response()->json(
                [
                    'status'=> true, 
                    'message'=> 'Thumbnail Saved Successfully!',
                    'filename' => $filename
                ]
            );
        }else{
            return response()->json(
                [
                    'status'=> false, 
                    'message'=> 'Unable to save the Thumbnail.',
                    'filename' => ''
                ]
            );
        }
    }

    public function duplicateOffer($offer_id){

        $offer = Offer::with('future_offer','offer_template')->where('id',$offer_id)->orderBy('id','desc')->first();
        $date = Carbon::now();
        $user_id = Auth::id();

        #$post = Post::find(1);
        $newOffer = $offer->replicate();
        $newOffer->title = $newOffer->title.' - Copy';
        $newOffer->is_default = '0';
        $newOffer->created_at = $date;
        $newOffer->save();

        $newOffer->uuid = 'SHR'.$user_id.'F'.$newOffer->id;
        $newOffer->save();

        $newFutureOffer = $offer->future_offer->replicate();
        $newFutureOffer->offer_id = $newOffer->id;
        $newFutureOffer->created_at = $date;
        $newFutureOffer->save();

        if($offer->offer_template != null){
            $newOfferTemplate = $offer->offer_template->replicate();
            $newOfferTemplate->offer_id = $newOffer->id;
            $newOfferTemplate->created_at = $date;
            $newOfferTemplate->save();

            if(!empty($offer->offer_template->gallery)){
                foreach($offer->offer_template->gallery as $gallery){
                    $newGallery = $gallery->replicate();
                    $newGallery->offer_template_id = $newOfferTemplate->id;
                    $newGallery->created_at = $date;
                    $newGallery->save();
                }
            }   
        }

        return redirect()->back(); 
    }

    public function offerSubscriptionCount(Request $request,$offer_id){
        $offer_subscriptions = OfferSubscription::where('offer_id',$offer_id)->count();
        return response()->json(['status' => true, 'offer_subscriptions' => $offer_subscriptions]);
    }

    public function deleteOffer(Request $request,$offer_id){
        $offerTemplate = OfferTemplate::where('offer_id',$offer_id)->first();
        if($offerTemplate != null){
            $gllery = GalleryImage::where('offer_template_id', $offerTemplate->id)->get();
            if(!empty($gllery)){
                GalleryImage::where('offer_template_id', $offerTemplate->id)->delete();
            }
        
            OfferTemplate::destroy($offerTemplate->id);
        }

        $offerFuture = OfferFuture::where('offer_id',$offer_id)->first();
        if($offerFuture != null){
            OfferFuture::destroy($offerFuture->id);
        }

        Offer::destroy($offer_id);

        return response()->json([
            'status' => true,
            'message' => 'Offer deleted successfully!'
        ]); 
    }

    public function updateYoutubeThumbnail(Request $request){
        $default_path = asset('assets/img/broken-thumbnail.jpg');

        $disk = Storage::build([
            'driver' => 'local',
            'root' => 'assets/templates/'.$request->template_id.'/',
        ]);

        $url = "https://img.youtube.com/vi/".$request->video_id."/hqdefault.jpg";

        if(@file_get_contents($url) == false){
            return response()->json([ "status" => false, "message" => "Thumbnail not found.", "thumb_path" => $default_path ]);
        }

        $contents = file_get_contents($url);
        $name = $request->video_id.'.jpg';

        $disk->put($name, $contents);

        $thumb_path = 'assets/templates/'.$request->template_id.'/'.$request->video_id.'.jpg';
        $send_path = asset('assets/templates/'.$request->template_id.'/'.$request->video_id.'.jpg');

        if(file_exists($thumb_path)){
            return response()->json([ "status" => true, "message" => "Thumbnail saved.", "thumb_path" => $send_path ]);
        }else{
            return response()->json([ "status" => false, "message" => "Thumbnail not saved.", "thumb_path" => $default_path ]);
        }

    }
      public function share_and_reward()
    {
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.future.share_and_reward', compact('notification_list','planData'));

    }

}
