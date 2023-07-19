<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\InstantTask;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\UserSocialConnection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OfferPostToSocialMedia implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->data);
        // Log::info("run OfferPostToSocialMedia Job at the time offer created from offerController ");

        $userSocialConnection = UserSocialConnection::where('user_id', $this->data['user_id'])->first();       
        $offer = Offer::find($this->data['offer_id']);
        $option=Option::where('key','social_post_url')->first(); 
        $userDetail = User::where('id', $offer->user_id)->where('status', 1)->first();

        Log::info($userDetail->social_post_api_token);

        if($userDetail->social_post_api_token!=NULL){
            if($userSocialConnection!=NULL){
                // Post to facebook
                // Log::info("Ongoing Facebook post");
                if($userSocialConnection->is_facebook_auth != NULL && $userSocialConnection->facebook_page_id!=NULL){
                    $this->postToFacebook($userDetail, $option, $userSocialConnection);
                }

                // Post to twitter
                // Log::info("Ongoing twiiter post");
                if($userSocialConnection->is_twitter_auth != NULL ){
                    $this->postToTwitter($userDetail, $option, $userSocialConnection);
                }

                // Post to linkedIn
                // Log::info("Ongoing linkedIn post");
                if($userSocialConnection->is_linkedin_auth != NULL && $userSocialConnection->linkedin_page_id!=NULL){
                    $this->postToLinkedIn($userDetail, $option, $userSocialConnection);
                }

                // Post to linkedIn
                // Log::info("Ongoing Instagram post");
                if($userSocialConnection->is_instagram_auth){
                    if($offer->type=="custom" && $offer->website_url != ''){
                    }
                    else{
                        $this->postToInstagram($userDetail, $option, $userSocialConnection);
                    }
                }
            }
        }
    }

    protected function addSocialPostTask($task_value, $task_key, $offer_id){
        $instant_tasks = new InstantTask;

        $tasks = [];
        if($task_key == "facebook"){
            $tasks = [2, 3, 15];
        }
        else if($task_key == "twitter"){
            $tasks = [7];
        }
        else if($task_key == "linkedin"){
            $tasks = [9];
        }
        else if($task_key == "instagram"){
            $tasks = [5, 16];
        }

        $inTasks=[];
        foreach ($tasks as $key => $task){
            $taskInfo = Task::find($task);
            $instanceTask = InstantTask::whereUserId($this->data['user_id'])->whereNull('deleted_at')->whereTaskId($task)->orderBy('id', 'DESC')->pluck('id')->toArray();
            if($instanceTask != null){
                foreach ($instanceTask as $ITaskKey => $Itask) {
                    $iTask = InstantTask::find($Itask);
                    $iTask->deleted_at = Carbon::now();
                    $iTask->save();
                }
            }

            $newInstantTasks['user_id'] = $this->data['user_id'];
            $newInstantTasks['offer_id'] = $offer_id;
            $newInstantTasks['task_value'] = $task_value;
            $newInstantTasks['task_id'] = $task;
            $inTasks[]=$newInstantTasks;
        }
        InstantTask::insert($inTasks);
    }

    // FACEBOOK POST
    protected function postToFacebook($userDetail, $option, $userSocialConnection){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/facebook/publish";

        // Get Page ID
        $userSocialConnection = UserSocialConnection::where('user_id', $this->data['user_id'])->first();
        $post_id = (int) $this->data['social_post_id'];
        $page_id = (int) $userSocialConnection->facebook_page_id;

        $postfields=[];
        $postfields['post_id'] = $post_id;
        $postfields['page_id'] = $page_id;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];

        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
        // Log::debug("Facebook --");
        // Log::debug($response);

        $response = json_decode($response, true);

        if($response!=NULL){
            if($response['status']==200){
                $task_value = $response['post_url'];
                $this->addSocialPostTask($task_value, 'facebook', $this->data['offer_id']);
            }
        }
    }

    // Twitter
    protected function postToTwitter($userDetail, $option, $userSocialConnection){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/twitter/tweet";

        $postfields=[];
        $postfields['post_id'] = (int) $this->data['social_post_id'];

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
        // Log::debug("Twitter --");
        // Log::debug($response);
        $response = json_decode($response, true);

        // $response=[
        //     'status'=>32,
        //     'msg'=>'Could not authenticate you.'
        // ]; 
        if($response!=NULL){
            if($response['status']==32){
                $expiredParams=[
                    'user_id' => $userSocialConnection->user_id,
                    'platform' => "twitter",
                ];
                app('App\Http\Controllers\SocialPagesController')->expireSocialMedia($expiredParams);
            }
            else if($response['status']==200){
                $task_value = $response['tweet_url'];
                $this->addSocialPostTask($task_value, 'twitter', $this->data['offer_id']);
            }
        }
        // dd($response['status']);
    }

    // LinkedIn
    protected function postToLinkedIn($userDetail, $option, $userSocialConnection){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/linkedin/post";

        // Get Page ID
        $userSocialConnection = UserSocialConnection::where('user_id', $this->data['user_id'])->first();
        $post_id = $this->data['social_post_id'];
        $page_id = $userSocialConnection->linkedin_page_id ?? NULL;

        $postfields=[];
        $postfields['post_id'] = $post_id;
        $postfields['page_id'] = $page_id;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];

        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
        // Log::debug("Linkedin --");
        // Log::debug($response);
        $response = json_decode($response, true);

        if($response!=NULL){
            if($response['status']==200){
                $task_value = $response['post_url'];
                $this->addSocialPostTask($task_value, 'linkedin', $this->data['offer_id']);
            }
        }
    }

    protected function postToInstagram($userDetail, $option, $userSocialConnection){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/instagram/postToInstagram";

        // Get Page ID
        $userSocialConnection = UserSocialConnection::where('user_id', $this->data['user_id'])->first();
        $post_id = $this->data['social_post_id'];

        $postfields=[];
        $postfields['post_id'] = $post_id;
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);

        // Log::debug("Instagram --");
        // Log::debug($response);

        $response = json_decode($response,true);
        if($response==NULL){
            return true;
        }
        else if($response['status']==200){
            $urlPostDetail = $option->value."/api/instagram/getInstaPostDetails";
            $curlParams=[
                'url' => $urlPostDetail,
                'social_post_api_token' => @$social_post_api_token,
                'postfields' => @$postfields,
            ];

            $responsePostDetail = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
            $responsePostDetail = json_decode($responsePostDetail,true);
            if($responsePostDetail!=NULL){
                if($responsePostDetail['status']==200){
                    $task_value = $responsePostDetail['data']['permalink'];
                    $this->addSocialPostTask($task_value, 'instagram', $this->data['offer_id']);
                }
            }      
        }

    }

    

}
