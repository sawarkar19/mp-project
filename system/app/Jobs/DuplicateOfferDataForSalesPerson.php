<?php

namespace App\Jobs;

use File;
use Image;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\Platform;
use App\Models\SocialPost;
use App\Models\InstantTask;
use App\Models\OfferTemplate;
use Illuminate\Bus\Queueable;
use App\Models\SocialPlatform;
use App\Models\OfferGalleryImage;
use Illuminate\Support\Facades\DB;
use App\Models\OfferTemplateButton;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\OfferTemplateContent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DuplicateOfferDataForSalesPerson implements ShouldQueue
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
        $user = User::where('id', $this->userId)->first();
        $salesAdmin = User::where('is_sales_person', 1)->where('is_sales_admin', 1)->where('status', 1)->first();
        
        /* Duplicate Offer */
        DB::beginTransaction();

        try {
            $offer = Offer::where('user_id', $salesAdmin->id)->where('start_date', '=', date("Y-m-d"))->first();
            
            if($offer != null){

                $newOffer = Offer::where('user_id', $user->id)->where('start_date', '=', $offer->start_date)->first();

                if($newOffer != null){
                    $newOffer->title = $offer->title;
                    $newOffer->description = $offer->description;
                    $newOffer->image = $offer->image;
                    $newOffer->website_url = $offer->website_url;
                    $newOffer->show_header = $offer->show_header;
                    $newOffer->show_footer = $offer->show_footer;
                    $newOffer->theme = $offer->theme;
                    $newOffer->start_date = $offer->start_date;
                    $newOffer->end_date = $offer->end_date;
                }else{  
                    $newOffer=$offer->replicate();

                    $newOffer->user_id = $user->id;
                    $newOffer->title = $offer->title;
                    $newOffer->status = 1;
                    $newOffer->created_at = Carbon::now();
                    $newOffer->updated_at = Carbon::now();
                }

                if($newOffer->save()){
                    
                    // CREATE COPY OF TEMPLATE
                    if($offer->type == 'custom'){
                        if($offer->website_url != ''){
                        }else{

                            if(file_exists(('assets/templates/custom/'.$offer->image))){
                                // echo file_exists(('assets/templates/custom/'.$offer->image));

                                $offerImgName = pathinfo(asset('assets/templates/custom')."/".$offer->image, PATHINFO_FILENAME);
                                $offerImgExt = pathinfo(asset('assets/templates/custom')."/".$offer->image, PATHINFO_EXTENSION);

                                // DB COLUMN
                                $newOffer->image = "custom-offer-".date('dmYhis',time()).".".$offerImgExt;
                                
                                $oldOfferCustomImageFolder = $folderPath = base_path('../assets/templates/custom/');
                                $oldOfferCustomImagePath = $oldOfferCustomImageFolder.$offer->image;
                                $newOfferCustomImagePath = $oldOfferCustomImageFolder.$newOffer->image;

                                if (File::copy($oldOfferCustomImagePath , $newOfferCustomImagePath)){
                                    $this->_createShareThumbnail("custom", $newOffer->image, $offerImgExt);
                                }
                                else{
                                    DB::rollback();
                                }
                            }
                            else{
                                $newOffer->image = $offer->image;
                                $newOffer->save();
                            }
                        }
                    }
                    else{
                        $offertemp = OfferTemplate::whereOfferId($offer->id)->first();
                        
                        $newOfferTemplates=[];
                        $newOfferTemplates=$offertemp->replicate();
                        $newOfferTemplates->offer_id = $newOffer->id;
                        $newOfferTemplates->slug = $offertemp->slug;

                        if(!empty($offertemp->thumbnail)){
                        
                            if(file_exists(('assets/offer-thumbnails/'.$offertemp->thumbnail))){
                                
                                $offerThumbnailName = pathinfo(asset('assets/offer-thumbnails')."/".$offertemp->thumbnail, PATHINFO_FILENAME);
                                $offerThumbnailExt = pathinfo(asset('assets/offer-thumbnails')."/".$offertemp->thumbnail, PATHINFO_EXTENSION);
                                
                                // DB COLUMN
                                $newOfferTemplates->thumbnail = "thumb-".date('dmYhis',time()).".".$offerThumbnailExt;

                                $oldOfferThumbnailImageFolder = base_path('../assets/offer-thumbnails/');
                                $oldOfferThumbnailImagePath = $oldOfferThumbnailImageFolder.$offertemp->thumbnail;
                                $newOfferThumbnailImagePath = $oldOfferThumbnailImageFolder.$newOfferTemplates->thumbnail;

                                if (\File::copy($oldOfferThumbnailImagePath , $newOfferThumbnailImagePath)){
                                    $this->_createShareThumbnail("standard", $newOfferTemplates->thumbnail, $offerThumbnailExt);
                                }
                                else{
                                    DB::rollback();
                                }
                            }
                            else{
                                $newOfferTemplates->thumbnail = $offertemp->thumbnail;
                            }
                        }
                        else{
                            $newOfferTemplates->thumbnail = $offertemp->thumbnail;
                        }
                        
                        if(!empty($offertemp->bg_image)){

                            if(file_exists(('assets/templates/'.$offertemp->slug.'/'.$offertemp->bg_image))){

                                $offerBgImageName = pathinfo(asset('assets/templates/').$offertemp->slug."/".$offertemp->bg_image, PATHINFO_FILENAME);
                                $offerBgImagelExt = pathinfo(asset('assets/templates/').$offertemp->slug."/".$offertemp->bg_image, PATHINFO_EXTENSION);
                                
                                // DB COLUMN
                                $newOfferTemplates->bg_image = "background-".date('dmYhis',time()).".".$offerBgImagelExt;

                                $oldOfferBgImageFolder = base_path('../assets/templates/').$offertemp->slug."/";
                                $oldOfferBgImagePath = $oldOfferBgImageFolder.$offertemp->bg_image;
                                $newOfferBgImagePath = $oldOfferBgImageFolder.$newOfferTemplates->bg_image;

                                if (\File::copy($oldOfferBgImagePath , $newOfferBgImagePath)){}
                                else{
                                    DB::rollback();
                                }
                            }
                            else{
                                $newOfferTemplates->bg_image = $offertemp->bg_image;
                            }
                        }
                        else{
                            $newOfferTemplates->bg_image = $offertemp->bg_image;
                        }

                        if(!empty($offertemp->hero_image)){

                            if(file_exists(('assets/templates/'.$offertemp->slug.'/'.$offertemp->hero_image))){
                                $offerHeroImageName = pathinfo(asset('assets/templates/').$offertemp->slug."/".$offertemp->hero_image, PATHINFO_FILENAME);
                                $offerHeroImagelExt = pathinfo(asset('assets/templates/').$offertemp->slug."/".$offertemp->hero_image, PATHINFO_EXTENSION);
                                
                                // DB COLUMN
                                $newOfferTemplates->hero_image = "hero_image-".date('dmYhis',time()).".".$offerHeroImagelExt;

                                $oldOfferHeroImageFolder = base_path('../assets/templates/').$offertemp->slug."/";
                                $oldOfferHeroImagePath = $oldOfferHeroImageFolder.$offertemp->hero_image;
                                $newOfferHeroImagePath = $oldOfferHeroImageFolder.$newOfferTemplates->hero_image;

                                if (\File::copy($oldOfferHeroImagePath , $newOfferHeroImagePath)){}
                                else{
                                    DB::rollback();
                                }
                            }
                            else{
                                $newOfferTemplates->hero_image = $offertemp->hero_image;
                            }
                        }
                        else{
                            $newOfferTemplates->hero_image = $offertemp->hero_image;
                        }

                        $newOfferTemplates->hero_title = $offertemp->hero_title;
                        $newOfferTemplates->hero_text = $offertemp->hero_text;
                        $newOfferTemplates->status = 1;
                        $newOfferTemplates->created_at = Carbon::now();
                        $newOfferTemplates->updated_at = Carbon::now();
                        $newOfferTemplates->save();

                        // OFFER TEMPLATE CONTENT
                        $offerTemplateContent = OfferTemplateContent::whereOfferTemplateId($offertemp->id)->get(); 
                        foreach ($offerTemplateContent as $contentKey => $content) {
                            $newOfferTemplatesContent=[];
                            $newOfferTemplatesContent=$content->replicate();
                            $newOfferTemplatesContent->offer_template_id = $newOfferTemplates->id;
                            $newOfferTemplatesContent->created_at = Carbon::now();
                            $newOfferTemplatesContent->updated_at = Carbon::now();

                            $newOfferTemplatesContent->save();
                        }

                        // OFFER TEMPLATE BUTTON
                        $offerTemplateButtons = OfferTemplateButton::whereOfferTemplateId($offertemp->id)->get(); 
                        foreach ($offerTemplateButtons as $contentKey => $button) {
                            $newOfferTemplatesButton=[];
                            $newOfferTemplatesButton=$button->replicate();
                            $newOfferTemplatesButton->offer_template_id = $newOfferTemplates->id;
                            $newOfferTemplatesButton->created_at = Carbon::now();
                            $newOfferTemplatesButton->updated_at = Carbon::now();

                            $newOfferTemplatesButton->save();
                        }

                        // OFFER GALLERY IMAGES
                        $offerGalleryImage = OfferGalleryImage::whereOfferTemplateId($offertemp->id)->get();
                        foreach ($offerGalleryImage as $galleryImageKey => $galleryImage) {
                            $newOfferGalleryImage=[];
                            $newOfferGalleryImage=$galleryImage->replicate();
                            $newOfferGalleryImage->offer_template_id = $newOfferTemplates->id;

                            if(!empty($galleryImage->image_path)){
                                if(file_exists(('assets/templates/'.$offertemp->slug.'/'.$galleryImage->image_path))){
                                    $offerGalleryImageName = pathinfo(asset('assets/templates/').$offertemp->slug."/".$galleryImage->image_path, PATHINFO_FILENAME);
                                    $offerGalleryImagelExt = pathinfo(asset('assets/templates/').$offertemp->slug."/".$galleryImage->image_path, PATHINFO_EXTENSION);
                                    
                                    // DB COLUMN
                                    $newOfferTemplates->image_path = "image_path-".date('dmYhis',time()).".".$offerGalleryImagelExt;

                                    $oldOfferGalleryImageFolder = base_path('../assets/templates/').$offertemp->slug."/";
                                    $oldOfferGalleryImagePath = $oldOfferGalleryImageFolder.$galleryImage->image_path;
                                    $newOfferGalleryImagePath = $oldOfferGalleryImageFolder.$newOfferTemplates->image_path;

                                    if (\File::copy($oldOfferGalleryImagePath , $newOfferGalleryImagePath)){}
                                    else{
                                        DB::rollback();
                                    }
                                }
                                else{
                                    $newOfferTemplates->image_path = $galleryImage->image_path;
                                }
                            }
                            else{
                                $newOfferTemplates->image_path = $galleryImage->image_path;
                            }

                            $newOfferGalleryImage->created_at = Carbon::now();
                            $newOfferGalleryImage->updated_at = Carbon::now();
                            $newOfferGalleryImage->save();
                        }
                    }
                    
                    $newOffer->uuid = 'SHR'.$user->id.'F'.$newOffer->id;
                    $newOffer->save();

                    /* Duplicate Social Post */
                    $socialPost = new SocialPost;
                    $socialPost->user_id = $user->id;
                    $socialPost->offer_id = $newOffer->id;
                    $socialPost->save();

                    if($socialPost){
                        $this->createSocialPlatforms($socialPost);
                    }

                    /* Duplicate Instant Task */
                    $taskIds = InstantTask::where('offer_id', $offer->id)->pluck('id')->toArray();
                    if(!empty($taskIds)){
                        foreach($taskIds as $taskId){
                            $task = InstantTask::find($taskId);

                            $newTask = $task->replicate();
                            $newTask->user_id = $user->id;
                            $newTask->offer_id = $newOffer->id;
                            $newTask->save();
                        }
                    }
                
                    // $newOffer=$offer->replicate();

                    DB::commit();

                    
                }
            }
            
        } catch (Exception $e) {
            DB::rollback();
        }
        
        // Log::debug("Hi");
    }

    private function _createShareThumbnail($type, $fileName, $extension){
        if($type=="custom"){
            $folderPath = base_path('../assets/templates/custom/');
            $newIamgeName = "share-custom-offer-";
            $ext = ".".$extension;
        }
        else{
            $folderPath = base_path('../assets/offer-thumbnails/');
            $newIamgeName = "share-thumb-";
            $ext = '.jpg';
        }
        $file = $folderPath . $fileName;

        //Resize image here
        $resize_name = $newIamgeName.date('dmYhis',time()).$ext;
        $resize_path = $folderPath . $resize_name;
        $small_img = Image::make($file)->resize(400, null, function($constraint) {
            $constraint->aspectRatio();
        });
        $small_img->save($resize_path);
        return true;
    }

    public function createSocialPlatforms($socialPost = null){
        $post = SocialPost::find($socialPost->id);
        $platforms = Platform::where('status', 1)->get();

        foreach($platforms as $platform){
            $socialPlatform = SocialPlatform::where('social_post_id', $post->id)->where('platform_key', $platform->name)->first();
            if($socialPlatform == null){
                $socialPlatform = new SocialPlatform;
                $socialPlatform->social_post_id = $post->id;
                $socialPlatform->platform_key = $platform->name;
            }
            $socialPlatform->value = $this->platformKey(10);
            $socialPlatform->save();
        }
    }

    public function platformKey($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $platformKey = '';
        for ($i = 0; $i < $length; $i++) {
            $platformKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $platformKey;
    }

}
