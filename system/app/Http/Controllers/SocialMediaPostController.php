<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\Task;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\InstantTask;
use Illuminate\Http\Request;
use App\Models\UserSocialPlatform;
use App\Models\UserSocialConnection;


class SocialMediaPostController extends Controller
{
    // On Going Offer post to user connected social media 
    public function onGoingOfferPost($user_id=0, $offer_id=0, $offer_social_post_id=0)
    {
        $activeUserSocialPlatform = UserSocialPlatform::where('status', 1)->pluck('platform_key')->toArray();
        
        $userSocialConnection = UserSocialConnection::where('user_id', $user_id)->first();       
        $offer = Offer::with("offer_template")->find($offer_id);
        $option=Option::where('key','social_post_url')->first(); 
        $userDetail = User::find($user_id);

        if($userDetail->social_post_api_token!=NULL){
            if($userSocialConnection!=NULL){
                // Post to facebook
                // if(in_array('facebook', $activeUserSocialPlatform)){
                    if($userSocialConnection->is_facebook_auth != NULL && $userSocialConnection->facebook_page_id!=NULL){
                        $this->_postToFacebook($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id);
                    }
                // }

                // Post to twitter
                // if(in_array('twitter', $activeUserSocialPlatform)){
                    if($userSocialConnection->is_twitter_auth != NULL ){
                        $this->_postToTwitter($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id);
                    }
                // }

                // Post to linkedIn
                // if(in_array('linkedin', $activeUserSocialPlatform)){
                    if($userSocialConnection->is_linkedin_auth != NULL && $userSocialConnection->linkedin_page_id!=NULL){
                        $this->_postToLinkedIn($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id);
                    }
                // }

                // Post to Instagram
                // if(in_array('instagram', $activeUserSocialPlatform)){
                    if($userSocialConnection->is_instagram_auth){
                        if($offer->type=="custom" && $offer->website_url != ''){
                        }
                        else{
                            $this->_postToInstagram($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id);
                        }
                    }
                // }

                // Post to youtube
                if(isset($offer->offer_template) && $offer->offer_template->video_url != NULL){
                    $task_value = $offer->offer_template->video_url;
                    $task_key="youtube";
                    $youtube_offer_id=NULL;
                    $this->_addSocialPostTask($task_value, 'youtube', NULL, $userDetail->id ?? 0);
                }

            }
        }
    }

    // FACEBOOK POST
    private function _postToFacebook($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/facebook/publish";

        // Get Page ID
        $post_id = (int) $offer_social_post_id;
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
        $response = json_decode($response, true);
        if($response!=NULL){
            if($response['status']==200){
                $task_value = $response['post_url'];
                $this->_addSocialPostTask($task_value, 'facebook', $offer_id, $userDetail->id ?? 0);
            }
        }
        else{
            Log::info("=====================");
            Log::info("facebook");
            Log::info($offer_id);
            Log::info($response);
        }
    }




    // Twitter
    private function _postToTwitter($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/twitter/tweet";

        $postfields=[];
        $postfields['post_id'] = (int) $offer_social_post_id;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
        $response = json_decode($response, true);
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
                $this->_addSocialPostTask($task_value, 'twitter', $offer_id, $userDetail->id ?? 0);
            }
        }else{
            Log::info("=====================");
            Log::info("twitter");
            Log::info($offer_id);
            Log::info($response);
        }
    }





    // LinkedIn
    protected function _postToLinkedIn($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/linkedin/post";

        // Get Page ID
        $post_id = (int) $offer_social_post_id;
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
        $response = json_decode($response, true);
        if($response!=NULL){
            if($response['status']==200){
                $task_value = $response['post_url'];
                $this->_addSocialPostTask($task_value, 'linkedin', $offer_id, $userDetail->id ?? 0);
            }
        }else{
            Log::info("=====================");
            Log::info("linkedin");
            Log::info($offer_id);
            Log::info($response);
        }
    }



    // Instagram
    private function _postToInstagram($userDetail, $option, $userSocialConnection, $offer_social_post_id, $offer_id){
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/instagram/postToInstagram";

        // Get Page ID
        $post_id = (int) $offer_social_post_id;

        $postfields=[];
        $postfields['post_id'] = $post_id;
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = app('App\Http\Controllers\Business\SocialConnectController')->curlPost($curlParams);
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
                    $this->_addSocialPostTask($task_value, 'instagram',  $offer_id, $userDetail->id ?? 0);
                }
            }      
        }else{
            Log::info("=====================");
            Log::info("instagram");
            Log::info($offer_id);
            Log::info($response);
        }
    }



    // Inseert Instant Task
    private function _addSocialPostTask($task_value, $task_key, $offer_id, $user_id)
    {
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
        else if($task_key == "youtube"){
            $tasks = [11, 12];
        }

        $inTasks=[];
        foreach ($tasks as $key => $task){
            $taskInfo = Task::find($task);
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
        InstantTask::insert($inTasks);
    }

}
