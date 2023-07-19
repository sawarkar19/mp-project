<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Offer;
use App\Models\OfferTemplate;
use App\Models\SocialPost;

use Carbon\Carbon;
use Image;
use File;
use URL;

class ManageMediaPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $offer;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($offer)
    {
        $this->offer = $offer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Post offer to Social Media Domain[managemedia.com]
        $url = $img_url = "";

        if($this->offer->type=='standard'){
            $offerTemplate = OfferTemplate::where('offer_id', $this->offer->id)->first();
            // $img_url = 'assets/offer-thumbnails/'.$offerTemplate->thumbnail;
            $img_url = $this->reduceImage1080("standard", $offerTemplate->thumbnail);
            $img_url = "assets/templates/resize-file/".$img_url;
        }
        else{
            if($this->offer->website_url != ''){
                $img_url = "";
                $url = $this->offer->website_url;
            }else{
                // $img_url = 'assets/templates/custom/'.$this->offer->image;
                $img_url = $this->reduceImage1080("custom", $this->offer->image);
                $img_url = "assets/templates/resize-file/".$img_url;
            }
        }
        
        // GET Social Platforms
        $socialPlatform = SocialPost::with('social_platforms')->where('offer_id', $this->offer->id)->first();

        $facebook_url = "";
        $twitter_url = "";
        $linkedin_url = "";

        foreach ($socialPlatform->social_platforms as $platformKey => $platform) {
            if($this->offer->website_url == ''){
                if($platform->platform_key == "facebook"){
                    $facebook_url = URL::to('/f').'/'.$this->offer->uuid.'?media='.$platform->value;
                }
                else if($platform->platform_key == "twitter"){
                    $twitter_url = URL::to('/f').'/'.$this->offer->uuid.'?media='.$platform->value;
                }
                else if($platform->platform_key == "linkedin"){
                    $linkedin_url = URL::to('/f').'/'.$this->offer->uuid.'?media='.$platform->value;
                }
            }
            else{
                if($platform->platform_key == "facebook"){
                    $facebook_url = $this->offer->website_url.'?media='.$platform->value;
                }
                else if($platform->platform_key == "twitter"){
                    $twitter_url = $this->offer->website_url.'?media='.$platform->value;
                }
                else if($platform->platform_key == "linkedin"){
                    $linkedin_url = $this->offer->website_url.'?media='.$platform->value;
                }
            }
        }
        
        if($this->offer->social_post__db_id==NULL){
            // New Create Post
            $postParams = [
                'offer_id' => $this->offer->id,
                'name' => $this->offer->title,
                'message' => $this->offer->description,
                'url' => $url,
                'single_image' => $img_url,
                'user_id' => $this->offer->user_id,
                'start_date' => $this->offer->start_date,
                'end_date' => $this->offer->end_date,
                'facebook_url' => $facebook_url,
                'twitter_url' => $twitter_url,
                'linkedin_url' => $linkedin_url,
            ];
            app('App\Http\Controllers\Business\SocialConnectController')->createOfferDesignPostUsingCron($postParams);
        }
        else{
            // Update Post
            $postParams = [
                'offer_id' => $this->offer->id,
                'name' => $this->offer->title,
                'message' => $this->offer->description,
                'single_image' => $img_url,
                'url' => $url,
                'post_id' => $this->offer->social_post__db_id,
                'user_id' => $this->offer->user_id,
                'start_date' => $this->offer->start_date,
                'end_date' => $this->offer->end_date,
                'facebook_url' => $facebook_url,
                'twitter_url' => $twitter_url,
                'linkedin_url' => $linkedin_url,
            ];
            app('App\Http\Controllers\Business\SocialConnectController')->updateOfferDesignPostUsingCron($postParams);
        }
    }

    // also define in OfferController
    public function reduceImage1080($type, $imagename)
    {
        $width = $height = 1080;
        $fullPath = $resize_name ="";
        if($type=="custom"){
            $fullPath = base_path('../assets/templates/custom/'.$imagename);
        }
        else{
            $fullPath = base_path('../assets/offer-thumbnails/'.$imagename);
        }
        
        if (file_exists($fullPath)) {
            $folderPath = base_path('../assets/templates/resize-file/');
            if(!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            
            $copy_image = 'copy-'.$imagename;
            File::copy($fullPath, $folderPath.$copy_image);
            
            $resize_name = 'resize'.'-'.$imagename;
            
            $resizeFolderPath = base_path('assets/templates/resize-file/');
            $resize_path = $folderPath . $resize_name;
            $small_img = Image::make($folderPath.$copy_image)->resize(1080, 1080, function($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save($resize_path);

            $img    = Image::make($resize_path);
            $width  = $img->width();
            $height = $img->height();

            $resizeWidth = $small_img->width();
            $resizeHeight = $small_img->height();

            /* canvas start */
            $dimension = 1080;
            $vertical   = (($width < $height) ? true : false);
            $horizontal = (($width > $height) ? true : false);
            // $vertical   = $horizontal = true;
            $square     = (($width = $height) ? true : false);

            if($type!="custom")
            {
                if ($square) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = ($dimension) - ($left + $right);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                else if ($vertical) {
                    // if($type=="custom")
                    // {
                        $newSize = ($dimension - $resizeHeight) / 2;
                        $top = $bottom = $newSize;
                        $newHeight = ($dimension) - ($bottom + $top);
                        $img->resize(null, $newHeight, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    // }
                } else if ($horizontal) {
                    // if($type=="custom")
                    // {
                        $newSize = ($dimension - $resizeWidth) / 2;
                        $right = $left = $newSize;
                        $newWidth = ($dimension) - ($right + $left);
                        $img->resize($newWidth, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    // }
                }

                $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff');
                $img->save($folderPath.$resize_name);
                /* canvas end */
            }
            else{
                if ($square) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = ($dimension) - ($left + $right);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                else if ($vertical) {
                    $newSize = ($dimension - $resizeHeight) / 2;
                    $top = $bottom = $newSize;
                    $newHeight = ($dimension) - ($bottom + $top);
                    $img->resize(null, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else if ($horizontal) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = ($dimension) - ($right + $left);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff');
                $img->save($folderPath.$resize_name);
            }
            
            @unlink($folderPath.$copy_image);
        }
        return $resize_name;
    }
}
