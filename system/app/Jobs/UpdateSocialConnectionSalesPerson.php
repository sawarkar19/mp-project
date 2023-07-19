<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\OfferReward;
use Illuminate\Bus\Queueable;
use App\Models\BusinessDetail;
use Illuminate\Support\Facades\Log;
use App\Models\UserSocialConnection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateSocialConnectionSalesPerson implements ShouldQueue
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
        $salesAdmin = User::where('is_sales_person', 1)->where('is_sales_admin', 1)->where('status', 1)->first();
        if($salesAdmin != null){
            $socialConnection = UserSocialConnection::where('user_id', $salesAdmin->id)->first();
            $instantReward = OfferReward::where('user_id', $salesAdmin->id)->where('channel_id', 2)->first();
            $shareReward = OfferReward::where('user_id', $salesAdmin->id)->where('channel_id', 3)->first();
            
            $salesPersonIds = User::where('is_sales_person', 1)->where('is_sales_admin', 0)->where('is_demo', 0)->pluck('id')->toArray();

            if(!empty($salesPersonIds)){
                foreach($salesPersonIds as $sp_id){

                    if($socialConnection != null){
                        /* Update Social Connection Details */
                        $updateSocialConnection = UserSocialConnection::where('user_id', $sp_id)->first();
                        if($updateSocialConnection != null){
                            $updateSocialConnection->is_facebook_auth = $socialConnection->is_facebook_auth;
                            $updateSocialConnection->facebook_pages = $socialConnection->facebook_pages; 
                            $updateSocialConnection->facebook_page_id = $socialConnection->facebook_page_id; 
                            $updateSocialConnection->is_twitter_auth = $socialConnection->is_twitter_auth; 
                            $updateSocialConnection->is_linkedin_auth = $socialConnection->is_linkedin_auth; 
                            $updateSocialConnection->linkedin_page_id = $socialConnection->linkedin_page_id; 
                            $updateSocialConnection->is_youtube_auth = $socialConnection->is_youtube_auth; 
                            $updateSocialConnection->is_instagram_auth = $socialConnection->is_instagram_auth; 
                            $updateSocialConnection->save();
                        }else{
                            $updateSocialConnection = new UserSocialConnection;
                            $updateSocialConnection->user_id = $sp_id;
                            $updateSocialConnection->is_facebook_auth = $socialConnection->is_facebook_auth;
                            $updateSocialConnection->facebook_pages = $socialConnection->facebook_pages; 
                            $updateSocialConnection->facebook_page_id = $socialConnection->facebook_page_id; 
                            $updateSocialConnection->is_twitter_auth = $socialConnection->is_twitter_auth; 
                            $updateSocialConnection->is_linkedin_auth = $socialConnection->is_linkedin_auth; 
                            $updateSocialConnection->linkedin_page_id = $socialConnection->linkedin_page_id; 
                            $updateSocialConnection->is_youtube_auth = $socialConnection->is_youtube_auth; 
                            $updateSocialConnection->is_instagram_auth = $socialConnection->is_instagram_auth; 
                            $updateSocialConnection->save();
                        }
                    }
                    
                    
                    if($instantReward != null){
                        /* Update Instant Reward Settings */
                        $instantOfferReward = OfferReward::where('user_id', $sp_id)->where('channel_id', 2)->first();
                        if($instantOfferReward != null){
                            $instantOfferReward->type = $instantReward->type;
                            $instantOfferReward->details = $instantReward->details; 
                            $instantOfferReward->save();
                        }else{
                            $instantOfferReward = new OfferReward;
                            $instantOfferReward->user_id = $sp_id;
                            $instantOfferReward->channel_id = 2;
                            $instantOfferReward->type = $instantReward->type;
                            $instantOfferReward->details = $instantReward->details; 
                            $instantOfferReward->save();
                        }
                    }
                    

                    if($shareReward != null){
                        /* Update Share Reward Settings */
                        $shareOfferReward = OfferReward::where('user_id', $sp_id)->where('channel_id', 3)->first();
                        if($shareOfferReward != null){
                            $shareOfferReward->type = $shareReward->type;
                            $shareOfferReward->details = $shareReward->details; 
                            $shareOfferReward->save();
                        }else{
                            $shareOfferReward = new OfferReward;
                            $shareOfferReward->user_id = $sp_id;
                            $shareOfferReward->channel_id = 3;
                            $shareOfferReward->type = $shareReward->type;
                            $shareOfferReward->details = $shareReward->details; 
                            $shareOfferReward->save();
                        }
                    }

                    /* Update Social Links in Settings */
                    // $businessDetails = BusinessDetail::where('user_id', $salesAdmin->id)->first();
                    // // Log::debug($businessDetails);
                    // if($businessDetails != null){
                    //     $salePersonBizDetails = BusinessDetail::where('user_id', $sp_id)->first();
                    //     $business_uuid = $salePersonBizDetails->uuid;
                    //     $whatsapp_num = $salePersonBizDetails->whatsapp_number;

                    //     if($salePersonBizDetails != null){
                    //         $salePersonBizDetails = $businessDetails->replicate();
                    //         $salePersonBizDetails->user_id = $sp_id;
                    //         $salePersonBizDetails->uuid = $business_uuid;
                    //         $salePersonBizDetails->user_id = $sp_id;
                    //         $salePersonBizDetails->save();
                    //     }
                    // }
                }
            }
        }
        
    }
}
