<?php

namespace App\Http\Controllers\Business;

use PDF;
use Auth;
use Image;
use QrCode;
use Carbon\Carbon;
use App\Models\Task;

use App\Models\Offer;

use App\Models\AssignTask;
use App\Models\InstantTask;
use App\Models\OfferReward;

use App\Models\CompleteTask;
use App\Models\UserSocialConnection;
use App\Models\User;

use Illuminate\Http\Request;

use App\Models\BusinessDetail;
use App\Models\UserChannel;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;
use App\Jobs\UpdateSocialConnectionSalesPerson;
use App\Http\Controllers\Business\CommonSettingController;

use App\Helper\Deductions\DeductionHelper;

class InstantRewardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function index($channel_id)
    {
        // dd(Auth::id());
        $channel_id = \Request::segment(3);

        $settings = OfferReward::where('user_id',Auth::id())->where('channel_id',$channel_id)->first();
        $isChannelActive = UserChannel::whereChannelId(2)->whereUserId(Auth::id())->first('status');
        if($settings == null){
            $settings = new OfferReward;
            $settings->type = 'Free';
            // $settings->details = [
            //     'discount_amount' => '',
            //     'minimum_task' => '',
            // ];
        }else{
            if($settings->type == 'Free'){
                $settings->details = [];
            }else{
                $settings->details = json_decode($settings->details, true);
            }
        }

        $routes = RouteToggleContoller::routeDetail($channel_id, Auth::id());

        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        $domain = URL::to('/');
        $qr_url = $domain.'/business/task-page/'.$businessDetail->uuid;
        
        $instantTaskCount = InstantTask::where('user_id', Auth::id())->whereNull('deleted_at')->count();

        $tasks = Task::with('instant_task')->where('status', 1)->orderBy('column_sort_no')->get();
        $isShowTask=[];
        foreach ($tasks as $task) {
            if($task->instant_task!=NULL && $task->coming_soon==0)
            {
                if($task->instant_task->task_id==$task->id){
                    array_push($isShowTask, $task->instant_task->task_id);
                }
            }
        }
        
        $counttask=count($isShowTask);

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        // Update Social Connections
        app('App\Http\Controllers\Business\SocialConnectController')->updateUserConnections();

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first(); 
        $isConnectAnySocialMedia = 1;
        if($userSocialConnection!=NULL){
            if(
                ($userSocialConnection->is_facebook_auth ==0 || $userSocialConnection->is_facebook_auth == NULL) && 

                // ($userSocialConnection->is_twitter_auth ==0) && 

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

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());
        

        return view('business.instant-rewards.index', compact(['routes', 'notification_list','planData','channel_id','settings','qr_url', 'instantTaskCount', 'isConnectAnySocialMedia', 'userBalance','isChannelActive','counttask']));
    }

    public function store(Request $request){
        // return response()->json( $request );
        /* Restrict Sale Person */
        if(Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0){
            return response()->json(
                ['status'=> false,'message'=> "You are not authorised to perform this action."]
            );
        }
        
        $validate = $this->validateSetting($request);
        if($validate['status'] == false){
            return response()->json(
                    ['status'=> false,'message'=> $validate['message']]
                );
        }
        $details = $this->getSettingData($request);

        $userData=User::where('id',Auth::id())->first();

        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());

        if($userData->current_account_status=='paid'){
            if($userBalance['wallet_balance'] <= 0 && ($request->type == 'Gift' || $request->type == 'Percentage Discount' || $request->type == 'Fixed Amount' || $request->type == 'No Reward')){
                return response()->json(
                    ['status'=> false,'message'=> config('constants.payment_alert')]
                );
            }
        }else{
           if($request->type == 'Gift' || $request->type == 'Percentage Discount' || $request->type == 'Fixed Amount' || $request->type == 'No Reward'){
                return response()->json(
                    ['status'=> false,'message'=> config('constants.payment_alert')]
                );
            } 
        }
        
        $settings = OfferReward::where('user_id',Auth::id())->where('channel_id',$request->channel_id)->first();
        if($settings == null){
            $settings = new OfferReward;
            $settings->user_id = Auth::id();
            $settings->channel_id = $request->channel_id;
        }
        $settings->type = $request->type;
        $settings->details = json_encode($details);
        $settings->save();

        /* Update Social Channels for Sales Person */
        dispatch(new UpdateSocialConnectionSalesPerson());
        
        return response()->json(["status" => true, "message" => "Settings updated successfully!."]);

    }

    public function checkTasks(Request $request){
        $instantTasks = InstantTask::where('user_id',Auth::id())->whereNull('deleted_at')->orderBy('id','desc')->get();
        $tasks = array();
        foreach($instantTasks as $k_task => $instantTask){
            if(!in_array($instantTask->id, $tasks)){
                $tasks[] = $instantTask->id;
            }
        }
        $total_tasks = count($tasks);
        if($total_tasks == 0){
            return response()->json(["status" => false, "message" => "You dont have any task."]);
        }

        if($total_tasks < $request->minimum_task){
            return response()->json(["status" => false, "message" => "You only have $total_tasks tasks. Please enter lesser number."]);
        }else{
            return response()->json(["status" => true, "message" => "Success"]);
        }
    }

    public function getSettingData($request){
        $data = array();

        if($request->type == 'Fixed Amount'){
            $data['discount_amount'] = $request->discount_amount;
        }

        if($request->type == 'Percentage Discount'){
            $data['discount_percent'] = $request->discount_percent;
        }

        if($request->type == 'Gift'){
            $data['gift'] = $request->gift;
        }

        $data['minimum_task'] = $request->minimum_task;

        return $data;
    }

    public function validateSetting($request){

        if($request->type == 'Fixed Amount'){
            if($request->discount_amount == ''){
                return ["status" => false, "message" => "Discount Amount field can not be empty."];
            }
        }

        if($request->type == 'Percentage Discount'){
            if($request->discount_percent == ''){
                return ["status" => false, "message" => "Discount Percent field can not be empty."];
            }
        }

        if($request->type == 'Gift'){
            if($request->gift == ''){
                return ["status" => false, "message" => "Gilf field can not be empty."];
            }
        }

        if($request->minimum_task == ''){
            return ["status" => false, "message" => "Minimum task field can not be empty."];
        }

        return ["status" => true, "message" => "Validated successfully."];
    }


    public function modifyTasks()
    {
        $tasks = Task::with('instant_task')->where('status', 1)->orderBy('column_sort_no')->get();
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $isChannelActive = UserChannel::whereChannelId(2)->whereUserId(Auth::id())->first('status');
        $googleReviewDeductCost = DeductionHelper::getActiveDeductionDetail('slug', 'google_review_verification');

        $userInfo = user::find(Auth::id());

        return view('business.instant-rewards.modify-tasks', compact(['notification_list','planData','tasks', 'googleReviewDeductCost','isChannelActive', 'userInfo']));
    }

    function is_in_array($array, $key, $key_value){
        $within_array = 'no';
        foreach( $array as $k=>$v ){
            if( is_array($v) ){
                $within_array = is_in_array($v, $key, $key_value);
                if( $within_array == 'yes' ){
                    break;
                }
            } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = 'yes';
                        break;
                }
            }
        }
    }

    public function removeDeletedTask(Request $request)
    {

        $instanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($request->task_id)->orderBy('id', 'DESC')->pluck('id')->toArray();
        if($instanceTask != null){
            foreach ($instanceTask as $ITaskKey => $Itask) {
                $iTask = InstantTask::find($Itask);
                $iTask->deleted_at = Carbon::now();
                $iTask->save();

                if($iTask->task_id == 13){
                    $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                    if($userSocialConnection==NULL){
                        $userSocialConnection = new UserSocialConnection;
                    }
                    $userSocialConnection->user_id = Auth::id();
                    $userSocialConnection->is_google_auth = 0;
                    $userSocialConnection->save();

                    $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
                    if($businessDetail!=NULL){
                        $businessDetail->google_review_placeid = '';
                        $businessDetail->save();
                    }
                }
            }
        }
        return ["status" => true, "message" => "Task deleted successfully!"];
    }

    public function updateTasks(Request $request){

        $tasks = $request->except('_token', 'deleted_item');
        $tasks = $request->except('google_map_link', 'deleted_item');

        $is_error = $this->_checkUrls($tasks);
        if($is_error['status'] == 1){
            return response()->json(['status' => false, 'message' => 'Please enter valid details!', 'errors' => $is_error['errors'] ]);
        }
        else{
            $deleted_item = explode(", ", @$request['deleted_item']);
            $deleted_item = array_filter($deleted_item);
    
            $removeTask=[];
            foreach ($deleted_item as $key => $delete) {
                $removeTask[$delete]=(int)$delete;
            }

            foreach ($tasks as $k => $task){
                if($task!="undefined"){
                    $skip_keys = ['visit_page_title'];
                    if(!in_array($k, $skip_keys)){
                        $newTask = Task::where('task_key', $k)->first();
        
                        $task_id = 0;
                        if($newTask == null){
                            $task = new Task;
                            $task->name = $k;
                            $task->task_key = $k;
                            $task->status = 1;
                            $task->save();
        
                            $task_id = $task->id;
                        }
                        else{
                            $task_id = $newTask->id;
                        }
        
                        $instanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($task_id)->orderBy('id', 'DESC')->pluck('id')->toArray();
                        if($instanceTask != null){
    
                            foreach ($instanceTask as $ITaskKey => $Itask) {
                                $iTask = InstantTask::find($Itask);
    
                                // Check Old Task value and submitted task value same or not
                                if($iTask->task_value == $task){
                                    if (array_key_exists(@$iTask->task_id, @$removeTask)){
                                        // echo "delete";
                                        $iTask->deleted_at = Carbon::now();

                                        if($iTask->task_id == 13){
                                            $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                                            if($userSocialConnection==NULL){
                                                $userSocialConnection = new UserSocialConnection;
                                            }
                                            $userSocialConnection->user_id = Auth::id();
                                            $userSocialConnection->is_google_auth = 0;
                                            $userSocialConnection->save();

                                            $iTask->one_extra_field_value = $request->google_map_link;
                                        }
                                    }
                                    else{
                                        // echo "update";
                                        $iTask->task_value = $task;

                                        if($iTask->task_id == 13){
                                            $iTask->one_extra_field_value = $request->google_map_link;
                                        }
                                        
                                    }
                                }
                                else{
                                    $iTask->deleted_at = Carbon::now();
                                    if($task != NULL || $task != ""){
                                        $newInstanceTask1 = new InstantTask;
                                        $newInstanceTask1->user_id = Auth::id();
                                        $newInstanceTask1->task_id = $task_id;
                                        $newInstanceTask1->task_value = $task;

                                        if($iTask->task_id == 13){
                                            $newInstanceTask1->one_extra_field_value = $request->google_map_link;
                                        }
                                        
                                        $newInstanceTask1->save();
                                    }
                                }

                                $iTask->save();
                            }
                        }
                        else{
                            if($task != NULL || $task != ""){
                                $newInstanceTask = new InstantTask;
                                $newInstanceTask->user_id = Auth::id();
                                $newInstanceTask->task_id = $task_id;
                                $newInstanceTask->task_value = $task;

                                if($task_id == 13){
                                    $newInstanceTask->one_extra_field_value = $request->google_map_link;
                                }
    
                                
                                $newInstanceTask->save();
                            }
                        }
    
                        // Google Review Place Id update in business details social links
                        if($task_id==13){
                            // dd($task);
                            $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
                            if($businessDetail!=NULL){
                                $businessDetail->google_review_placeid = $task;
                                $businessDetail->save();

                                $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                                if($userSocialConnection==NULL){
                                    $userSocialConnection = new UserSocialConnection;
                                    $userSocialConnection->user_id = Auth::id();
                                }

                                if($task){
                                    $userSocialConnection->is_google_auth = 1;
                                    $userSocialConnection->save();
                                }else{
                                    $userSocialConnection->is_google_auth = 0;
                                    $userSocialConnection->save();
                                }
                                
                                
                                
                            }
                        }
                    }
                }
            }
            
            $redirect_url = route('business.channel.instantRewards', 2);
            return response()->json(['status' => true, 'message' => 'Tasks updated successfully!', 'redirect_url'=> $redirect_url]);
        }
    }

    public function downloadQrCode(Request $request, $str)
    {
        $planData = CommonSettingController::getBusinessPlanDetails();
        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();

        $domain = URL::to('/');
        $qr_url = $domain.'/business/task-page/'.$businessDetail->uuid;

        $path = 'assets/business/logos/'.$planData['business_detail']['logo'];
        
        if ( $planData['business_detail']['logo'] != '' && file_exists($path)) {
            $qrcode = '<img src="data:image/png;base64, '.base64_encode(QrCode::format('png')->size(512)->merge(asset($path), .25, true)->color(0, 121, 163)->errorCorrection('H')->generate($qr_url)).'" width="100%">';
        }else{
            $qrcode = '<img src="data:image/png;base64, '.base64_encode(QrCode::format('png')->size(512)->color(0, 121, 163)->errorCorrection('H')->generate($qr_url)).'" width="100%">';
        }

        $page = $str;
        $pdf = PDF::loadView('business.instant-rewards.qr-download-layout', compact('page', 'qrcode', 'planData'))->setOptions(['defaultFont' => 'Poppins, sans-serif', 'enable_remote' => true])->setPaper('A5', 'portrait');
        
        if($request->has('stream') && $request->stream == 1){
            return $pdf->stream();
        }

        return $pdf->download('QR-Code-'.$str.'.pdf');
    }



    private function _checkUrls($urls=[])
    {
        $findfb   = 'facebook.com';
        $findin   = 'instagram.com';
        $findtw   = 'twitter.com';
        $findli   = 'linkedin.com';
        $findyt   = 'youtube.com';
        $findytChannel   = 'youtube.com/channel';
        $findytWatchPost   = 'youtube.com/watch';
        $findgo   = 'google.com';
        $findgoglemap   = 'google.com/maps';

        $err=[];
        foreach ($urls as $key => $url) {
            if(($url!="" || $url!=NULL) && isset($url) && $url!='undefined'){
                
                // FACEBOOK
                if($key == 'fb_page_url'){
                    if (!is_numeric($url)){
                        $err[] = ["key"=>$key, "msg" => "Please enter valid facebook page ID."];
                    }
                }
                // if($key == 'fb_page_url' || $key == 'fb_comment_post_url' || $key == 'fb_like_post_url'){
                if($key == 'fb_comment_post_url' || $key == 'fb_like_post_url'){
                    if (strpos($url, $findfb) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid facebook post URL."];
                    }
                }

                // INSTAGRAM
                if($key == 'insta_profile_url' || $key == 'insta_post_url'){
                    if (strpos($url, $findin) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid instagram link."];
                    }
                }

                // TWEETER
                // if($key == 'tw_username' || $key == 'tw_tweet_url'){
                if($key == 'tw_tweet_url'){
                    if (strpos($url, $findtw) === false) {
                        $err[] = ["key"=>$key, "msg" => "Twitter username is invalid."];
                    }
                }

                // LINKEDIN
                if($key == 'li_company_url' || $key == 'li_post_url'){
                    if (strpos($url, $findli) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid linkedin page link."];
                    }
                }

                // YOUTUBE
                if($key == 'yt_channel_url'){
                    if (strpos($url, $findytChannel) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid youtube channel link."];
                    }
                }

                if($key == 'yt_like_url' || $key == 'yt_comment_url'){
                    if (strpos($url, $findytWatchPost) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid youtube video link."];
                    }
                }

                // GOOGLE
                if($key == 'google_map_link'){
                    if (strpos($url, $findgoglemap) === false) {
                        $err[] = ["key"=>$key, "msg" => "Please enter valid google link."];
                    }
                }
            }
        }

        if(empty($err)){
            return ['status'=> 0,'errors'=> []];
        }
        else{
            return ['status'=> 1,'errors'=> $err];
        }
    }
}
