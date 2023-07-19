<?php

namespace App\Http\Controllers\Business;

use URL;
use Auth;
use File;
use Image;
use Session;
use Datatables;

use App\Models\Offer;
use App\Models\Redeem;
use App\Models\Customer;
use App\Models\Userplan;
use App\Models\ShortLink;
use App\Models\AssignTask;
use App\Models\InstantTask;
use App\Models\ContactGroup;
use App\Models\OfferInstant;
use App\Models\RedeemDetail;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;

use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Http\Controllers\Business\CommonSettingController;

class InstantOfferController extends Controller
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
        
        $checkBusiness = $this->checkBusinessDetails();
        if($checkBusiness['status'] == false){
            return redirect()->route('business.settings');
        }

        $user_id = Auth::user()->id;

        $offer_type=$request->offer_type ?? 'all';
        if($offer_type == "publish"){
            $find = "status";
        }else{
            $find = "is_draft";
        }

        $type = 'instant';

        $search = $request->search;
        if($search != ''){
            if ($offer_type === 'all') {
                $records = Offer::with('subscription')->withCount('users')->where('type',$type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->latest()->paginate(20);
            }else{
                $records = Offer::with('subscription')->withCount('users')->where('type',$type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->where($find,1)->latest()->paginate(20);
            }
        }else{
            if ($offer_type === 'all') {
                $records = Offer::with('subscription')->withCount('users')->where('type',$type)->where('user_id',$user_id)->latest()->paginate(20);
            }else{
                $records = Offer::with('subscription')->withCount('users')->where('type',$type)->where('title', 'like','%'.$search.'%')->where('user_id',$user_id)->where($find,1)->latest()->paginate(20);
            }
        }
        

        $all=Offer::where('user_id',Auth::user()->id)->where('type',$type)->count();
        $published=Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('status',1)->count();
        $draft=Offer::where('user_id',Auth::user()->id)->where('type',$type)->where('is_draft',1)->count();

        //dd($records);
        $bussiness_detail = BusinessDetail::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $businessSettings = CommonSettingController::businessSettings();

        $current_plan_id = ['0' => 5];
        
        $purchaseHistory = Userplan::join('plan_features', 'userplans.feature_id', '=', 'plan_features.id')->where('plan_features.slug','instant_rewards')->where('userplans.user_id',Auth::id())->count();

        return view('business.offers.instant.index', compact(['records','search','offer_type','all','published','draft','bussiness_detail','notification_list','planData','businessSettings','current_plan_id','purchaseHistory']));
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
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $current_plan_id = ['0' => 5];

        return view('business.offers.instant.create',compact('notification_list','planData','current_plan_id'));
    }

    public function store(Request $request){
        $user_id = Auth::user()->id;

        $validate = $this->validateOffer($request);
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message'], 'input' => $validate['input']]
                );
        }


        $offer_banner = '';
        if($request->hasFile('offer_image')){
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $offer_banner = $uploadedImage['file'];
            }
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

        $end_date = $end = date('Y-m-d', strtotime('+10 years'));

        $offer = new Offer;
        $offer->title = $request->title;
        $offer->user_id = $user_id;
        $offer->start_date = date('Y-m-d');
        $offer->end_date = $end_date;
        $offer->redeem_date = $end_date;
        $offer->type = 'instant';
        $offer->status = $status;
        $offer->is_draft = $request->is_draft;
        $offer->save();

        Session::put('offerId',$offer->id);

        $offerId = Offer::find($offer->id);
        $offerId->uuid = 'SHR'.$user_id.'IN'.$offer->id;
        $offerId->save();

        if($request->discount_type == 'Fixed'){
            $discount_value = $request->discount_amount;
        }else{
            $discount_value = $request->discount_percent;
        }

        $offer_detail = new OfferInstant;
        $offer_detail->offer_id = $offer->id;
        $offer_detail->offer_banner = $offer_banner;
        $offer_detail->offer_description = $request->offer_description;
        $offer_detail->target = $request->target ?? 1;
        $offer_detail->discount_type = $request->discount_type;
        $offer_detail->discount_value = $discount_value;
        $offer_detail->save();

        /*Set Default*/
        $offers_count = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->count();
        if($offers_count == 1){
            $current_off = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->first();
            $current_off->is_default = '1';
            $current_off->save();
        }

        $tasks = $this->saveTasks($offer->id,$request);
        Session::forget('offerId');

        if($tasks['status'] == false){
            return response()->json(['status'=>false, 'message'=> $tasks['message']]);
        }

    
        $redirect_url = route('business.instant.index');

        return response()->json(
            [
                'status'=> true, 
                'message'=> 'Offer Created Successfully!',
                'url' => route('business.instant.index'),
                'redirect_url' => $redirect_url
            ]
        );
    }

    public function show(Request $request, $id){
        $offer = Offer::with(['subscription','instant_offer'])->withCount('users')->findorFail($id);
        
        $previewOffer = "business/offer-preview-instant/".$offer->uuid;

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $current_plan_id = ['0' => 5];

        return view(
            'business.offers.instant.view',
            compact(
                'offer',
                'previewOffer',
                'notification_list',
                'planData',
                'current_plan_id'
            )
        );
    }

    public function previewInstantOffer($offer_uuid){
        $offer = Offer::with('instant_offer')->where('uuid', $offer_uuid)->orderBy('id', 'desc')->first();

        if($offer != null){
            $business = BusinessDetail::where('user_id',$offer->user_id)->orderBy('id', 'desc')->first();
            $instantTasks = InstantTask::where('offer_id',$offer->id)->get();

            $tasks = ['fb_page_url' => '','fb_post_url' => '','insta_profile_url' => '','insta_post_url' => '','tw_tweet_url' => '','tw_tweet_like' => '','tw_username' => '','li_company_url' => '','yt_channel_url' => '','yt_comment_url' => '','yt_like_url' => '','visit_page_url' => '', 'google_link' => ''];

            foreach ($instantTasks as $key => $task) {
                $tasks[$task->task_key] = $task->task_value;
                if($task->task_title_key != ''){
                    $tasks[$task->task_title_key] = $task->task_title;
                }
            }
//dd($tasks);

            //notification_list
            $notification_list = CommonSettingController::getNotification();
            $planData = CommonSettingController::getBusinessPlanDetails();
            $current_plan_id = ['0' => 5];

            return view('business.offers.instant.instant_offer', compact(['offer', 'business','instantTasks','tasks','notification_list','planData','current_plan_id']));
        }
    }

    public function edit(Request $request, $id){
        $offer = Offer::with('instant_offer')->findorFail($id);

        $instantTasks = InstantTask::where('offer_id',$offer->id)->get();
        $tasks = array();
        foreach ($instantTasks as $key => $task) {
            $tasks[$task->task_key] = $task->task_value;
            if($task->task_title_key != ''){
                $tasks[$task->task_title_key] = $task->task_title;
            }
        }

        //dd($tasks);


        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $current_plan_id = ['0' => 5];
        return view(
            'business.offers.instant.edit',
            compact(
                'offer','tasks','notification_list','planData','current_plan_id'
            )
        );
    }

    public function update(Request $request, $id){
        
        $offerData = Offer::with('instant_offer')->where('id', $id)->orderBy('id', 'desc')->first();

        $user_id = Auth::user()->id;
        $validate = $this->validateOffer($request, 'edit');
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message'], 'input' => $validate['input']]
                );
        }

        $offer_banner = '';
        if($request->hasFile('offer_image'))
        {
            $uploadedImage = $this->uploadImage($request);
            if($uploadedImage['status'] == false){
                return response()->json(['status'=>false, 'message'=> $uploadedImage['message']]);
            }else{
                $offer_banner = $uploadedImage['file'];
            }
        }else{
            $offer_banner = $offerData->instant_offer->offer_banner;
        }
        //dd($request->all());
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
        $offer->title = $request->title;
        $offer->user_id = $user_id;
        $offer->type = 'instant';
        $offer->status = $status;
        $offer->is_draft = $request->is_draft;
        $offer->save();

        if($request->discount_type == 'Fixed'){
            $discount_value = $request->discount_amount;
        }else{
            $discount_value = $request->discount_percent;
        }

        $offer_detail = OfferInstant::where('offer_id', $id)->orderBy('id', 'desc')->first();
        $offer_detail->offer_id = $offer->id;
        $offer_detail->offer_banner = $offer_banner;
        $offer_detail->offer_description = $request->offer_description;
        $offer_detail->target = $request->target ?? 1;
        $offer_detail->discount_type = $request->discount_type;
        $offer_detail->discount_value = $discount_value;
        $offer_detail->save();


        /*Set Default*/
        $offers_count = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->count();
        if($offers_count == 1){
            $current_off = Offer::where('user_id',Auth::id())->where('sub_type', '!=', 'MadeShare')->where('is_draft',0)->where('status',1)->first();
            $current_off->is_default = '1';
            $current_off->save();
        }


        $tasks = $this->saveTasks($id,$request);

        if($tasks['status'] == false){
            return response()->json(['status'=>false, 'message'=> $tasks['message']]);
        }

        $redirect_url = route('business.instant.index');

        return response()->json(
            [
                'status'=> true, 
                'message'=> 'Offer Updated Successfully!',
                'url' => route('business.instant.index'),
                'redirect_url' => $redirect_url
            ]
        );
    }

    public function destroy(Request $request){

    }

    public function validate_username($username)
    {
        return preg_match('/^[A-Za-z0-9_]{1,15}$/', $username);
    }

    public function saveTasks($offer_id,$request){
        $findfb   = 'facebook.com';
        $findin   = 'instagram.com';
        $findtw   = 'twitter.com';
        $findli   = 'linkedin.com';
        $findyt   = 'youtube.com';
        $findgo   = 'google.com';

        /******************/
        $fb_page_url = InstantTask::where('task_key', 'fb_page_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        // if($request->fb_page_url != ''){
        if($request->fb_page_url != ''){

            $find_fb_url = strpos($request->fb_page_url, $findfb);
            // if ($find_fb_url === false) {
            //     // return ['status'=> false,'message'=> 'Please enter valid facebook page link.'];
            //     return ['status'=> false,'message'=> 'Please enter valid facebook page ID.'];
            // }

            if($fb_page_url != null){
                if($fb_page_url->task_value != $request->fb_page_url){
                    $fb_page_url = new InstantTask;
                    $fb_page_url->offer_id = $offer_id;
                    $fb_page_url->task_key = 'fb_page_url';
                    $fb_page_url->task_value = $request->fb_page_url;
                    $fb_page_url->save();
                }else{
                    $fb_page_url->task_value = $request->fb_page_url;
                    $fb_page_url->save();
                }
            }
            
            if($fb_page_url == null){
                $fb_page_url = new InstantTask;
                $fb_page_url->offer_id = $offer_id;
                $fb_page_url->task_key = 'fb_page_url';
                $fb_page_url->task_value = $request->fb_page_url;
                $fb_page_url->save();
            }
        }else{
            if($fb_page_url != null){
                InstantTask::destroy($fb_page_url->id);
            }
        }

        /*********************/
        $fb_post_url = InstantTask::where('task_key', 'fb_post_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->fb_post_url != ''){

            $find_fb_post_url = strpos($request->fb_post_url, $findfb);
            if ($find_fb_post_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid facebook post link.'];
            }

            if($fb_post_url != null){
                if($fb_post_url->task_value != $request->fb_post_url){
                    $fb_post_url = new InstantTask;
                    $fb_post_url->offer_id = $offer_id;
                    $fb_post_url->task_key = 'fb_post_url';
                    $fb_post_url->task_value = $request->fb_post_url;
                    $fb_post_url->save();
                }else{
                    $fb_post_url->task_value = $request->fb_post_url;
                    $fb_post_url->save();
                }
                
            }
            
            if($fb_post_url == null){
                $fb_post_url = new InstantTask;
                $fb_post_url->offer_id = $offer_id;
                $fb_post_url->task_key = 'fb_post_url';
                $fb_post_url->task_value = $request->fb_post_url;
                $fb_post_url->save();
            }
        }else{
            if($fb_post_url != null){
                InstantTask::destroy($fb_post_url->id);
            }
        }

        /*********************/
        $insta_profile_url = InstantTask::where('task_key', 'insta_profile_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->insta_profile_url != ''){

            $find_insta_profile_url = strpos($request->insta_profile_url, $findin);
            if ($find_insta_profile_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid instagram profile link.'];
            }

            if($insta_profile_url != null){
                if($insta_profile_url->task_value != $request->insta_profile_url){
                    $insta_profile_url = explode("/",$request->insta_profile_url);

                    $insta_profile_url = new InstantTask;
                    $insta_profile_url->offer_id = $offer_id;
                    $insta_profile_url->task_key = 'insta_profile_url';
                    $insta_profile_url->task_value = $request->insta_profile_url;
                    $insta_profile_url->save();
                }else{
                    $insta_profile_url->task_value = $request->insta_profile_url;
                    $insta_profile_url->save();
                }
                
            }
            
            if($insta_profile_url == null){
                $insta_profile_url = new InstantTask;
                $insta_profile_url->offer_id = $offer_id;
                $insta_profile_url->task_key = 'insta_profile_url';
                $insta_profile_url->task_value = $request->insta_profile_url;
                $insta_profile_url->save();
            }
        }else{
            if($insta_profile_url != null){
                InstantTask::destroy($insta_profile_url->id);
            }
        }
        
        /*********************/
        $insta_post_url = InstantTask::where('task_key', 'insta_post_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->insta_post_url != ''){
            $find_insta_post_url = strpos($request->insta_post_url, $findin);
            if ($find_insta_post_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid instagram post link.'];
            }

            if($insta_post_url != null){
                if($insta_post_url->task_value != $request->insta_post_url){
                    $insta_post_url = new InstantTask;
                    $insta_post_url->offer_id = $offer_id;
                    $insta_post_url->task_key = 'insta_post_url';
                    $insta_post_url->task_value = $request->insta_post_url;
                    $insta_post_url->save();
                }else{
                    $insta_post_url->task_value = $request->insta_post_url;
                    $insta_post_url->save();
                }
                
            }
            
            if($insta_post_url == null){
                $insta_post_url = new InstantTask;
                $insta_post_url->offer_id = $offer_id;
                $insta_post_url->task_key = 'insta_post_url';
                $insta_post_url->task_value = $request->insta_post_url;
                $insta_post_url->save();
            }
        }else{
            if($insta_post_url != null){
                InstantTask::destroy($insta_post_url->id);
            }
        }

        /*********************/
        $tw_tweet_url = InstantTask::where('task_key', 'tw_tweet_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->tw_tweet_url != ''){

            $find_tw_tweet_url = strpos($request->tw_tweet_url, $findtw);
            if ($find_tw_tweet_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid twitter tweet link.'];
            }

            if($tw_tweet_url != null){
                if($tw_tweet_url->task_value != $request->tw_tweet_url){
                    $tw_tweet_url = new InstantTask;
                    $tw_tweet_url->offer_id = $offer_id;
                    $tw_tweet_url->task_key = 'tw_tweet_url';
                    $tw_tweet_url->task_value = $request->tw_tweet_url;
                    $tw_tweet_url->save();
                }else{
                    $tw_tweet_url->task_value = $request->tw_tweet_url;
                    $tw_tweet_url->save();
                }
                
            }
            
            if($tw_tweet_url == null){
                $tw_tweet_url = new InstantTask;
                $tw_tweet_url->offer_id = $offer_id;
                $tw_tweet_url->task_key = 'tw_tweet_url';
                $tw_tweet_url->task_value = $request->tw_tweet_url;
                $tw_tweet_url->save();
            }
        }else{
            if($tw_tweet_url != null){
                InstantTask::destroy($tw_tweet_url->id);
            }
        }

        /*********************/
        $tw_tweet_like = InstantTask::where('task_key', 'tw_tweet_like')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->tw_tweet_like != ''){

            $find_tw_tweet_like = strpos($request->tw_tweet_like, $findtw);
            if ($find_tw_tweet_like === false) {
                return ['status'=> false,'message'=> 'Please enter valid twitter tweet link.'];
            }

            if($tw_tweet_like != null){
                if($tw_tweet_like->task_value != $request->tw_tweet_like){
                    $tw_tweet_like = new InstantTask;
                    $tw_tweet_like->offer_id = $offer_id;
                    $tw_tweet_like->task_key = 'tw_tweet_like';
                    $tw_tweet_like->task_value = $request->tw_tweet_like;
                    $tw_tweet_like->save();
                }else{
                    $tw_tweet_like->task_value = $request->tw_tweet_like;
                    $tw_tweet_like->save();
                }
                
            }
            
            if($tw_tweet_like == null){
                $tw_tweet_like = new InstantTask;
                $tw_tweet_like->offer_id = $offer_id;
                $tw_tweet_like->task_key = 'tw_tweet_like';
                $tw_tweet_like->task_value = $request->tw_tweet_like;
                $tw_tweet_like->save();
            }
        }else{
            if($tw_tweet_like != null){
                InstantTask::destroy($tw_tweet_like->id);
            }
        }
        
        /*********************/
        $tw_username = InstantTask::where('task_key', 'tw_username')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->tw_username != ''){
            $is_valid = $this->validate_username($request->tw_username);
            if(!$is_valid){
                return ['status'=> false,'message'=> 'Twitter username is invalid.'];
            }
            
            if($tw_username != null){
                if($tw_username->task_value != $request->tw_username){
                    $tw_username = new InstantTask;
                    $tw_username->offer_id = $offer_id;
                    $tw_username->task_key = 'tw_username';
                    $tw_username->task_value = str_replace( '@', '', $request->tw_username);
                    $tw_username->save();
                }else{
                    $tw_username->task_value = str_replace( '@', '', $request->tw_username);
                    $tw_username->save();
                }
                
            }
            
            if($tw_username == null){
                $tw_username = new InstantTask;
                $tw_username->offer_id = $offer_id;
                $tw_username->task_key = 'tw_username';
                $tw_username->task_value = str_replace( '@', '', $request->tw_username);
                $tw_username->save();
            }
        }else{
            if($tw_username != null){
                InstantTask::destroy($tw_username->id);
            }
        }
        
        /*********************/
        $li_company_url = InstantTask::where('task_key', 'li_company_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->li_company_url != ''){

            $find_li_company_url = strpos($request->li_company_url, $findli);
            if ($find_li_company_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid linkedin page link.'];
            }

            if($li_company_url != null){
                if($li_company_url->task_value != $request->li_company_url){
                    $li_company_url = new InstantTask;
                    $li_company_url->offer_id = $offer_id;
                    $li_company_url->task_key = 'li_company_url';
                    $li_company_url->task_value = $request->li_company_url;
                    $li_company_url->save();
                }else{
                    $li_company_url->task_value = $request->li_company_url;
                    $li_company_url->save();
                }
                
            }
            
            if($li_company_url == null){
                $li_company_url = new InstantTask;
                $li_company_url->offer_id = $offer_id;
                $li_company_url->task_key = 'li_company_url';
                $li_company_url->task_value = $request->li_company_url;
                $li_company_url->save();
            }
        }else{
            if($li_company_url != null){
                InstantTask::destroy($li_company_url->id);
            }
        }

        $google_link = InstantTask::where('task_key', 'google_link')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->google_link != ''){

            $find_google_link = strpos($request->google_link, $findgo);
            if ($find_google_link === false) {
                return ['status'=> false,'message'=> 'Please enter valid google link.'];
            }

            if($google_link != null){
                if($google_link->task_value != $request->google_link){
                    $google_link = new InstantTask;
                    $google_link->offer_id = $offer_id;
                    $google_link->task_key = 'google_link';
                    $google_link->task_value = $request->google_link;
                    $google_link->save();
                }else{
                    $google_link->task_value = $request->google_link;
                    $google_link->save();
                }
                
            }
            
            if($google_link == null){
                $google_link = new InstantTask;
                $google_link->offer_id = $offer_id;
                $google_link->task_key = 'google_link';
                $google_link->task_value = $request->google_link;
                $google_link->save();
            }
        }else{
            if($google_link != null){
                InstantTask::destroy($google_link->id);
            }
        }

        /*********************/
        $yt_channel_url = InstantTask::where('task_key', 'yt_channel_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->yt_channel_url != ''){

            $find_yt_channel_url = strpos($request->yt_channel_url, $findyt);
            if ($find_yt_channel_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid youtube channel link.'];
            }

            if($yt_channel_url != null){
                if($yt_channel_url->task_value != $request->yt_channel_url){
                    $yt_channel_url = new InstantTask;
                    $yt_channel_url->offer_id = $offer_id;
                    $yt_channel_url->task_key = 'yt_channel_url';
                    $yt_channel_url->task_value = $request->yt_channel_url;
                    $yt_channel_url->save();
                }else{
                    $yt_channel_url->task_value = $request->yt_channel_url;
                    $yt_channel_url->save();
                }
                
            }
            
            if($yt_channel_url == null){
                $yt_channel_url = new InstantTask;
                $yt_channel_url->offer_id = $offer_id;
                $yt_channel_url->task_key = 'yt_channel_url';
                $yt_channel_url->task_value = $request->yt_channel_url;
                $yt_channel_url->save();
            }
        }else{
            if($yt_channel_url != null){
                InstantTask::destroy($yt_channel_url->id);
            }
        }


        $yt_comment_url = InstantTask::where('task_key', 'yt_comment_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->yt_comment_url != ''){

            $find_yt_comment_url = strpos($request->yt_comment_url, $findyt);
            if ($find_yt_comment_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid youtube channel link.'];
            }

            if($yt_comment_url != null){
                if($yt_comment_url->task_value != $request->yt_comment_url){
                    $yt_comment_url = new InstantTask;
                    $yt_comment_url->offer_id = $offer_id;
                    $yt_comment_url->task_key = 'yt_comment_url';
                    $yt_comment_url->task_value = $request->yt_comment_url;
                    $yt_comment_url->save();
                }else{
                    $yt_comment_url->task_value = $request->yt_comment_url;
                    $yt_comment_url->save();
                }
                
            }
            
            if($yt_comment_url == null){
                $yt_comment_url = new InstantTask;
                $yt_comment_url->offer_id = $offer_id;
                $yt_comment_url->task_key = 'yt_comment_url';
                $yt_comment_url->task_value = $request->yt_comment_url;
                $yt_comment_url->save();
            }
        }else{
            if($yt_comment_url != null){
                InstantTask::destroy($yt_comment_url->id);
            }
        }

        $yt_like_url = InstantTask::where('task_key', 'yt_like_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->yt_like_url != ''){

            $find_yt_like_url = strpos($request->yt_like_url, $findyt);
            if ($find_yt_like_url === false) {
                return ['status'=> false,'message'=> 'Please enter valid youtube channel link.'];
            }

            if($yt_like_url != null){
                if($yt_like_url->task_value != $request->yt_like_url){
                    $yt_like_url = new InstantTask;
                    $yt_like_url->offer_id = $offer_id;
                    $yt_like_url->task_key = 'yt_like_url';
                    $yt_like_url->task_value = $request->yt_like_url;
                    $yt_like_url->save();
                }else{
                    $yt_like_url->task_value = $request->yt_like_url;
                    $yt_like_url->save();
                }
                
            }
            
            if($yt_like_url == null){
                $yt_like_url = new InstantTask;
                $yt_like_url->offer_id = $offer_id;
                $yt_like_url->task_key = 'yt_like_url';
                $yt_like_url->task_value = $request->yt_like_url;
                $yt_like_url->save();
            }
        }else{
            if($yt_like_url != null){
                InstantTask::destroy($yt_like_url->id);
            }
        }

        /*********************/
        $visit_page_url = InstantTask::where('task_key', 'visit_page_url')->where('offer_id',$offer_id)->orderBy('id', 'desc')->first();
        
        if($request->visit_page_url != ''){

            if($visit_page_url != null){
                if($visit_page_url->task_value != $request->visit_page_url){
                    $visit_page_url = new InstantTask;
                    $visit_page_url->offer_id = $offer_id;
                    $visit_page_url->task_key = 'visit_page_url';
                    $visit_page_url->task_value = $request->visit_page_url;
                    $visit_page_url->task_title_key = 'visit_page_title';
                    $visit_page_url->task_title = $request->visit_page_title;
                    $visit_page_url->save();
                }else{
                    $visit_page_url->task_value = $request->visit_page_url;
                    $visit_page_url->task_title = $request->visit_page_title;
                    $visit_page_url->save();
                }
                
            }
            
            if($visit_page_url == null){
                $visit_page_url = new InstantTask;
                $visit_page_url->offer_id = $offer_id;
                $visit_page_url->task_key = 'visit_page_url';
                $visit_page_url->task_value = $request->visit_page_url;
                $visit_page_url->task_title_key = 'visit_page_title';
                $visit_page_url->task_title = $request->visit_page_title;
                $visit_page_url->save();
            }
        }else{
            if($visit_page_url != null){
                InstantTask::destroy($visit_page_url->id);
            }
        }

        return ['status'=> true,'message'=> 'Task saved Successfully.'];
    }

    public function validateOffer($request, $action = null){

        $task_list = ['fb_page_url','fb_post_url','insta_profile_url','insta_post_url','tw_tweet_url','tw_tweet_like','tw_username','li_company_url','yt_channel_url','yt_comment_url','yt_like_url','visit_page_url', 'google_link'];

        if($request->title == ''){
            return ['status'=> false,'message'=> 'Offer title can not be empty','input' => 'title'];
        }

        if($request->offer_description == ''){
            return ['status'=> false,'message'=> 'Offer description can not be empty','input' => 'offer_description'];
        }

        if($request->target != ''){
            if(is_numeric($request->target) == false){
                return ['status'=> false,'message'=> 'Please enter valid Number of task to complete count','input' => 'target'];
            }
        }

        if($request->discount_type == ''){
            return ['status'=> false,'message'=> 'Please select Discount Type','input' => 'discount_type'];
        }

        if($request->discount_type == 'Fixed' && $request->discount_amount == ''){
            return ['status'=> false,'message'=> 'Please enter Discount Amount','input' => 'discount_amount'];
        }

        if($request->discount_type == 'Fixed' && is_numeric($request->discount_amount) == false){
            return ['status'=> false,'message'=> 'Please enter valid Discount Amount','input' => 'discount_amount'];
        }

        if($request->discount_type == 'Percentage' && $request->discount_percent == ''){
            return ['status'=> false,'message'=> 'Please enter Discount Percentage','input' => 'discount_percent'];
        }

        if($request->discount_type == 'Percentage' && (is_numeric($request->discount_percent) == false || $request->discount_percent > 100)){
            return ['status'=> false,'message'=> 'Please enter valid Discount Percentage','input' => 'discount_percent'];
        }

        $task_count = 0;
        foreach ($task_list as $key => $v_task) {
            if($request->$v_task != ''){
                $task_count++;
            }
        }

        if($task_count == 0){
            return ['status'=> false,'message'=> 'Please provide details for at least one task', 'input' => ''];
        }

        if($request->visit_page_title == null && $request->visit_page_url != null){
            return ['status'=> false,'message'=> 'Please provide visit page title.','input' => 'visit_page_title'];
        }

        if($request->visit_page_title != null && $request->visit_page_url == null){
            return ['status'=> false,'message'=> 'Please provide visit page link.','input' => 'visit_page_url'];
        }

        //plan details
        $planData = CommonSettingController::getBusinessPlanDetails();
        
        // if($task_count > 2  && $planData['instant_rewards'] == 1){
        //     $input_name = '';
        //     foreach ($task_list as $key => $v_task) {
        //         if($request->$v_task != ''){
        //             $input_name = $v_task;
        //         }
        //     }
        //     return ['status'=> false,'message'=> 'Please Upgrade to Premium to add more than 2 task','input' => $input_name];
        // }

        if(($request->target != '') && ($request->target > $task_count)){
            return ['status'=> false,'message'=> 'Number of task to complete should not be grater than task added.','input' => 'target'];
        }

        /*if(!empty($request->mandetory) && (count($request->mandetory) > 1)){
            return ['status'=> false,'message'=> 'Only one task can be mandetory.'];
        }*/

        return ['status'=> true,'message'=> 'Validated Successfully.'];
    }

    public function uploadImage($request){

        if($request->hasFile('offer_image'))
        {
            $image = $request->file('offer_image');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){
                $folderPath = base_path('../assets/offers/banners/');
                $image_parts = explode(";base64,", $request->imagestring);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'openlink-'.date('dmYhis',time()) . '.' . 'jpg';
                $file = $folderPath . $fileName;
                file_put_contents($file, $image_base64);
                $img = Image::make($file);
                $img->encode('jpg', 75)->save($file);
                
                return ['status'=>true, 'file' => $fileName];

                /* $height = Image::make($image)->height();
                $width = Image::make($image)->width();

                if($size <= 2097152){
                    $image = $request->file('offer_image');
                    $extension = $image->getClientOriginalExtension();
                    $fileName = 'openlink-'.date('dmYhis',time()) . '.' . $extension;
                    $destinationPath = base_path('../assets/offers/banners/');
                    if(!File::isDirectory($destinationPath)){
                        File::makeDirectory($destinationPath, 0777, true, true);
                    }
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->save($destinationPath. $fileName);

                    return ['status'=>true, 'file' => $fileName, 'height' => $height, 'width' => $width];

                }else{
                    return ['status'=>false, 'message'=> 'Offer Image size must be smaller than 2MB or equal.'];
                } */

            }else{
                return ['status'=>false, 'message'=> 'Offer Image File must be an image (jpg, jpeg or png).'];
            }

        }else{
            return ['status'=>false, 'message'=> 'Please select an Offer Image.'];
        }
    }

    public function shareInstantToCustomer(Request $request, $offer_id){

        $offer = Offer::where('id', $offer_id)->where('is_draft',0)->orderBy('id', 'desc')->first();
        $domain = URL::to('/');
        
        if($offer == null){
            return response()->json(["success" => false, "message" => "Offer not found."]);
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

            //get subscription or create if not exist
            $OfferSubscription = $this->getSubscription($offer_id, $customer_id, $created_by);
            if($OfferSubscription['status'] == false){
                return response()->json(["success" => false, "message" => "Already subscribed to the offer."]);
            }
            
            $data = CommonSettingController::checkSendFlag($business_id,5);
            
            if(!$data['sendFlag']){
                return response()->json(["success" => false, "message" => "Sorry your msg limit exceed!."]);
            }

            
            if($OfferSubscription['shortcode'] == ""){
                return response()->json(["success" => false, "message" => "ShortLink not generated."]);
            }

            $code = $OfferSubscription['shortcode']->uuid;
            $phoneNumber = '91'.$request->number;

            $payload = WhatsAppMsgController::instantSubscriptionTemplate($code);
            $wpa_res = WhatsAppMsgController::sendTextMessageWP($phoneNumber, $payload);
            $res = json_decode($wpa_res);

            if($res != '' && $res->status == 'success'){
                $subscrData = OfferSubscription::find($OfferSubscription['data']->id);
                $subscrData->link_shared = "1";
                $subscrData->save();

                //

            }else{
                
                OfferSubscription::destroy($OfferSubscription['data']->id);
                return response()->json(["success" => false, "message" => "Something went wrong. Please try again."]);
            }

            if(isset($OfferSubscription['data']->share_link)){
                $share_link = $domain.$OfferSubscription['data']->share_link;
            }else{
                $share_link = $domain;
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

        $customer = Customer::with('info')->where('mobile',$request->mobile)->first();
        if($customer == null){
            $customer= new Customer;
            $customer->mobile = $request->number;
            $customer->user_id = Auth::id();
            $customer->created_by = Auth::id();
            $customer->save();

            $customer->uuid = $customer->id.'CUST'.date("Ymd");
            $customer->save();

            $business_customer = new BusinessCustomer;
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = Auth::id();
            $business_customer->name = $request->customerName;
            $business_customer->dob = $request->customerDOB;
            $business_customer->anniversary_date = $request->customerADate;
            $business_customer->save();
        }else{
            
            if($customer->info == null){
                $business_customer = new BusinessCustomer;
                $business_customer->customer_id = $customer->id;
                $business_customer->user_id = Auth::id();
                
            }else{
                $business_customer = BusinessCustomer::find($customer->info->id);
            }  
            
            $business_customer->name = $request->customerName;
            $business_customer->dob = $request->customerDOB;
            $business_customer->anniversary_date = $request->customerADate;
            $business_customer->save();
        }

        /* Add to Instant Contacts start */
        $contactGroup = ContactGroup::where('user_id', Auth::id())->where('channel_id', 2)->first();
        $contact = GroupCustomer::where('user_id', Auth::id())->where('contact_group_id', $contactGroup->id)->where('customer_id', $customer->id)->first();
        if($contact == null){
            $contact = new GroupCustomer;
            $contact->user_id = Auth::id();
            $contact->contact_group_id = $contactGroup->id;
            $contact->customer_id = $customer->id;
            $contact->save();
        }
        /* Add to Instant Contacts end */

        $customer = Customer::with('info')->where('id',$customer->id)->first();

        return $customer;
    }

    public function getSubscription($offer_id, $customer_id, $created_by){
        $subscription = OfferSubscription::where('offer_id', $offer_id)->where('customer_id', $customer_id)->orderBy('id', 'desc')->first();
        $domain = URL::to('/');

        if($subscription != null){
            $redeem = Redeem::where('offer_subscribe_id',$subscription->id)->orderBy('id', 'desc')->first();
        }else{
            $redeem = null;
        }

        if(($subscription != null && $redeem == null) || ($redeem != null && $redeem->is_redeemed == 0)){
            return ['status' => false, 'data' => $subscription, 'shortcode' => ''];
        }else{
            $type = 'instant';
            $randomString = UuidTokenController::eightCharacterUniqueToken(8);
            $addedCharacter = UuidTokenController::addCharacter($type, $randomString);
            $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
           
            if($tokenData['status'] == true){
                $tokenData = UuidTokenController::findUniqueToken($type,$addedCharacter);
            }

            $offer = Offer::with('instant_offer')->where('id',$offer_id)->orderBy('id', 'desc')->first();

            $share_link = '/i/'.$offer->uuid.'?share_cnf='.$tokenData['token'];

            $subscription = new OfferSubscription;
            $subscription->user_id = Auth::id();
            $subscription->offer_id = $offer_id;
            $subscription->customer_id = $customer_id;
            $subscription->created_by = $created_by;
            $subscription->uuid = $tokenData['token'];
            $subscription->share_link = $share_link;
            $subscription->target = $offer->instant_offer->target;
            $subscription->save();

            //API call to get shortlink         
            /*$postData = array(
                'opnlkey' => env('SHORTNER_API_KEY'),
                'secret' => env('SHORTNER_SECRET_KEY'),
                'long_link' => $domain.$share_link
            );*/

            $postData = array(
                'opnlkey' => 'ol-PFAb3O0wGo2hHnQY',
                'secret' => 'mEFgF1niz9L6PGuOgaeCet3CgjJ6X4DrpT4T6U3v',
                'long_link' => $domain.$share_link,
            );

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
                $shortLink->link = $domain.$share_link;
                $shortLink->save();

                $subscription->short_link_id = $shortLink->id;
                $subscription->save();

                return ['status' => true, 'message' => 'Offer subscribed successfully.', 'data' => $subscription, 'shortcode' => $shortLink];
            }else{
                OfferSubscription::destroy($subscription->id);
                return ['status' => true, 'message' => 'Offer not subscribed.', 'data' => '', 'shortcode' => ''];
            }
        }
    }

    public function redeemOfferInstant(Request $request, $offer_id){
        
        $offer = Offer::with('instant_offer')->where('id', $offer_id)->orderBy('id', 'desc')->first();
        if($offer == null){
            return response()->json(["success" => false, "message" => "Offer not found."]);
        }else{

            $redeem = Redeem::where('code',$request->code)->orderBy('id', 'desc')->first();

            if($redeem == null){
                return response()->json(["success" => false, "message" => "Coupon is invalid."]);
            }else{
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
            $data = ['offer' => $offer, 'redeem_id' => $redeem->id];
            return response()->json(["success" => true, 'data' => $data, "message" => "Coupon is valid. Please Proceed Payment."]);
        }
    }

    public function proceedRedeemInstant(Request $request, $redeem_id){
        
        $data = $request->data;
        if(!empty($data)){

            $redeem = Redeem::where('id', $redeem_id)->orderBy('id', 'desc')->first();
            if($redeem){

                $subscription = OfferSubscription::where('id',$redeem->offer_subscribe_id)->orderBy('id','desc')->first();

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
                $message_data = CommonSettingController::checkSendFlag(Auth::id(),5);
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

    public function setDefaultInstant(Request $request, $offer_id){
        $setDefault = Offer::find($offer_id);
        if($setDefault->is_default == "1"){
            return response()->json(["status" => true, "message" => "Offer set as default."]);
        }
        
        if($setDefault->is_draft == 1){
            return response()->json(["status" => false, "message" => "Offer is not published yet."]);
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
}
