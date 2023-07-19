<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use Illuminate\Http\Request;

use App\Models\SocialPost;
use App\Models\Offer;
use App\Models\SocialPlatform;
use App\Models\InstantTask;
use App\Models\BusinessDetail;
use App\Models\UserSocialConnection;
use App\Models\Option;
use App\Models\UserSocialPlatform;

use Auth;
use Image;
use DB;
use URL;
use Carbon\Carbon;


class SocialpostController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(Request $request){
        $domain = URL::to('/');
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();

        // Facebook Page show modal
        $isFacebookCheck = $islinkedInCheck = 0;
        

        // DB::enableQueryLog();
        $todays = date("Y-m-d");
        // $scheduled = SocialPost::with('scheduleOffers')->where('user_id', Auth::id())->get();
        $scheduled = Offer::with('socialPost', 'getInstantTasks')->where('user_id', Auth::id())
                            ->has('socialPost')
                            ->where('end_date', '>=', $todays)
                            ->orderBy('start_date', 'asc')
                            ->get();

        $unscheduled =  Offer::with('socialPost', 'getInstantTasks')
                        ->has('socialPost')
                        ->where('user_id', Auth::id())
                        ->whereNull('start_date')
                        ->whereNull('end_date')
                        ->orderBy('created_at', 'DESC')
                        ->get();

        $posted    =   Offer::with('socialPost', 'getInstantTasks')
                        ->has('socialPost')
                        ->has('getInstantTasks')
                        ->where('user_id', Auth::id())
                        ->orderBy('id', 'DESC')
                        ->get();

        $businessDetails = BusinessDetail::where('user_id', Auth::id())->orderBy('id', 'desc')->first();

        //API URL
        $isSocialPostOption = Option::where('key', 'is_social_post_auto')->first();

        $isSocialPost = $isSocialPostOption->value;

        $userSocialPlatform = UserSocialPlatform::orderBy('sort_no', 'ASC')->get();
        $activeUserSocialPlatform = UserSocialPlatform::where('status', 1)->pluck('platform_key')->toArray();
        // dd($activeUserSocialPlatform);

        return view('business.social-posts.index', compact('domain', 'notification_list', 'planData', 'scheduled', 'unscheduled', 'posted', 'businessDetails', 'userSocialConnection', 'isFacebookCheck', 'islinkedInCheck', 'isSocialPost', 'userSocialPlatform', 'activeUserSocialPlatform'));
    }

    public function addPostTask(Request $request)
    {
        $task_value = $request->task_value;
        $task_key = decrypt($request->task_key);
        $offer_id = decrypt($request->offer_id);

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
        }

        $inTasks=[];
        foreach ($tasks as $key => $task){

            $instanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($task)->orderBy('id', 'DESC')->pluck('id')->toArray();
            if($instanceTask != null){
                foreach ($instanceTask as $ITaskKey => $Itask) {
                    $iTask = InstantTask::find($Itask);
                    $iTask->deleted_at = Carbon::now();
                    $iTask->save();
                }
            }

            $newInstantTasks['user_id'] = Auth::id();
            $newInstantTasks['offer_id'] = $offer_id;
            $newInstantTasks['task_value'] = $request->task_value;
            $newInstantTasks['task_id'] = $task;
            $inTasks[]=$newInstantTasks;
        }

        // echo "<pre>"; print_r($inTasks);

        // echo "<pre>"; print_r($offer_id);
        // return response()->json([
        //     "status" => true,
        //     "message" => "Task updated successfully" 
        // ]);

        if(InstantTask::insert($inTasks)){
            return response()->json([
                "status" => true,
                "message" => "Task updated successfully" 
            ]);
        }
        else{
            return response()->json([
                "status" => false,
                "message" => "Unable to update Task" 
            ]);
        }
    }

}