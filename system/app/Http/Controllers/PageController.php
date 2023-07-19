<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Plan;

use App\Models\User;
use App\Models\Offer;
use App\Models\IpUser;
use App\Models\Option;
use App\Models\Article;
use App\Models\Channel;
use App\Models\EmailJob;
use App\Models\PlanView;
use App\Models\Recharge;
use App\Models\PlanGroup;
use App\Models\UserLogin;
use App\Models\Enterprise;

use App\Models\InstantTask;
use App\Models\UserChannel;
use App\Models\AdminMessage;
use App\Models\BlogsSetting;
use App\Models\MessageRoute;
use Illuminate\Http\Request;
use App\Models\Documentation;
use App\Models\BusinessDetail;
use App\Models\FrontEndSearch;
use App\Models\ArticlesSetting;

use App\Models\DummyCredential;
use App\Models\FailedShortLink;
use App\Models\WhatsappSession;
use App\Models\DocumentCategory;
use App\Models\PlanGroupChannel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
    //

    static function seoMetas()
    {
        $option= Option::where('key', 'seo')->first();
        $seo=json_decode($option->value);
        return $seo;
    }

    static function socialAndSupport()
    {
        $option= Option::where('key', 'company_info')->first();
        $info=json_decode($option->value);
        return $info;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $request)
    {
        if ($request->has('failed_link')) {
            $failedShortLinkInfo = FailedShortLink::where('uuid', $request->failed_link)->first();
            if($failedShortLinkInfo != NULL){
                return redirect($failedShortLinkInfo->long_link);
            }
        }

        $info = $this->socialAndSupport();
        $seo = $this->seoMetas();

        /* fetch latest 3 blogs */
        $limit = 3;
        $blogs = Blog::orderBy('id', 'desc')->limit($limit)->get();
        
        // return view('front.home', compact('info', 'seo'));
        return view('website.home-page', compact('info', 'seo', 'blogs'));
    }

    public function about_us()
    {
        $info = $this->socialAndSupport();
        // return view('front.about_us', compact('info'));
        return view('website.about-us', compact('info'));
    }

    public function contact_us()
    {
        $info = $this->socialAndSupport();
        // return view('front.contact_us', compact('info'));
        return view('website.contact-us', compact('info'));
    }

    public function pricing()
    {
        
        //get data
        $plan_view = PlanView::where('status','1')->first();
        $plans = Plan::where('status','1')->orderBy('ordering','asc')->get();
        $groups = PlanGroup::with('channels')->where('status','1')->orderBy('ordering','asc')->get();


        $pricing_data = $this->getPricingData();
 
        //dd($pricing_data);

        $message_plans = Recharge::where("status",1)->orderBy('ordering', 'asc')->get();

        //seo
        $info = $this->socialAndSupport();

        if($plan_view->name == 'Group'){
            // return view('front.pricing', compact('info','plans','groups','pricing_data'));
            return view('website.price.pricing', compact('info','plans','groups','pricing_data', 'message_plans'));
        }else{
            //
        }
        
    }

    public function getPricingData(){
        $pricing_data = array();
        $plans = Plan::where('status','1')->orderBy('ordering','asc')->get();
        $groups = PlanGroup::where('status','1')->orderBy('ordering','asc')->get();

        foreach($plans as $plan){
            foreach($groups as $group){
                $channel_ids = PlanGroupChannel::where('plan_group_id',$group->id)->pluck('channel_id')->toArray();

                $amount = Channel::whereIn('id',$channel_ids)->sum('price');

                $pricing_data[$plan->slug][$group->slug]['total_price'] = round($amount * $plan->months);
                $pricing_data[$plan->slug][$group->slug]['payble_price'] = round(($amount * $plan->months) - ($amount * $plan->months) * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['mothly_total_price'] = $amount;
                $pricing_data[$plan->slug][$group->slug]['mothly_payble_price'] = round($amount - $amount * ($plan->discount / 100));
                $pricing_data[$plan->slug][$group->slug]['discount'] = $plan->discount;
            }
            
        }

        return $pricing_data;
    }

    

    public function blogs()
    {

        $info = $this->socialAndSupport();
        $setting = BlogsSetting::first();
        $letestBlog = Blog::orderBy('id', 'desc')->first();
        $featuredBlog = Blog::orderBy('id', 'asc')->limit(3)->get();
        $blogs = Blog::orderBy('id', 'desc')->where('id', '<>', $letestBlog->id)
        ->paginate(6);

        // return view('front.blogs', compact('info', 'blogs', 'letestBlog', 'featuredBlog', 'setting'))->with('i', (request()->input('page', 1) - 6) * 6);
        return view('website.blogs', compact('info', 'blogs', 'letestBlog', 'featuredBlog', 'setting'))->with('i', (request()->input('page', 1) - 6) * 6);
    }

    public function blog_detail($details)
    {

        $info = $this->socialAndSupport();
        $blog = Blog::where('slug', $details)->first();
        $user = User::where('id',$blog->user_id)->orderBy('id','desc')->first();
        $setting = BlogsSetting::first();
        if(!$blog){
            return view('errors.404');
        }

        // return view('front.blogs-details', compact('info', 'blog','setting','user'));
        return view('website.blogs-details', compact('info', 'blog','setting','user'));
    }
    
    public function articles()
    {

        $info = $this->socialAndSupport();
        $setting = ArticlesSetting::first();
        $letestBlog = Article::orderBy('id', 'desc')->first();
        $featuredBlog = Article::orderBy('id', 'asc')->limit(3)->get();
        $blogs = Article::orderBy('id', 'desc')->where('status', 1)
        ->paginate(6);

        // return view('front.articles', compact('info', 'blogs', 'letestBlog', 'featuredBlog', 'setting'))->with('i', (request()->input('page', 1) - 6) * 6);
        return view('website.articles', compact('info', 'blogs', 'letestBlog', 'featuredBlog', 'setting'))->with('i', (request()->input('page', 1) - 6) * 6);
    }

    public function article_detail($details)
    {

        $info = $this->socialAndSupport();
        $blog = Article::where('slug', $details)->where('status', 1)->first();
        $user = User::where('id',$blog->user_id)->orderBy('id','desc')->first();
        $setting = ArticlesSetting::first();
        if(!$blog){
            return view('errors.404');
        }

        // return view('front.article-details', compact('info', 'blog','setting','user'));
        return view('website.article-details', compact('info', 'blog','setting','user'));
    }

    public function channels($channel)
    {
        if($channel != ''){
            $info = $this->socialAndSupport();
            return view('website.products.'.$channel, compact('info'));
        }else{
            return view('errors.404');
        }
    }
    
    public function faqs()
    {
        $info = $this->socialAndSupport();
        // return view('front.faqs', compact('info'));
        return view('website.faqs', compact('info'));
    }

    public function privacy_policy()
    {
        $info = $this->socialAndSupport();
        // return view('front.info_pages.privacy_policy', compact('info'));
        return view('website.privacy-policy', compact('info'));
    }

    public function terms_and_conditions()
    {
        $info = $this->socialAndSupport();
        // return view('front.info_pages.terms_and_conditions', compact('info'));
        return view('website.terms-and-conditions', compact('info'));
    }
    
    public function landingPages($slug)
    {
       $info = $this->socialAndSupport();
       return view('website.landing_pages.' . $slug, compact('info'));
    }

    // features pages 
    public function ftr_d2c_post(){
        $info = $this->socialAndSupport();
        return view('front.features.D2C_post', compact('info'));
    }
    public function ftr_instant_rewards(){
        $info = $this->socialAndSupport();
        return view('front.features.instant_rewards', compact('info'));
    }
    public function ftr_whatsapp_api(){
        $info = $this->socialAndSupport();
        return view('front.features.openlink_whatsapp_api', compact('info'));
    }
    public function ftr_personalised_greetings(){
        $info = $this->socialAndSupport();
        return view('front.features.personalised_wishing', compact('info'));
    }
    public function ftr_share_and_reward(){
        $info = $this->socialAndSupport();
        return view('front.features.share_and_reward', compact('info'));
    }
    // features pages end 

    public function track()
    {
        $info = $this->socialAndSupport();
        return view('track', compact('info'));
    }

    public function features()
    {
        $info = $this->socialAndSupport();
        return view('front.features', compact('info'));
    }

    public function why_openlink()
    {
        $info = $this->socialAndSupport();
        return view('front.why_openlink', compact('info'));
    }

    public function businessPage($uuid){
        $businessDetail = BusinessDetail::with('owner')->where('uuid',$uuid)->orderBy('id','desc')->first();
        // dd($businessDetail);
        return view('front.business_cards.'.$businessDetail->business_card_id, compact('businessDetail'));
    }

    public function taskPage(){
        $uuid = \Request::segment(3);
        $businessDetail = BusinessDetail::where('uuid',$uuid)->select('user_id','uuid')->orderBy('id','desc')->first();
        
        $domain = URL::to('/');
        $isChannelActive = UserChannel::whereChannelId(2)->whereUserId($businessDetail->user_id)->first('status');

        if($isChannelActive->status == 0){
            if($businessDetail->vcard_type == 'webpage'){
                $vcard_url = $businessDetail->webpage_url;
            }else{
                $vcard_url = URL::to('/').'/business/info/'.$business->uuid;
            }


            return Redirect::to($vcard_url);
        }
        $today = date("Y-m-d");
        $offer = Offer::where('user_id',$businessDetail->user_id)->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();

        $tasks = InstantTask::where('user_id',$businessDetail->user_id)->whereNull('deleted_at')->count();

        if($offer == null || $tasks == 0){
            if($businessDetail->vcard_type == 'webpage'){
                $task_page = $businessDetail->webpage_url;
            }else{
                $task_page = $domain.'/business/info/'.$businessDetail->uuid;
            }
            
        }else{
            $task_page = $domain.'/i/'.$offer->uuid;
        }
        
        return Redirect::to($task_page);
    }

    public function how_to_redeem(){
        $info = $this->socialAndSupport();
        return view('front.info_pages.how-to-redeem_offer', compact('info'));
    }

    public function how_it_works(){
        $info = $this->socialAndSupport();
        return view('website.how-it-works', compact('info'));
    }

    public function getSocialPostInfo(Request $request)
    {
        // Log::debug("Webhook called");
        // Log::debug($request->all());

        $data = $request->all();
        $decode_request = $data['data'];

        $userDetail = User::where('social_post_api_token', $decode_request['user_token'])->first();
        $offerDetail = Offer::where('social_post__db_id', $decode_request['post_id'])->first();

        if($userDetail==NULL){
            return response()->json([
                "status" => false,
                "message" => "User Detail not found!"
            ]);
        }

        if($offerDetail==NULL){
            return response()->json([
                "status" => false,
                "message" => "Offer not found!"
            ]);
        }

        $user_id = $userDetail ? $userDetail->id : 0;
        $offer_id = $offerDetail->id ? $offerDetail->id : 0;

        $task_value = $decode_request['post_url'];
        $task_key = $decode_request['platform'];
        $instant_tasks = new InstantTask;

        $tasks = [];
        if($task_key == "facebook"){
            // $instant_tasks->task_key = "fb_post_url";
            $tasks = [2, 3, 15];
        }
        else if($task_key == "twitter"){
            // $instant_tasks->task_key = "tw_tweet_like";
            $tasks = [7];
        }
        else if($task_key == "linkedin"){
            // $instant_tasks->task_key = "li_post_url";
            $tasks = [9];
        }
        else if($task_key == "instagram"){
            // $instant_tasks->task_key = "li_post_url";
            $tasks = [5, 16];
            
            $option=Option::where('key','social_post_url')->first(); 
            $postfields=[];

            $urlPostDetail = $option->value."/api/instagram/getInstaPostDetails";
            $social_post_api_token = $userDetail->social_post_api_token;
            $postfields['post_id'] = $offerDetail->social_post__db_id;
            $curlParams=[
                'url' => $urlPostDetail,
                'social_post_api_token' => @$social_post_api_token,
                'postfields' => @$postfields,
            ];
            $responsePostDetail = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
            $responsePostDetail = json_decode($responsePostDetail,true);
            $task_value = $responsePostDetail['data']['permalink'] ?? NULL;
        }
        
        $inTasks=[];
        foreach ($tasks as $key => $task){
            if($task_value!="" && $task_value!=NULL){
                $instanceTask = InstantTask::whereUserId($user_id)->whereNull('deleted_at')->whereTaskId($task)->orderBy('id', 'DESC')->pluck('id')->toArray();
            
                if($instanceTask != null){
                    foreach ($instanceTask as $ITaskKey => $Itask) {
                        $iTask = InstantTask::find($Itask);
                        $iTask->deleted_at = Carbon::now();
                        $iTask->save();
                    }
                }

                $newInstantTasks['user_id'] = $user_id;
                $newInstantTasks['offer_id'] = $offer_id;
                $newInstantTasks['task_value'] = $task_value;
                $newInstantTasks['task_id'] = $task;
                $inTasks[]=$newInstantTasks;
            }
        }
        
        if(InstantTask::insert($inTasks)){
            return response()->json([
                "status" => true,
                "message" => "Offer Posted Successfully",
                "data" => $inTasks,
                "request" => $decode_request,
            ]);
        }
        else{
            return response()->json([
                "status" => false,
                "message" => "Unable to post offer",
                "data" => $inTasks,
                "request" => $decode_request,
            ]);
        }
    }

    public function results(Request $request){

        $keyword = $request->keyword;
        // dd($keyword);

        $results = FrontEndSearch::Search($keyword)
        ->paginate(10);
        // dd($results->total());
        $info = $this->socialAndSupport();

        if($keyword == '' || $keyword == null){
            return view('website.search', compact('info', 'results', 'keyword'))
            ->with('error','Please enter a keyword.');
        }

        if($results->total() == 0){
            return view('website.search', compact('info', 'results', 'keyword'))
            ->with('error','Make sure that all words are spelled correctly or Try more general keywords.');
        }

        return view('website.search', compact('info', 'results', 'keyword'))
            ->with('i', (request()->input('page', 1) - 10) * 10);

    }

    public function documentation($slug){
        $info = $this->socialAndSupport();
        $seo = $this->seoMetas();
        $category = DocumentCategory::where('status', 1)->orderBy('ordering', 'ASC')->get();
        $getCategory = DocumentCategory::where('slug', $slug)->first();
        $id = $getCategory->id;
        $documentation = Documentation::where('status', 1)->where('document_category_id', $id)->orderBy('ordering', 'ASC')->get();
        // dd($documentation);

        return view('website.documentation.index', compact('info', 'seo', 'getCategory', 'category', 'documentation', 'id'));
    }
    
    // thank you pages
    public function thankyou_pages($str){
        $info = $this->socialAndSupport();
        return view('thankyou_pages.' . $str, compact('info'));
    }
    // pos pages
    public function posInfoPage($str){

        $userData = User::where('enterprise_info_token', $str)->first();

        $name = $email = $mobile = '';

        //check if name dummy
        $dummy_name = DummyCredential::where('name', $userData->name)->first();
        if($dummy_name == null){
            $name = $userData->name;
        }

        //check if email dummy
        $dummy_email = DummyCredential::where('email', $userData->email)->first();
        if($dummy_email == null){
            $email = $userData->email;
        }

        //check if mobile dummy
        $dummy_mobile = DummyCredential::where('mobile', $userData->mobile)->first();
        if($dummy_mobile == null){
            $mobile = $userData->mobile;
        }

        if($userData != null){

            $wa_session = WhatsappSession::where('user_id', $userData->id)->first();

            if($wa_session != null && $wa_session->instance_id != null){
                $info = $this->socialAndSupport();
                return view('pos_pages.registration', compact('info', 'str', 'name', 'email', 'mobile'));
            }else{
                $url = route('posQrPage', $str);
                return redirect($url);
            }
            
        }else{
            abort(404);
        }
    }

    public function posQrPage($str){
        $wa_api_url = Option::where('key', 'wa_api_url')->first();
        
        $userData = User::where('enterprise_info_token', $str)->first();
        
        if($userData != null){

            $wa_session = WhatsappSession::where('user_id', $userData->id)->first();

            $whatsapp_num = '';
            if ($wa_session) {
                $whatsapp_num = $wa_session->wa_number;
            }

            if($wa_session != null && $wa_session->instance_id != null){
                $url = route('posInfoPage', $str);
                return redirect($url);
            }else{
                $info = $this->socialAndSupport();
                return view('pos_pages.wp-scan', compact('str','info', 'userData', 'wa_api_url', 'wa_session', 'whatsapp_num'));
            }
            
        }else{
            abort(404);
        }
    }

    public function enterpriseUserDetail($str){


        $wa_api_url = Option::where('key', 'wa_api_url')->first();
        
        $userData = User::where('enterprise_info_token', $str)->select('id','mobile','name','email','enterprise_info_token','is_registration_complete')->first();

        $name = $email = $mobile = '';

        //check if name dummy
        $dummy_name = DummyCredential::where('name', $userData->name)->first();
        if($dummy_name == null){
            $name = $userData->name;
        }

        //check if email dummy
        $dummy_email = DummyCredential::where('email', $userData->email)->first();
        if($dummy_email == null){
            $email = $userData->email;
        }

        //check if mobile dummy
        $dummy_mobile = DummyCredential::where('mobile', $userData->mobile)->first();
        if($dummy_mobile == null){
            $mobile = $userData->mobile;
        }
        
        if($userData != null){

            $wa_session = WhatsappSession::where('user_id', $userData->id)->first();

            $whatsapp_num = $instanceId = '';
            if ($wa_session) {
                $whatsapp_num = $wa_session->wa_number;
                $instanceId = $wa_session->instance_id;
            }

            $info = $this->socialAndSupport();
            return view('enterprise.info', compact('str','info', 'userData', 'wa_api_url', 'wa_session', 'whatsapp_num', 'name', 'email', 'mobile', 'instanceId'));
            
        }else{
            abort(404);
        }
    }

        
    public function setWebInstanceKey(Request $request){

        $user = User::where('enterprise_info_token', $request->enterprise_info_token)->first();
        $wa_session = WhatsappSession::where('user_id', $user->id)->first();
        $instance_key = $request->instance_key;
        $wa_id = $request->jid;
        $number = $request->number;

        if(!$wa_session){
            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
            if($wa_session == null){
                $wa_session = new WhatsappSession;
            }
            $wa_session->user_id = $user->id;
            $wa_session->instance_id = $instance_key;
            $wa_session->wa_id = $wa_id;
            $wa_session->wa_number = $number;
            $wa_session->status = 'active';
            $wa_session->save();
        }else{
            $wa_session->user_id = $user->id;
            $wa_session->instance_id = $instance_key;
            $wa_session->wa_id = $wa_id;
            $wa_session->wa_number = $number;
            $wa_session->status = 'active';
            $wa_session->save();
        }

        $avatar = $this->getVatar($instance_key, $number);
        $decode_avatar = json_decode($avatar);
        $wa_session->wa_avatar = $decode_avatar->data;
        $wa_session->save();

        return response()->json(['error' => false, 'connection' => $wa_session]);
    }

    public function resetWebInstanceKey(Request $request){
        $user = User::where('enterprise_info_token', $request->enterprise_info_token)->first();
        $wa_session = WhatsappSession::where('key_id', $request->key_id)->where('key_secret', $request->key_secret)->where('user_id', $user->id)->first();
        
        if($wa_session != ''){
            $wa_session->instance_id = '';
            $wa_session->status = 'lost';
            $wa_session->save();

            /* Update Business Whatsapp Number */
            $businessDetail = BusinessDetail::where('user_id', $user->id)->first();
            $businessDetail->whatsapp_number = '';
            $businessDetail->save();
        }

        return response()->json(['error' => false, 'message' => "Instance Id removed!"]);
    }

    public function getVatar($instance_key, $number){

        $wa_api_url = Option::where('key','wa_api_url')->first();

        $postDataArray = [
            'key' => $instance_key,
            'id' => $number
        ];
        $data = http_build_query($postDataArray);
        $ch = curl_init();
        $url=$wa_api_url->value.'/misc/downProfile';
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) { 
            return $err; 
        } else { 
            return $response; 
        }
    }

    public function getRandomCode($char = 8)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $char; $i++) {
            $index = rand(0, strlen($string) - 1);
            $randomCode .= $string[$index];
        }

        return $randomCode;
    }
    
    public function verifyPosOTP(Request $request){
        
        $number = $request->mobile;
        $otp = $request->otp;
        $enterprise_info_token = Session()->get('enterprise_info_token');

        if ($otp == Session()->get('session_otp') && $number == Session()->get('session_number')) { 
            Session()->forget('session_otp');

            $name = Session()->get('name');
            $email = Session()->get('email');
            $password = Session()->get('password');
            $mobile = Session()->get('session_number');

            $user = User::where('enterprise_info_token', $enterprise_info_token)->first();

            if($user != null){
                $user->name = $name;
                $user->email = $email;
                $user->mobile = $mobile;
                $user->password = Hash::make($password);
                $user->pass_token = '';
                $user->is_registration_complete = 1;
                $user->save();

                /* Update Email In WA API */
                $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                if($wa_session != ''){
                    $wa_data = $this->updateEmailWaAPI($wa_session, $user->email);
                }
            
                $data = [
                    'id' => $user->id,
                    'name' => $name,
                    'mobile' => $mobile,
                    'email' => $email
                ];

                /* Send Whatsapp Message */
                $msg = \App\Http\Controllers\CommonMessageController::welcomeWpMessage($name);     
                
                $long_link = route('business.dashboard');
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "free_registration");
                
                $payload = \App\Http\Controllers\WACloudApiController::mp_fr_welcome_alert('91'.$mobile, $name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_fr_welcome_alert';
                $addmin_history->message_sent_to = $mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Send Mail */
                \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($data);

                /*Add login entry*/
                $loginInfo = UserLogin::where('user_id', $user->id)->first();
                if($loginInfo == null){
                    $loginInfo = new UserLogin;
                }
                $loginInfo->user_id = $user->id;
                $loginInfo->is_login = '1';
                $loginInfo->save();

                Auth()->login($user, true);

                $url = url('/registration-free/thankyou');

                Session()->forget('name');
                Session()->forget('email');
                Session()->forget('password');
                Session()->forget('session_number');
                Session()->forget('enterprise_info_token');

                return response()->json(["status" => true, "message"=>"Your mobile number Verified!", 'redirect_url' => $url]);
            }else{
                abort(404);
            }

        }else{
            return response()->json(["status" => false, "message"=>"Invalid OTP entered."]);
        }
    }

    public function sendPosOTP(Request $request){

        $user = User::where('enterprise_info_token', $request->enterprise_info_token)->first();

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,' . $user->id,
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ]);

        session_start();

        $clientIP = request()->ip();
        $checkOTP = IpUser::where('mobile', $request->mobile)
                            ->where('date', Carbon::today())
                            ->get();

        if(count($checkOTP) <= 2){

            $number = $request->mobile;
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $enterprise_info_token = $request->enterprise_info_token;
    
            $sendOTP = $this->sendOtp($number, $name, $email, $password, $clientIP, $enterprise_info_token);

            $otp_count = IpUser::where('mobile', $number)->whereDate('date', Carbon::today())->count();

            return response()->json(["status" => true, "message"=>"OTP sent on your whatsapp number.","session_number"=> Session()->get('session_number'),"name"=>Session()->get('name'), 'otp_count'=> $otp_count]);

        }else{                
            return response()->json(["status" => false, "message"=>"OTP usage limit exceeded for this number. Try another number."]);
        }
    }

    public function resendPosOTP(Request $request){
        $user = User::where('enterprise_info_token', $request->enterprise_info_token)->first();

        $request->validate([
            'mobile' => 'required|numeric|digits:10|unique:users,mobile,' . $user->id,
        ]);

        $otp = Session()->get('session_otp');
        $name = Session()->get('name');
        $email = Session()->get('email');
        $password = Session()->get('password');

        $number = $request->mobile;

        $clientIP = request()->ip();
        $checkOTP = IpUser::where('mobile', $request->mobile)
                            ->where('date', Carbon::today())
                            ->get();

        if(count($checkOTP) <= 2){

            $number = $request->mobile;
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $enterprise_info_token = $request->enterprise_info_token;
    
            $sendOTP = $this->sendOtp($number, $name, $email, $password, $clientIP, $enterprise_info_token);

            $otp_count = IpUser::where('mobile', $number)->whereDate('date', Carbon::today())->count();

            return response()->json(["status" => true, "message"=>"OTP sent on your whatsapp number.","session_number"=> Session()->get('session_number'),"name"=>Session()->get('name'), 'otp_count'=> $otp_count]);

        }else{                
            return response()->json(["status" => false, "message"=>"OTP usage limit exceeded for this number. Try another number."]);
        }
    }

    public function sendOtp($number = '', $name = '', $email = '', $password = '', $clientIP = '', $enterprise_info_token = ''){
        $otp = rand(100000, 999999);
        
        Session(['session_otp' => $otp]);
        Session(['session_number' => $number]);
        Session(['name' => $name]);
        Session(['email' => $email]);
        Session(['password' => $password]);
        Session(['enterprise_info_token' => $enterprise_info_token]);

        $payload = \App\Http\Controllers\WACloudApiController::mp_sendotp('91'.$number, $otp);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Admin Message History start */
        $addmin_history = new AdminMessage();
        $addmin_history->template_name = 'mp_sendotp';
        $addmin_history->message_sent_to = $number;
        $addmin_history->save();
        /* Admin Message History end */

        $otp_save = new IpUser;
        $otp_save->user_ip = $clientIP;
        $otp_save->mobile = $number;
        $otp_save->date = Carbon::today();
        $otp_save->is_sent = 1;
        $otp_save->save();

        return ["status"=> true, "message"=>"OTP sent successfully."];
    }

    public function updateEmailWaAPI($wa_session = '', $email = ''){

        $postDataArray = [
            'key_id' => $wa_session->key_id,
            'key_secret' => $wa_session->key_secret,
            'email' => $email
        ];
     
        $data = http_build_query($postDataArray);
        $ch = curl_init();

        $wa_url=Option::where('key', 'wa_api_url')->first();
        $url=$wa_url->value."/user/update";
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        curl_setopt($ch, CURLOPT_POST, true);
           
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);
        curl_close($ch);

        if(isset($output->status)){
            return ['status' => true, 'data' => $output];
        }else{
            return ['status' => false, 'data' => $output];
        }
    }

    public function enterpriseOfferImage($uuid){
        $imageUrl = asset('assets/enterprise/banner/'.$uuid.'.png');

        // Read the image file
        $imageData = file_get_contents($imageUrl);

        // Set the appropriate HTTP headers
        header('Content-Type: image/jpeg');
        header('Content-Length: ' . strlen($imageData));
        // Add any other relevant headers here

        // Output the image data
        echo $imageData;
        exit;
    }
}
