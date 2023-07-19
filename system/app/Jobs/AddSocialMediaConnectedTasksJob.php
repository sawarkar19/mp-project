<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\UserSocialConnection;
use App\Models\InstantTask;

class AddSocialMediaConnectedTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $socialUserId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($socialUserId)
    {
        //
        $this->socialUserId = $socialUserId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userSocialConnection = UserSocialConnection::where('user_id', $this->socialUserId)->first();

        // Check Facebook Page => 1
        $fb_page_task_id = 1;
        $fbInstantTasks = InstantTask::where('user_id', $this->socialUserId)->where('task_id', $fb_page_task_id)->whereNull('deleted_at')->first();
        if($fbInstantTasks==NULL){
            // Add Facebook Page
            if($userSocialConnection->facebook_page_id!=NULL && $userSocialConnection->facebook_page_id!=0 && $userSocialConnection->facebook_page_id!=""){
                $this->addInstantTask($this->socialUserId, $fb_page_task_id, $userSocialConnection->facebook_page_id);
            }
        }
        else{
            // Update Facebook Page
            if($fbInstantTasks->task_id == $fb_page_task_id && $fbInstantTasks->task_value != $userSocialConnection->facebook_page_id){
                // echo "\n Update FB ";
                if($userSocialConnection->facebook_page_id!=NULL && $userSocialConnection->facebook_page_id!=0 && $userSocialConnection->facebook_page_id!=""){
                    // Delete Old Task
                    InstantTask::where('task_id', $fb_page_task_id)->where('user_id', $this->socialUserId)->update(['deleted_at' => \Carbon\Carbon::now()]);

                    $this->addInstantTask($this->socialUserId, $fb_page_task_id, $userSocialConnection->facebook_page_id);
                }
            }
        }

        // Check Instagram User Profile => 4
        $insta_profile_task_id = 4;
        $instaInstantTasks = InstantTask::where('user_id', $this->socialUserId)->where('task_id', $insta_profile_task_id)->whereNull('deleted_at')->first();
        if($instaInstantTasks==NULL){
            // Add Instagram User Profile
            if($userSocialConnection->instagram_username!=NULL && $userSocialConnection->instagram_username!=0 && $userSocialConnection->instagram_username!=""){
                $instagram_username = "https://www.instagram.com/".$userSocialConnection->instagram_username;
                $this->addInstantTask($this->socialUserId, $insta_profile_task_id, $instagram_username);
            }
        }
        else{
            // Update Instagram User Profile
            if($userSocialConnection->instagram_username!=NULL && $userSocialConnection->instagram_username!=0 && $userSocialConnection->instagram_username!=""){
                $instagram_username = "https://www.instagram.com/".$userSocialConnection->instagram_username;
                if($instaInstantTasks->task_value != $instagram_username){
                    InstantTask::where('task_id', $insta_profile_task_id)->where('user_id', $this->socialUserId)->update(['deleted_at' => \Carbon\Carbon::now()]);

                    $this->addInstantTask($this->socialUserId, $insta_profile_task_id, $instagram_username);
                }
            }
        }

        // Check Twitter Username => 6
        $twitter_username_task_id = 6;
        $twitterInstantTasks = InstantTask::where('user_id', $this->socialUserId)->where('task_id', $twitter_username_task_id)->whereNull('deleted_at')->first();
        if($twitterInstantTasks==NULL){
            if($userSocialConnection->twitter_username!=NULL && $userSocialConnection->twitter_username!=0 && $userSocialConnection->twitter_username!=""){
                $twitter_username = "@".$userSocialConnection->twitter_username;
                $this->addInstantTask($this->socialUserId, $twitter_username_task_id, $twitter_username);
            }
        }
        else{
            // Update Instagram User Profile
            if($userSocialConnection->twitter_username!=NULL && $userSocialConnection->twitter_username!=0 && $userSocialConnection->twitter_username!=""){
                $twitter_username = "@".$userSocialConnection->twitter_username;
                if($twitterInstantTasks->task_value != $twitter_username){
                    InstantTask::where('task_id', $twitter_username_task_id)->where('user_id', $this->socialUserId)->update(['deleted_at' => \Carbon\Carbon::now()]);

                    $this->addInstantTask($this->socialUserId, $twitter_username_task_id, $twitter_username);
                }
            }
        }
    }

    public function addInstantTask($user_id=0, $task_id=0, $task_value="")
    {
        $instantTask = new InstantTask;
        $instantTask->user_id = $user_id;
        $instantTask->task_id = $task_id;
        $instantTask->task_value = $task_value;
        $instantTask->save();
    }

}
