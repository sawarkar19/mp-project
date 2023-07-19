<?php

namespace App\Jobs;

use App\Models\User;
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

use Carbon\Carbon;

use App\Models\SocialAccountCount;

class SocialAccountCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userDetail = User::find($this->userId);

        $task_ids = [1, 4, 6, 8, 10, 13];
        $instantTasks = InstantTask::where('user_id', $this->userId)->whereIn('task_id', $task_ids)->whereNull('deleted_at')->get();

        if(count($instantTasks) > 0 && $userDetail->social_post_api_token != NULL){
            $option = Option::where('key','social_post_url')->first();
        
            $params=[];
            $params['social_post_api_token'] = $userDetail->social_post_api_token;

            $todayDate = Carbon::now()->format('Y-m-d');

            foreach ($instantTasks as $key => $instantTask){
                $userSocialConnection = UserSocialConnection::where('user_id', $instantTask->user_id)->first();
                
                if($instantTask->task_id==1){
                    // Check today count is update
                    $isTodayUpdatedCount = SocialAccountCount::where('user_id', $instantTask->user_id)->where('fb_page_url_count_updated_at', $todayDate)->first();

                    if($isTodayUpdatedCount == NULL){
                        $params['url'] = $option->value."/api/facebook/getPageLikeCount";
                        $params['postfields']['fb_page_id'] = $instantTask->task_value;
                        $this->getFbPageCount($params, $instantTask->user_id);
                    }
                }
                else if($instantTask->task_id==4){
                    // Check today count is update
                    $isTodayUpdatedCount = SocialAccountCount::where('user_id', $instantTask->user_id)->where('insta_profile_url_count_updated_at', $todayDate)->first();

                    if($isTodayUpdatedCount == NULL){
                        $params['url'] = $option->value."/api/instagram/getInstaFollowsFollowersCount";
                        $params['postfields']['instagram_user_id'] = $userSocialConnection->instagram_user_id ?? NULL;
                        $this->getInstaProfileCount($params, $instantTask->user_id);
                    }
                }
                else if($instantTask->task_id==6){
                    // Check today count is update
                    $isTodayUpdatedCount = SocialAccountCount::where('user_id', $instantTask->user_id)->where('tw_username_count_updated_at', $todayDate)->first();

                    if($isTodayUpdatedCount == NULL){
                        // $this->getTwFollowCount($instantTask->task_value, $instantTask->user_id);

                        // Check Twitter Followers Count By Screen name
                        $this->getTwFollowCountByScreenName($instantTask->task_value, $instantTask->user_id);
                    }
                }
                else if($instantTask->task_id==10){
                    // Check today count is update
                    $isTodayUpdatedCount = SocialAccountCount::where('user_id', $instantTask->user_id)->where('yt_channel_url_count_updated_at', $todayDate)->first();

                    if($isTodayUpdatedCount == NULL){
                        $this->getYtSubcribeCount($instantTask->task_value, $instantTask->user_id);
                    }
                }
                else if($instantTask->task_id==13){
                    // Check today count is update
                    $isTodayUpdatedCount = SocialAccountCount::where('user_id', $instantTask->user_id)->where('google_review_link_count', $todayDate)->first();

                    if($isTodayUpdatedCount == NULL){
                        $this->getGoogleReviewCount($instantTask->one_extra_field_value, $instantTask->user_id, $userDetail->social_post_api_token);
                    }
                }
            }
        }else{
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'fb_page_url_count', 0);
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'insta_profile_url_count', 0);
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'tw_username_count', 0);
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'li_company_url_count', 0);
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'yt_channel_url_count', 0);
            app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($this->userId, 'google_review_link_count', 0);
        }
    }

    public function getFbPageCount($params, $user_id){
        $response = $this->curlPost($params);
        $response = json_decode($response, true);
        if($response!=NULL){
            $count = $response['fan_count'] ?? 0;
            if($count > 0){
                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'fb_page_url_count', $count);
            }
        }
    }

    public function getInstaProfileCount($params, $user_id){
        $response = $this->curlPost($params);
        $response = json_decode($response, true);
        if($response!=NULL){
            $count = $response['data']['followers_count'] ?? 0;
            if($count > 0){
                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'insta_profile_url_count', $count);
            }
        }
    }

    public function getTwFollowCount($task_value, $user_id){
        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;

            $uriSegments = explode("/", parse_url($task_value, PHP_URL_PATH));
            $tweet_ID = array_pop($uriSegments);

            $prefix = '@';
            if (substr($tweet_ID, 0, strlen($prefix)) == $prefix) {
                $tweet_ID = substr($tweet_ID, strlen($prefix));
            }

            $checkTwitterUserUrl = 'https://api.twitter.com/2/users/by/username/'.$tweet_ID;
            $isBusinessUserTwitter = $this->getRequestCount($checkTwitterUserUrl, $headers);
            $business_tw = json_decode($isBusinessUserTwitter);

            $tw_id = "";
            if(isset($business_tw->data)){
                $tw_id = $business_tw->data->id;

                $url = 'https://api.twitter.com/2/users/'.$tw_id.'/followers?max_results=1000';
                $postCount = $this->getRequestCount($url, $headers);
                $postCount = json_decode($postCount, true);

                $count = $postCount['meta']['result_count'] ?? 0;
                if($count > 0){
                    app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'tw_username_count', $count);
                }
            }
        }
    }

    public function getTwFollowCountByScreenName($task_value, $user_id){
        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;

            $uriSegments = explode("/", parse_url($task_value, PHP_URL_PATH));
            $tw_username = array_pop($uriSegments);

            $prefix = '@';
            if (substr($tw_username, 0, strlen($prefix)) == $prefix) {
                $tw_username = substr($tw_username, strlen($prefix));
            }

            \Log::info("========================================");

            $url = 'https://api.twitter.com/1.1/users/show.json?screen_name='.$tw_username;
            $postCount = $this->getRequestCount($url, $headers);
            $postCount = json_decode($postCount, true);
            
            if(isset($postCount['followers_count'])){
                $followersCount = $postCount['followers_count'] ?? 0;

                \Log::info("Get Username => ".$tw_username." followers count => ".$followersCount);
                if($followersCount > 0){
                    app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'tw_username_count', $followersCount);
                }
            }
            else{
                \Log::info("Not get followers count of username => ".$tw_username);
                \Log::info("response => ".json_encode($postCount));
            }
        
        }
    }

    public function getYtSubcribeCount($task_value, $user_id){
        $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
        if($youtube_data != null){
            $youtube = json_decode($youtube_data->value);

            $headers = array();

            $uriSegments = explode("/", parse_url($task_value, PHP_URL_PATH));
            $channel_ID = array_pop($uriSegments);

            $url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&id='.$channel_ID.'&key='.$youtube->api_key;
            $postCount = $this->getRequestCount($url, $headers);
            $postCount = json_decode($postCount);

            if(isset($postCount->items)){
                foreach($postCount->items as $data){
                    if($channel_ID == $data->id){
                        if($data->statistics->subscriberCount!=NULL){
                            $count = $data->statistics->subscriberCount ?? 0;
                            if($count > 0){
                                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'yt_channel_url_count', $count);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getGoogleReviewCount($extra_field, $user_id, $social_post_api_token){
        $headers = array();
        $headers[] = 'Authorization: Bearer '.$social_post_api_token;

        $option=Option::where('key', 'google_review_verify_url')->first();
        if($option!=NULL){
            $url = $option->value."google/getGoogleReviewsCount?url=".$extra_field;
            $postCount = $this->getRequestCount($url, $headers);
            $count = $postCount ? (int) $postCount : 0;
            
            if($count!=NULL){                
                app('App\Http\Controllers\SocialPagesController')->updateSocialAccountCount($user_id, 'google_review_link_count', $count);
            }
        }
    }

    public function curlPost($params=[]){
        $postfields = $params['postfields'];
        //init the resource
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $params['url'],
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$params['social_post_api_token']
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getRequestCount($url="", $headers=[]){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
