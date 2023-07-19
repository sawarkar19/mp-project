<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\InstantTask;
use App\Models\Option;
use App\Models\User;
use App\Models\UserSocialConnection;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageTemplateSchedule;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Carbon\Carbon;

class SendCurrentOfferSocialCountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $activeUserIds = User::where('role_id', 2)->where('status', 1)->pluck('id')->toArray();

        $CurrOffer = Offer::whereIn('user_id', $activeUserIds)->with('instant_tasks')->whereDate('start_date',">=", Carbon::now())->whereDate('end_date',"<=", Carbon::now())->get();
        
        foreach($CurrOffer as $okey => $oval)
        {
            $fb_task_ids = $in_task_ids = $tw_task_ids = $youtube_task_ids = [];
            foreach($oval->instant_tasks as $key => $val)
            {
                $taskVal = $val->task_value;
                $userSocialConnection = UserSocialConnection::where('user_id', $oval->user_id)->first();
                
                //***  Check Facebook APIs ***//

                if($val->task_id == '2' || $val->task_id == '3' || $val->task_id == '15')
                {
                    if($userSocialConnection->is_facebook_auth==NULL || $userSocialConnection->facebook_page_id==NULL){
                    }else{
                        $fb_task_ids = [2, 3, 15];
                    }
                }

                //***  Check Twitter APIs ***//
                if($val->task_id == '7')
                {
                    if(!empty($userSocialConnection->is_twitter_auth)){
                        $tw_task_ids = [7];
                    }    
                }

                //***  Check Instagram APIs ***//

                if($val->task_id == '5' || $val->task_id == '16')
                {
                    if($userSocialConnection->is_instagram_auth==NULL){
                    }else{
                        $in_task_ids = [5, 16];
                    }       
                }
            }
            if(!empty(count($fb_task_ids)))
                $this->postCount($fb_task_ids, $oval->user_id, $oval->social_post__db_id, $oval->id, 'facebook');
            if(!empty(count($in_task_ids)))
                $this->postCount($in_task_ids, $oval->user_id, $oval->social_post__db_id, $oval->id,'instagram');
            if(!empty(count($tw_task_ids)))
                $this->twitterPostCount($tw_task_ids, $oval->user_id, $oval->id);    

            $youtube_task_ids = [11, 12];
            $this->youtubePostCount($youtube_task_ids, $oval->user_id, $oval->id);
        }
    }

    /**
     * Facebook Api Count
     */
    public function postCount($fb_task_ids, $user_id, $social_post_db_id, $offer_id, $type = '')
    {
        $instantTasks = InstantTask::with('task')->whereIn('task_id', $fb_task_ids)->where('user_id', $user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();
        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($user_id);
        $facebookPostID = $social_post_db_id;
        
        if($type == 'facebook')
            $url=$option->value."/api/facebook/getPostLCSCount";
        elseif($type == 'instagram')    
            $url=$option->value."/api/instagram/getInstaPostDetails";
       
        if($userDetail != null && !empty($userDetail->social_post_api_token))
        {
            $social_post_api_token = $userDetail->social_post_api_token;

            sleep(5);

            // check facebook like
            $curl = curl_init();
            $postfields=[];
            if(isset($facebookPostID)){
                $postfields['post_id'] = $facebookPostID;
            }
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $postfields,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$social_post_api_token
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, true);
            if($type == 'facebook')
            {
                $commentsCount = (isset($response['comments']))?$response['comments']['summary']['total_count']:0;
                $likesCount = (isset($response['likes']))?$response['likes']['summary']['total_count']:0; 
                $shareCount = (isset($response['shares']))?$response['shares']['summary']['total_count']:0;
                
                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'fb_comment_post_url_count', $commentsCount);
                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'fb_like_post_url_count', $likesCount);
                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'fb_share_post_url_count', $shareCount);
            }elseif($type == 'instagram')
            {
                $likeCount = $response['data']['like_count'] ?? 0;
                $commentCount = $response['data']['comments_count'] ?? 0;
                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'insta_like_post_url_count', $likeCount ?? 0);
                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'insta_comment_post_url_count', $commentCount ?? 0);
            }
        }
    }

    /**
     * Twitter Api Count
     */
    public function twitterPostCount($tw_task_ids, $user_id, $offer_id)
    {
        $instantTasks = InstantTask::with('task')->whereIn('task_id', $tw_task_ids)->where('user_id', $user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->first();
        $twitter_data = Option::where('key','openlink_twitter')->orderBy('id','desc')->first();
        if($twitter_data != null){
            $twitter = json_decode($twitter_data->value);
        
            $uriSegments = explode("/", parse_url($instantTasks->task_value, PHP_URL_PATH));
            $tweet_ID = array_pop($uriSegments);

            sleep(5);

            //get user id from username
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.twitter.com/2/tweets/'.$tweet_ID.'/liking_users');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

            $headers = array();
            $headers[] = 'Authorization: Bearer '.$twitter->bearer_token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            curl_close($ch);

            $likedData = json_decode($result);
            app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id, 'tw_tweet_url_count', $likedData->meta->result_count ?? 0);
        }
    }
    
    /**
     * Youtube Api Count
     */
    public function youtubePostCount($yo_task_ids, $user_id, $offer_id)
    {
        $instantTasks = InstantTask::with('task')->whereIn('task_id', $yo_task_ids)->where('user_id', $user_id)->whereNull('deleted_at')->groupBy('task_id')->orderBy('created_at', 'DESC')->get();
        foreach($instantTasks as $key => $val)
        {
            $youtube_data = Option::where('key','openlink_youtube')->orderBy('id','desc')->first();
            if($youtube_data != null && $val != null){
                $youtube = json_decode($youtube_data->value);
            
                // COMMENT FOR TEST CLICK FUNCTIONALITY

                $parts = parse_url($val->task_value);
                parse_str($parts['query'], $query);
                $videoID = $query['v'];

                sleep(5);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id='.$videoID.'&key='.$youtube->api_key);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

                $video = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);

                $videoData = json_decode($video);
                
                if(isset($videoData->items)){
                    
                    foreach($videoData->items as $data){
                        if($videoID == $data->id){
                            if($val->task_id==11){
                                $likeCount = $data->statistics->likeCount ?? 0;
                                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'yt_like_url_count', $likeCount);
                            }
                            if($val->task_id==12){
                                $commentCount = $data->statistics->commentCount ?? 0;
                                app('App\Http\Controllers\SocialPagesController')->updateSocialOfferCount($offer_id, $user_id,'yt_comment_url_count', $commentCount);
                            }
                        }
                        
                    }
                }
            }
        }
    }

}

