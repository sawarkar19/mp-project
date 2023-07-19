<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialPost;
use App\Models\SocialPostCount;
use Illuminate\Support\Facades\Log;

use App\Models\UserSocialConnection;
use App\Models\User;
use App\Models\Option;
use App\Models\SocialOfferCount;
use App\Models\SocialAccountCount;
use App\Models\InstantTask;
 
class SocialPagesController extends Controller
{
    public function post(Request $request, $post_uuid)
    {
        #$post = SocialPost::where('uuid', $post_uuid)->where('status', 1)->first();
        $post = SocialPost::where('uuid', $post_uuid)->first();
        if($post == null){
        	return Response(view('errors.401'));
        }

        $cookie_name = "social_post_".$post_uuid."_".$request->media;
        $cookie_value = $post_uuid."_".$request->media;
		
		if(isset($_SERVER['HTTP_USER_AGENT']) && isset($_SERVER['HTTP_REFERER']) && !empty($request->media)){			

			if (strpos($_SERVER['HTTP_USER_AGENT'], 'LinkedInBot') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'facebookexternalhit') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'Twitterbot') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'help@dataminr.com') === false && strpos($_SERVER['HTTP_USER_AGENT'], 'applebot') === false) {
				if(!isset($_COOKIE[$cookie_name])) {
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

					$count = new SocialPostCount;
					$count->social_post_id = $post->id;
					$count->user_id = $post->user_id;
					$count->media = $request->media;
					$count->is_repeated = '0';
					$count->device= $_SERVER['HTTP_USER_AGENT'];
					$count->save();


					$findCount = SocialPostCount::where('user_id',$post->user_id)->where('social_post_id',$post->id)->where('media',trim($request->media))->where('is_repeated','0')->count();

					$post = SocialPost::findorFail($post->id);

					if($findCount > 0 && ($post->twitter_posted != '1' || $post->facebook_posted != '1' || $post->linkedin_posted != '1')){
						
						if(trim($request->media) == 'twitter'){
							$post->twitter_posted = '1';

						}
						if(trim($request->media) == 'facebook'){
							$post->facebook_posted = '1';
						}
						if(trim($request->media) == 'linkedin'){
							$post->linkedin_posted = '1';
						}
						$post->save();
						#dd($post);
					}
				}else if($_COOKIE[$cookie_name] == $cookie_value){
					$count = new SocialPostCount;
					$count->social_post_id = $post->id;
					$count->user_id = $post->user_id;
					$count->media = $request->media;
					$count->is_repeated = '1';
					$count->device= $_SERVER['HTTP_USER_AGENT'];
					$count->save();
				} 
			}
			
		}
		
        return view('socialpost', compact('post'));

    }

	// public function expireSocialMediaGet(Request $request)
    // {
    //     $params=[
    //         'user_id' => 55,
    //         'platform' => "facebook",
    //     ];
    //     $this->expireSocialMedia($params);
    // }

    public function expireSocialMedia($params=[])
    {
		$postfields = [];
        $userSocialConnection = UserSocialConnection::where('user_id', $params['user_id'])->first();
		
		if($userSocialConnection!=NULL){
			$postfields['facebook'] = $postfields['twitter'] = $postfields['linkedin'] = $postfields['instagram'] = $postfields['youtube'] = $postfields['google_review'] = 0;
			if($params['platform']=='facebook'){
				$postfields['facebook'] = 1;
				$postfields['instagram'] = 1;
			}
			else if($params['platform']=='twitter'){
				$postfields['twitter'] = 1;
			}
			else if($params['platform']=='linkedin'){
				$postfields['linkedin'] = 1;
			}
			else if($params['platform']=='instagram'){
				$postfields['instagram'] = 1;
				$postfields['facebook'] = 1;
			}
			else if($params['platform']=='youtube'){
				$postfields['youtube'] = 1;
			}
			else if($params['platform']=='google_review'){
				$postfields['google_review'] = 1;
			}

			$userDetails = User::find($userSocialConnection->user_id);
			$social_post_api_token = $userDetails!=NULL ? $userDetails->social_post_api_token : NULL;

			$option=Option::where('key','social_post_url')->first();
			$postUrl = $option->value."/api/disconnectSocial?facebook=".$postfields['facebook']."&twitter=".$postfields['twitter']."&linkedin=".$postfields['linkedin']."&instagram=".$postfields['instagram']."&youtube=".$postfields['youtube'];

			//init the resource
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $postUrl,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HEADER => 0,
				CURLOPT_HTTPHEADER => array(
					'Authorization: Bearer '.$social_post_api_token
				),
			));
			$response = curl_exec($curl);
			$response = json_decode($response);

			if($response!=NULL){
				if(isset($response->is_connected_with_facebook) && $response->is_connected_with_facebook==0){
					$userSocialConnection->is_facebook_auth=NULL;
					$userSocialConnection->facebook_pages=NULL;
					$userSocialConnection->facebook_page_id=NULL;
				}
				if(isset($response->is_connected_with_twitter) && $response->is_connected_with_twitter==0){
					$userSocialConnection->is_twitter_auth=NULL;
				}
				if(isset($response->is_connected_with_linkedin) && $response->is_connected_with_linkedin==0){
					$userSocialConnection->is_linkedin_auth=NULL;
					$userSocialConnection->linkedin_page_id=NULL;
				}
				if(isset($response->is_connected_with_instagram) && $response->is_connected_with_instagram==0){
					$userSocialConnection->is_instagram_auth=NULL;
				}
			}

			if($params['platform']=='google_review'){
				$userSocialConnection->is_google_auth=NULL;
			}
			
	        $userSocialConnection->save();
		}
    }
	
	public function socialPostDisconnectedInstantTasks($user_id=0){
		$userSocialConnection = UserSocialConnection::where('user_id', $user_id)->first();

		$taskIds=[];
		if(isset($userSocialConnection) && $userSocialConnection->is_facebook_auth!=1){
			array_push($taskIds, [1, 2, 3, 15]);
		}
		if(isset($userSocialConnection) && $userSocialConnection->is_instagram_auth!=1){
			array_push($taskIds, [4, 5, 16]);
		}
		if(isset($userSocialConnection) && $userSocialConnection->is_twitter_auth!=1){
			array_push($taskIds, [6, 7]);
		}
		if(isset($userSocialConnection) && $userSocialConnection->is_linkedin_auth!=1){
			array_push($taskIds, [8, 9]);
		}
		$diconnectTaskIds = array_reduce($taskIds, 'array_merge', array());

		$response=[];
		$response['instantTaskIds'] = InstantTask::whereIn('task_id', $diconnectTaskIds)->where('user_id', $user_id)->pluck('id')->toArray();
		$response['all_diconnected'] = 0;
		if(isset($userSocialConnection) && $userSocialConnection->is_facebook_auth!=1 && $userSocialConnection->is_instagram_auth!=1 && $userSocialConnection->is_twitter_auth!=1 && $userSocialConnection->is_linkedin_auth!=1){
			$response['all_diconnected'] = 1;
		}
		
		return $response;
	}

	// Add and Update Social Account Counts
	public function updateSocialAccountCount($user_id=0, $columnName="", $count=0){
		$socialAccountCount = SocialAccountCount::where('user_id', $user_id)->first();
		if($socialAccountCount==NULL){
			$socialAccountCount = new SocialAccountCount;
		}

		$socialAccountCount->user_id = $user_id;

		if($columnName=="fb_page_url_count"){
			$socialAccountCount->fb_page_url_count = $count;
			$socialAccountCount->fb_page_url_count_updated_at = Date('Y-m-d');
		}
		else if($columnName=="insta_profile_url_count"){
			$socialAccountCount->insta_profile_url_count = $count;
			$socialAccountCount->insta_profile_url_count_updated_at = Date('Y-m-d');
		}
		else if($columnName=="tw_username_count"){
			$socialAccountCount->tw_username_count = $count;
			$socialAccountCount->tw_username_count_updated_at = Date('Y-m-d');
		}
		else if($columnName=="li_company_url_count"){
			$socialAccountCount->li_company_url_count = $count;
			$socialAccountCount->li_company_url_count_updated_at = Date('Y-m-d');
		}
		else if($columnName=="yt_channel_url_count"){
			$socialAccountCount->yt_channel_url_count = $count;
			$socialAccountCount->yt_channel_url_count_updated_at = Date('Y-m-d');
		}
		else if($columnName=="google_review_link_count"){
			$socialAccountCount->google_review_link_count = $count;
			$socialAccountCount->google_review_link_count_updated_at = Date('Y-m-d');
		}
		$socialAccountCount->save();
	}

	// Add and Update Social Offer Count 
	public function updateSocialOfferCount($offer_id=0, $user_id=0, $columnName="", $count=0)
    {
		$socialOfferCount = SocialOfferCount::where('offer_id', $offer_id)->where('user_id', $user_id)->first();
		if($socialOfferCount==NULL){
			$socialOfferCount = new SocialOfferCount;
		}

		$socialOfferCount->user_id = $user_id;
		$socialOfferCount->offer_id = $offer_id;

		// Facebook
		if($columnName=="fb_comment_post_url_count"){
			$socialOfferCount->fb_comment_post_url_count = $count;
		}
		else if($columnName=="fb_like_post_url_count"){
			$socialOfferCount->fb_like_post_url_count = $count;
		}
		else if($columnName=="fb_share_post_url_count"){
			$socialOfferCount->fb_share_post_url_count = $count;
		}

		// Instagram
		if($columnName=="insta_like_post_url_count"){
			$socialOfferCount->insta_like_post_url_count = $count;
		}
		else if($columnName=="insta_comment_post_url_count"){
			$socialOfferCount->insta_comment_post_url_count = $count;
		}

		// Twitter
		else if($columnName=="tw_tweet_url_count"){
			$socialOfferCount->tw_tweet_url_count = $count;
		}

		// Youtube
		if($columnName=="yt_like_url_count"){
			$socialOfferCount->yt_like_url_count = $count;
		}
		else if($columnName=="yt_comment_url_count"){
			$socialOfferCount->yt_comment_url_count = $count;
		}

		$socialOfferCount->save();
    }
}
