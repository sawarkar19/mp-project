<?php

namespace App\Http\Controllers\Business;

use DB;
use URL;
use Auth;
use File;
use Config;
use Image;
use Redirect;
use DOMDocument;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\InstantTask;
use App\Models\State;
use App\Models\Platform;
use App\Models\Template;
use Carbon\CarbonPeriod;

use App\Models\SocialPost;
use Illuminate\Http\Request;
use App\Models\OfferTemplate;
use App\Models\BusinessDetail;
use App\Models\SocialPlatform;
use App\Models\TemplateContent;
use App\Models\OfferGalleryImage;
use App\Models\UserChannel;
use App\Models\SocialOfferCount;

use App\Models\OfferTemplateButton;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Http\Controllers\Controller;
use App\Jobs\OfferPostToSocialMedia;
use App\Models\OfferTemplateContent;
use App\Models\UserSocialConnection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DuplicateOfferDataForSalesPerson;
use App\Http\Controllers\Business\CommonSettingController;

use App\Jobs\MakeSocialPostThumbnailImageJob;
use App\Jobs\ShareNewOfferLinkJob;
class OfferController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function customise(Request $request, $id)
    {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        $offer_create_id = $_GET['offer_create_id'];

        $standard_offer_data = Session::get('standard_offer_data_' . $offer_create_id);
        if ($standard_offer_data == null) {
            $standard_offer_data = [];
        }
        // dd($standard_offer_data);

        $video_id = $offer_id = $template_url = '';
        $business = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        if ($request->action == 'edit') {
            $change_template = true;
            if ($request->offer_id) {
                $offer_id = $request->offer_id;
                $template = Template::with('gallery', 'content', 'button')
                    ->where('id', $id)
                    ->orderBy('id', 'desc')
                    ->first();

                $action = route('business.offerSaveStandard');
            } else {
                $offer = Offer::find($id);
                $template = OfferTemplate::with('gallery', 'content', 'button')
                    ->where('offer_id', $offer->id)
                    ->orderBy('id', 'desc')
                    ->first();
                $offer_id = $id;
                $id = $template->slug;

                $action = route('business.offerSaveStandard', ['offer_id' => $offer_id]);
            }

            $template_url = route('business.designOffer.templates', ['offer_id' => $offer_id, 'action' => 'edit']);
        } else {
            $change_template = false;
            $template = Template::with('gallery', 'content', 'button')
                ->where('id', $id)
                ->orderBy('id', 'desc')
                ->first();

            $action = route('business.offerSaveStandard');
        }

        $template->contact_icons = json_decode($template->contact_icons);
        if ($template->video_url != null) {
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode('/', parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            } else {
                $video_params = explode('?v=', $template->video_url);
                $video_id = $video_params[1];
            }
        }

        $g = $t = 1;
        $gallery_color_titles = $tag_1_bg_colors = $tag_2_bg_colors = [];
        foreach ($template->gallery as $key => $gallery) {
            //Image Title Color
            if (isset($gallery->title_color) && $gallery->title_color != '') {
                $gallery_color_titles[$g] = $gallery->title_color;
            } else {
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if (isset($gallery->tag_1_bg_color) && $gallery->tag_1_bg_color != '') {
                $tag_1_bg_colors[$t] = $gallery->tag_1_bg_color;
            } else {
                $tag_1_bg_colors[$t] = '#ed3535';
            }

            if (isset($gallery->tag_2_bg_color) && $gallery->tag_2_bg_color != '') {
                $tag_2_bg_colors[$t] = $gallery->tag_2_bg_color;
            } else {
                $tag_2_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }

        //Text Content Color
        $text_colors = [];
        $c = 1;
        foreach ($template->content as $key => $text) {
            if (isset($text->content_color) && $text->content_color != '') {
                $text_colors[$c] = $text->content_color;
            } else {
                $text_colors[$c] = '#000000';
            }

            $c++;
        }

        //Button Color
        $button_colors = $button_bg_colors = $btn_style_types = [];
        $b = 1;
        foreach ($template->button as $key => $button) {
            if (isset($button->btn_text_color) && $button->btn_text_color != '') {
                $button_colors[$b] = $button->btn_text_color;
            } else {
                $button_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_color) && $button->btn_style_color != '') {
                $button_bg_colors[$b] = $button->btn_style_color;
            } else {
                $button_bg_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_type) && $button->btn_style_type != '') {
                $btn_style_types[$b] = $button->btn_style_type;
            } else {
                $btn_style_types[$b] = 'Background';
            }

            $b++;
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('builder.t-build', compact('id', 'business', 'template', 'offer_id', 'video_id', 'action', 'notification_list', 'planData', 'gallery_color_titles', 'tag_1_bg_colors', 'tag_2_bg_colors', 'change_template', 'template_url', 'text_colors', 'button_colors', 'btn_style_types', 'button_bg_colors', 'standard_offer_data'));
    }

    // also define in JOB => ManageMediaPost
    public function reduceImage1080($type, $imagename)
    {
        ini_set('memory_limit', '256M');
        $width = $height = 1080;
        $fullPath = $resize_name = '';
        if ($type == 'custom') {
            $fullPath = 'assets/templates/custom/' . $imagename;
        } else {
            $fullPath = 'assets/offer-thumbnails/' . $imagename;
        }

        if (file_exists($fullPath)) {
            $folderPath = base_path('../assets/templates/resize-file/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $copy_image = 'copy-' . $imagename;
            File::copy($fullPath, $folderPath . $copy_image);
            $resize_name = 'resize' . '-' . $imagename;
            $resize_path = $folderPath . $resize_name;
            $small_img = Image::make($folderPath . $copy_image)->resize(1080, 1080, function ($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save($resize_path);

            $img = Image::make($resize_path);
            $width = $img->width();
            $height = $img->height();

            $resizeWidth = $small_img->width();
            $resizeHeight = $small_img->height();

            /*
             *  canvas
             */
            $dimension = 1080;
            $vertical = $width < $height ? true : false;
            $horizontal = $width > $height ? true : false;
            // $vertical   = $horizontal = true;
            $square = ($width = $height) ? true : false;

            if ($type != 'custom') {
                if ($square) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = $dimension - ($left + $right);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($vertical) {
                    // if($type=="custom")
                    // {
                    $newSize = ($dimension - $resizeHeight) / 2;
                    $top = $bottom = $newSize;
                    $newHeight = $dimension - ($bottom + $top);
                    $img->resize(null, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // }
                } elseif ($horizontal) {
                    // if($type=="custom")
                    // {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = $dimension - ($right + $left);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    // }
                }

                $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff');
                $img->save($folderPath . $resize_name);
                /*
                 * canvas
                 */
            } else {
                if ($square) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = $dimension - ($left + $right);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($vertical) {
                    $newSize = ($dimension - $resizeHeight) / 2;
                    $top = $bottom = $newSize;
                    $newHeight = $dimension - ($bottom + $top);
                    $img->resize(null, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } elseif ($horizontal) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = $dimension - ($right + $left);
                    $img->resize($newWidth, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff');
                $img->save($folderPath . $resize_name);
            }

            @unlink($folderPath . $copy_image);
        }
        return $resize_name;
    }

    public function store(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        /* Validate Data */
        $validatedData = $request->validate([
            'title' => 'required|min:3|max:60',
            'description' => 'required|min:3|max:160',
        ]);

        $validate = $this->validateOffer($request);
        if ($validate['status'] == false) {
            return response()->json(['status' => false, 'message' => $validate['message']]);
        }
        $user_id = Auth::id();

        $set_start_date_null = null;
        $set_end_date_null = null;

        if ($request->start_date != '') {
            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');
            if ($request->offer_id) {
                $getOfferBetweenDate = Offer::where('id', '!=', $request->offer_id)
                    ->whereDate('start_date', '>=', $start_date)
                    ->whereDate('end_date', '<=', $end_date)
                    ->where('user_id', $user_id)
                    ->first();
            } else {
                $getOfferBetweenDate = Offer::whereDate('start_date', '>=', $start_date)
                    ->whereDate('end_date', '<=', $end_date)
                    ->where('user_id', $user_id)
                    ->first();
            }

            if ($getOfferBetweenDate != null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Already offer scheduled between this date',
                ]);
            }
        }

        if (Session('custom_template_' . $request->offer_create_id)) {
            $session = Session('custom_template_' . $request->offer_create_id);
            Session()->forget('custom_template_' . $request->offer_create_id);

            if ($request->offer_id) {
                $offer = Offer::find($request->offer_id);
                $socialPost = SocialPost::whereOfferId($request->offer_id)->first();
            } else {
                $offer = new Offer();
                $socialPost = new SocialPost();
            }

            $offer->title = $request->title;
            $offer->description = $request->description;
            $offer->user_id = $user_id;
            $offer->type = 'custom';
            $offer->image = $session['image'] ?? '';
            $offer->website_url = $session['website_url'] ?? '';

            if ($session['website_url'] != '') {
                $offer->website_meta_image = $this->getUrlMetaImage($session['website_url']);
            }

            $offer->show_header = $session['show_header'] ?? 0;
            $offer->show_footer = $session['show_footer'] ?? 0;
            $offer->theme = $session['theme'] ?? 'light';

            if ($request->start_date != '') {
                $offer->start_date = $request->start_date;
                $offer->end_date = $request->end_date;
            } else {
                $offer->start_date = $set_start_date_null;
                $offer->end_date = $set_end_date_null;
            }

            $offer->save();
            $offer->id;

            $socialPost->user_id = $user_id;
            $socialPost->offer_id = $offer->id;
            $socialPost->save();

            if ($socialPost) {
                $this->createSocialPlatforms($socialPost);
            }
        } else {
            if ($request->offer_id) {
                $offer = Offer::find($request->offer_id);
                $socialPost = SocialPost::whereOfferId($request->offer_id)->first();
            } else {
                $offer = new Offer();
                $socialPost = new SocialPost();
            }
            $offer->title = $request->title;
            $offer->description = $request->description;
            $offer->user_id = $user_id;
            $offer->type = 'standard';
            if ($request->start_date != '') {
                $offer->start_date = $request->start_date;
                $offer->end_date = $request->end_date;
            }

            $offer->save();

            $this->saveTemplate($request, $offer->id);

            $socialPost->user_id = $user_id;
            $socialPost->offer_id = $offer->id;
            $socialPost->save();

            if ($socialPost) {
                $this->createSocialPlatforms($socialPost);
            }
        }
        /* Update selected contact groups for share offer if null */
        $businessDetailS = BusinessDetail::where('user_id', $user_id)->first();
        if ($businessDetailS->selected_groups == null) {
            $contactGroup = ContactGroup::where('user_id', $user_id)
                ->pluck('id')
                ->toArray();
            $groups_id = implode(',', $contactGroup);
            $businessDetailS->selected_groups = $groups_id;
            $businessDetailS->save();
        }

        /* Add Entry for Social Counts */
        $socialOfferCount = new SocialOfferCount();
        $socialOfferCount->user_id = $user_id;
        $socialOfferCount->offer_id = $offer->id;
        $socialOfferCount->fb_comment_post_url_count = 0;
        $socialOfferCount->fb_like_post_url_count = 0;
        $socialOfferCount->fb_share_post_url_count = 0;
        $socialOfferCount->insta_like_post_url_count = 0;
        $socialOfferCount->insta_comment_post_url_count = 0;
        $socialOfferCount->tw_tweet_url_count = 0;
        $socialOfferCount->yt_like_url_count = 0;
        $socialOfferCount->yt_comment_url_count = 0;
        $socialOfferCount->save();

        if ($offer != null) {
            $offerId = Offer::find($offer->id);
            $offerId->uuid = 'SHR' . $user_id . 'F' . $offer->id;
            $offerId->save();
        }

        $share_offer_scheduled_date = date('Y-m-d', strtotime($request->start_date));
        $current_date = date('Y-m-d');

        /*send share offer sms if offer starts today after 10 AM*/
        /*check if sned share challenge on from personalised messaging for offer*/
        if($businessDetailS->send_when_start==1){

           if ($share_offer_scheduled_date == $current_date) {
                /*Update personalised messaging setting in business details*/
                $businessDetail = BusinessDetail::where('user_id', $user_id)->first();
                $businessDetail->share_offer_scheduled_date = $share_offer_scheduled_date;
                $businessDetail->save();

                /*check if user is paid*/
                $isUserPaid = User::where('id',$user_id)->where('role_id', 2)->where('status',1)->first();

                if($isUserPaid!=null && $isUserPaid->current_account_status=='paid'){
                    
                    /* Check Master Switch Personalised Message */
                    $activeSwitchPersonalised = UserChannel::where('channel_id', 5)->where('user_id',$isUserPaid->id)->where('status', 1)->first();
                    /* Check SMS routes on for Personalised Message */
                    $userActiveRoutes = MessageRoute::where('user_id', $isUserPaid->id)->where('channel_id', 5)->where('sms', 1)->first();

                    if($activeSwitchPersonalised!=null && $userActiveRoutes!=null){ 
                        
                            dispatch(new ShareNewOfferLinkJob($offer));

                    }
                }
            } 
        }
        
        // Manage media post

        // GET Social Platforms
        $socialPlatform = SocialPost::with('social_platforms')
            ->where('offer_id', $offer->id)
            ->first();

        $facebook_url = '';
        $twitter_url = '';
        $linkedin_url = '';

        foreach ($socialPlatform->social_platforms as $platformKey => $platform) {
            if ($offerId->website_url == '') {
                if ($platform->platform_key == 'facebook') {
                    $facebook_url = URL::to('/f') . '/' . $offerId->uuid . '?media=' . $platform->value;
                } elseif ($platform->platform_key == 'twitter') {
                    $twitter_url = URL::to('/f') . '/' . $offerId->uuid . '?media=' . $platform->value;
                } elseif ($platform->platform_key == 'linkedin') {
                    $linkedin_url = URL::to('/f') . '/' . $offerId->uuid . '?media=' . $platform->value;
                }
            } else {
                if ($platform->platform_key == 'facebook') {
                    $facebook_url = $offerId->website_url . '?media=' . $platform->value;
                } elseif ($platform->platform_key == 'twitter') {
                    $twitter_url = $offerId->website_url . '?media=' . $platform->value;
                } elseif ($platform->platform_key == 'linkedin') {
                    $linkedin_url = $offerId->website_url . '?media=' . $platform->value;
                }
            }
        }

        if ($offer->type == 'custom') {
            // Create a cURL handle
            $img_url = $url = '';
            if ($session['website_url'] != '') {
                $img_url = '';
                $url = $session['website_url'];
            } else {
                // $img_url = 'assets/templates/custom/'.$session['image'];
                $img_url = $this->reduceImage1080('custom', $session['image']);
                $img_url = 'assets/templates/resize-file/' . $img_url;

                // Save Social Post Images
                // $this->reduceImageSocialPost("custom", $session['image'], 'fb');
                // Show Full Image for Social Post thumbnail
                $hqImage = explode('custom-offer-', $session['image']);
                $hqNew = 'custom-offer-hq-' . $hqImage[1];

                if (!file_exists('assets/templates/custom/' . $hqNew)) {
                    // $this->reduceImageSocialPost("custom", $hqNew, 'fb');
                    dispatch(new MakeSocialPostThumbnailImageJob('custom', $hqNew, 'fb', $session['image']));
                    dispatch(new MakeSocialPostThumbnailImageJob('custom', $hqNew, 'tw', $session['image']));
                } else {
                    // $this->reduceImageSocialPost("custom", $session['image'], 'fb');
                    dispatch(new MakeSocialPostThumbnailImageJob('custom', $session['image'], 'fb', $session['image']));
                    dispatch(new MakeSocialPostThumbnailImageJob('custom', $session['image'], 'tw', $session['image']));
                }
            }

            if ($request->offer_id) {
                $postParams = [
                    'offer_id' => $offer->id,
                    'name' => $request['title'],
                    'message' => $request['description'],
                    'single_image' => $img_url,
                    'url' => $url,
                    'post_id' => $offer->social_post__db_id,
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'facebook_url' => $facebook_url,
                    'twitter_url' => $twitter_url,
                    'linkedin_url' => $linkedin_url,
                ];
                app('App\Http\Controllers\Business\SocialConnectController')->updateOfferDesignPost($postParams);
            } else {
                $postParams = [
                    'offer_id' => $offer->id,
                    'name' => $request['title'],
                    'message' => $request['description'],
                    'url' => $url,
                    'single_image' => $img_url,
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'facebook_url' => $facebook_url,
                    'twitter_url' => $twitter_url,
                    'linkedin_url' => $linkedin_url,
                ];

                app('App\Http\Controllers\Business\SocialConnectController')->createOfferDesignPost($postParams);
            }
        } else {
            $offerTemplate = OfferTemplate::where('offer_id', $offer->id)->first();
            // $img_url = 'assets/offer-thumbnails/'.$offerTemplate->thumbnail;
            $img_url = $this->reduceImage1080('standard', $offerTemplate->thumbnail);
            $img_url = 'assets/templates/resize-file/' . $img_url;

            // Save Social Post Images
            // $hqImage = explode("-", $offerTemplate->thumbnail);
            // $hqImageSting = ()

            // Show Full Image for Social Post thumbnail
            $hqImage = explode('-', $offerTemplate->thumbnail);
            $hqNew = $hqImage[0] . '-hq-' . $hqImage[1];
            if (!file_exists('assets/offer-thumbnails/' . $hqNew)) {
                // $this->reduceImageSocialPost("standard", $hqNew, 'fb');
                dispatch(new MakeSocialPostThumbnailImageJob('standard', $hqNew, 'fb', $offerTemplate->thumbnail));
                dispatch(new MakeSocialPostThumbnailImageJob('standard', $hqNew, 'tw', $offerTemplate->thumbnail));
            } else {
                // $this->reduceImageSocialPost("standard", $offerTemplate->thumbnail, 'fb');
                dispatch(new MakeSocialPostThumbnailImageJob('standard', $offerTemplate->thumbnail, 'fb', $offerTemplate->thumbnail));
                dispatch(new MakeSocialPostThumbnailImageJob('standard', $offerTemplate->thumbnail, 'tw', $offerTemplate->thumbnail));
            }

            if ($request->offer_id) {
                $postParams = [
                    'offer_id' => $offer->id,
                    'name' => $request['title'],
                    'message' => $request['description'],
                    'single_image' => $img_url,
                    'url' => '',
                    'post_id' => $offer->social_post__db_id,
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'facebook_url' => $facebook_url,
                    'twitter_url' => $twitter_url,
                    'linkedin_url' => $linkedin_url,
                ];
                app('App\Http\Controllers\Business\SocialConnectController')->updateOfferDesignPost($postParams);
            } else {
                $postParams = [
                    'offer_id' => $offer->id,
                    'name' => $request['title'],
                    'message' => $request['description'],
                    'url' => '',
                    'single_image' => $img_url,
                    'start_date' => $request['start_date'],
                    'end_date' => $request['end_date'],
                    'facebook_url' => $facebook_url,
                    'twitter_url' => $twitter_url,
                    'linkedin_url' => $linkedin_url,
                ];
                app('App\Http\Controllers\Business\SocialConnectController')->createOfferDesignPost($postParams);
            }
        }

        // offer post to social media using job
        // give schedule validation and today offer only here
        $todayDate = Carbon::now()->format('m/d/Y');
        // echo "befor date condition";
        $isConnected = 1;
        $isChannelActive = UserChannel::whereChannelId(1)
            ->whereUserId(Auth::id())
            ->first('status');
        if ($isChannelActive->status == 1) {
            if ($request->start_date != null && $request->end_date != null && ($todayDate >= $request->start_date && $todayDate <= $request->end_date)) {
                $userDetail = User::find($offer->user_id);
                if ($userDetail->social_post_api_token != null) {
                    // echo "befor auth key condition";
                    $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                    if ($userSocialConnection != null) {
                        if (($userSocialConnection->is_facebook_auth != null && $userSocialConnection->facebook_page_id != null) || $userSocialConnection->is_twitter_auth || ($userSocialConnection->is_linkedin_auth != null && $userSocialConnection->linkedin_page_id != null) || ($userSocialConnection->is_instagram_auth != null && $userSocialConnection->is_youtube_auth != null)) {
                            $offerInfo = Offer::find($offer->id);
                            if ($offerInfo->social_post__db_id != null && $offerInfo->is_social_post_created == 1) {
                                // $jobData=[
                                //     'user_id' => Auth::id(),
                                //     'offer_id' => $offerInfo->id,
                                //     'social_post_id' => $offerInfo->social_post__db_id,
                                // ];
                                // dispatch(new OfferPostToSocialMedia($jobData));

                                app('App\Http\Controllers\SocialMediaPostController')->onGoingOfferPost(Auth::id(), $offerInfo->id, $offerInfo->social_post__db_id);
                            }
                        } else {
                            $isConnected = 0;
                        }
                    } else {
                        $isConnected = 0;
                    }
                } else {
                    $isConnected = 0;
                }
            }
        }

        if ($isConnected == 1) {
            if ($offer->website_url != '') {
                $redirect_url = route('business.scriptPage', $offer->id);
            } else {
                $redirect_url = route('business.designOffer');
            }
        } else {
            $redirect_url = route('business.showSpcialConnectPopup');
        }

        /* Replicate if for all sales person */
        if (Auth::user()->is_sales_admin == 1 && date('Y-m-d', strtotime($request->start_date)) == date('Y-m-d')) {
            $salesPersonIds = User::where('is_sales_person', 1)
                ->where('is_sales_admin', 0)
                ->where('is_demo', 0)
                ->pluck('id')
                ->toArray();

            if (!empty($salesPersonIds)) {
                foreach ($salesPersonIds as $sp_id) {
                    dispatch(new DuplicateOfferDataForSalesPerson($sp_id));
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Offer Design Created Successfully!',
            'redirect_url' => $redirect_url,
        ]);
    }

    public function saveStandardOffer(Request $request)
    {
        $request_data = $request->all();
        // dd($request_data);
        //save to session
        $this->saveToSession($request_data);

        $image_types = $images = [];
        $files = $request->allFiles();

        if (!empty($files)) {
            foreach ($files as $k_file => $file) {
                $image_types[] = $k_file;
            }

            if (!empty($image_types)) {
                $images = $this->uploadOfferImage($request);
            }
        }

        if (!empty($image_types)) {
            $image_types[] = '_token';
            $data = $request->except($image_types);
        } else {
            $data = $request->except('_token');
        }

        Session(['template_data_' . $request->offer_create_id => $data, 'images_' . $request->offer_create_id => $images]);

        if (isset($request_data['offer_id'])) {
            return redirect()->route('business.enterOfferDetails', ['offer_id' => $request_data['offer_id'], 'create_id' => $request->offer_create_id]);
        } else {
            return redirect()->route('business.enterOfferDetails', ['create_id' => $request->offer_create_id]);
        }
    }

    public function saveToSession($request_data = [])
    {
        $data = [];

        $data['string_main_image'] = $request_data['string_main_image'];
        $data['string_background_image'] = $request_data['string_background_image'];
        $data['bg_type'] = $request_data['bg_type'];
        $data['background_color'] = $request_data['background_color'];
        $data['contact_icon_color'] = $request_data['contact_icon_color'];
        $data['whatsapp_icon_color'] = $request_data['whatsapp_icon_color'];
        $data['location_icon_color'] = $request_data['location_icon_color'];
        $data['website_icon_color'] = $request_data['website_icon_color'];
        $data['business_name_color'] = $request_data['business_name_color'];
        $data['tag_line_color'] = $request_data['tag_line_color'];
        $data['default_color'] = $request_data['default_color'];
        $data['video_url'] = $request_data['video_url'];

        for ($i = 1; $i < 30; $i++) {
            if (isset($request_data['string_image_' . $i])) {
                $data['string_image_' . $i] = $request_data['string_image_' . $i];
            }

            if (isset($request_data['text_content_' . $i])) {
                $data['text_content_' . $i] = $request_data['text_content_' . $i];
            }

            if (isset($request_data['text_content_color_' . $i])) {
                $data['text_content_color_' . $i] = $request_data['text_content_color_' . $i];
            }

            if (isset($request_data['image_' . $i . '_color'])) {
                $data['image_' . $i . '_color'] = $request_data['image_' . $i . '_color'];
            }

            if (isset($request_data['gallery_price_' . $i])) {
                $data['gallery_price_' . $i] = $request_data['gallery_price_' . $i];
            }

            if (isset($request_data['gallery_sale_price_' . $i])) {
                $data['gallery_sale_price_' . $i] = $request_data['gallery_sale_price_' . $i];
            }

            if (isset($request_data['tag_1_bg_' . $i . '_color'])) {
                $data['tag_1_bg_' . $i . '_color'] = $request_data['tag_1_bg_' . $i . '_color'];
            }

            if (isset($request_data['tag_2_bg_' . $i . '_color'])) {
                $data['tag_2_bg_' . $i . '_color'] = $request_data['tag_2_bg_' . $i . '_color'];
            }

            if (isset($request_data['image_title_' . $i])) {
                $data['image_title_' . $i] = $request_data['image_title_' . $i];
            }

            if (isset($request_data['cta_button_name_' . $i])) {
                $data['cta_button_name_' . $i] = $request_data['cta_button_name_' . $i];
            }

            if (isset($request_data['cta_button_url_' . $i])) {
                $data['cta_button_url_' . $i] = $request_data['cta_button_url_' . $i];
            }

            if (isset($request_data['cta_button_text_color_' . $i])) {
                $data['cta_button_text_color_' . $i] = $request_data['cta_button_text_color_' . $i];
            }

            if (isset($request_data['cta_button_bg_color_' . $i])) {
                $data['cta_button_bg_color_' . $i] = $request_data['cta_button_bg_color_' . $i];
            }

            if (isset($request_data['btn_style_type_' . $i])) {
                $data['btn_style_type_' . $i] = $request_data['btn_style_type_' . $i];
            }
        }

        // dd($request_data);
        Session([
            'standard_offer_data_' . $request_data['offer_create_id'] => $data,
        ]);
    }

    public function saveCustom(Request $request)
    {
        ini_set('memory_limit', '512M');
        // dd($request->all());

        $validate = $this->validateCustomOffer($request);
        if ($validate['status'] == false) {
            return response()->json(['status' => false, 'message' => $validate['message']]);
        }

        $fileName = $selected_file = '';
        $data = [];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $org_filename = $image->getClientOriginalName();
            $selected_file = $org_filename . '.' . $extension;

            $size = $image->getSize();

            $folderPath = base_path('../assets/templates/custom/');
            $image_parts = explode(';base64,', $request->imagestring);

            $image_time = time();

            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = 'custom-offer' . '-' . date('dmYhis', $image_time) . '.' . $extension;
            $file = $folderPath . $fileName;

            file_put_contents($file, $image_base64);

            $img = Image::make($file);
            $img->save($file);

            // Save High resolution Image
            $file_name_hq = 'custom-offer-hq-' . date('dmYhis', $image_time) . '.' . $extension;
            $file_hq = $folderPath . $file_name_hq;

            $success = Image::make($image_base64)->resize(3840, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $success->save($file_hq);

            //Resize image here
            $resize_name = 'share-' . $fileName;
            $resize_path = $folderPath . $resize_name;
            $small_img = Image::make($file)->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save($resize_path);
        }

        //save to session
        $data = [
            'offer_create_id' => $request->offer_create_id,
            'offer_id' => $request->offer_id,
            'website_url' => $request->website_url,
            'imagestring' => $request->imagestring,
            'show_header' => $request->show_header,
            'show_footer' => $request->show_footer,
            'theme' => $request->theme,
            'selected_file' => $selected_file,
        ];
        Session([
            'custom_offer_data_' . $request->offer_create_id => $data,
        ]);

        $offer_id = $request->offer_id;
        if ($offer_id != '') {
            $offer = Offer::findOrFail($offer_id);

            $redirect_url = route('business.enterOfferDetails', ['offer_id' => $offer_id, 'create_id' => $request->offer_create_id]);
        } else {
            $offer = '';
            $redirect_url = route('business.enterOfferDetails', ['create_id' => $request->offer_create_id]);
        }

        if ($request->website_url == '') {
            if ($offer != '' && $fileName == '') {
                $data['image'] = $offer->image;
            } elseif ($fileName != '') {
                $data['image'] = $fileName;
            }
            $data['theme'] = $request->theme;
            $data['show_header'] = $request->show_header;
            $data['show_footer'] = $request->show_footer;
            $data['website_url'] = '';
        } else {
            $data['image'] = '';
            $data['theme'] = 'light';
            $data['show_header'] = 0;
            $data['show_footer'] = 0;
            $data['website_url'] = $request->website_url;
        }

        Session(['custom_template_' . $request->offer_create_id => $data]);

        return response()->json([
            'status' => true,
            'message' => 'Saved!',
            'redirect_url' => $redirect_url,
        ]);
    }

    public function saveTemplate($request, $offer_id)
    {
        // dd(Session()->all());
        $sessionData = Session()->all();
        $images = Session('images_' . $request->offer_create_id);

        if (array_key_exists('same_color', $sessionData['template_data_' . $request->offer_create_id])) {
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['contact_icon_color'],
                'location_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['contact_icon_color'],
                'website_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['contact_icon_color'],
            ]);
        } else {
            $contact_icons = json_encode([
                'contact_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['contact_icon_color'],
                'whatsapp_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['whatsapp_icon_color'],
                'location_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['location_icon_color'],
                'website_icon_color' => $sessionData['template_data_' . $request->offer_create_id]['website_icon_color'],
            ]);
        }

        if ($request->offer_id) {
            $template = OfferTemplate::with('gallery', 'content', 'button')
                ->where('offer_id', $request->offer_id)
                ->orderBy('id', 'desc')
                ->first();
            $saveTemplate = $template;

            if ($template->slug != $sessionData['template_data_' . $request->offer_create_id]['template_id']) {
                $contentIds = OfferTemplateContent::where('offer_template_id', $template->id)
                    ->pluck('id')
                    ->toArray();
                OfferTemplateContent::destroy($contentIds);

                $galleryIds = OfferGalleryImage::where('offer_template_id', $template->id)
                    ->pluck('id')
                    ->toArray();
                OfferGalleryImage::destroy($galleryIds);

                OfferTemplate::findOrFail($template->id)->delete();

                $template = Template::with('gallery', 'content', 'button')
                    ->where('id', $sessionData['template_data_' . $request->offer_create_id]['template_id'])
                    ->orderBy('id', 'desc')
                    ->first();

                $saveTemplate = new OfferTemplate();
                $saveTemplate->offer_id = $offer_id;
                $saveTemplate->name = $template->name;
                $saveTemplate->slug = $template->slug;
            }
        } else {
            $template = Template::with('gallery', 'content', 'button')
                ->where('id', $sessionData['template_data_' . $request->offer_create_id]['template_id'])
                ->orderBy('id', 'desc')
                ->first();

            $saveTemplate = new OfferTemplate();
            $saveTemplate->offer_id = $offer_id;
            $saveTemplate->name = $template->name;
            $saveTemplate->slug = $template->slug;
        }

        $saveTemplate->thumbnail = $sessionData['template_data_' . $request->offer_create_id]['thumbnail'] ?? $template->thumbnail;

        $saveTemplate->video_url = $sessionData['template_data_' . $request->offer_create_id]['video_url'] ?? $template->video_url;
        if (isset($sessionData['template_data_' . $request->offer_create_id]['video_autoplay'])) {
            $saveTemplate->video_autoplay = '1' ?? $template->video_autoplay;
        }

        if ($sessionData['template_data_' . $request->offer_create_id]['bg_type'] != '') {
            if ($sessionData['template_data_' . $request->offer_create_id]['bg_type'] == 'image') {
                if (array_key_exists('background_image', $images)) {
                    $saveTemplate->bg_image = $images['background_image'];
                } else {
                    $saveTemplate->bg_color = $template->bg_image;
                }
            } else {
                $saveTemplate->bg_color = $sessionData['template_data_' . $request->offer_create_id]['background_color'];
            }
        } else {
            $saveTemplate->bg_image = $template->bg_image;
            $saveTemplate->bg_color = $template->bg_color;
        }

        $saveTemplate->default_color = $sessionData['template_data_' . $request->offer_create_id]['default_color'] ?? $template->default_color;

        $saveTemplate->business_name_color = $sessionData['template_data_' . $request->offer_create_id]['business_name_color'] ?? $template->business_name_color;
        $saveTemplate->tag_line_color = $sessionData['template_data_' . $request->offer_create_id]['tag_line_color'] ?? $template->tag_line_color;

        $saveTemplate->hero_image = $images['main_image'] ?? $template->hero_image;

        $saveTemplate->contact_icons = $contact_icons;
        $saveTemplate->save();

        if ($saveTemplate != null) {
            if (isset($template->content) && !empty($template->content)) {
                $offerTemplateContent = OfferTemplateContent::where('offer_template_id', $saveTemplate->id)->first();
                if ($offerTemplateContent != null) {
                    $i = 1;
                    foreach ($template->content as $content) {
                        $text = OfferTemplateContent::find($content->id);
                        $text->content = $sessionData['template_data_' . $request->offer_create_id]['text_content_' . $i] ?? $content->content;
                        $text->content_color = $sessionData['template_data_' . $request->offer_create_id]['text_content_color_' . $i] ?? $content->content_color;

                        $text->save();

                        $i++;
                    }
                } else {
                    $c = 0;
                    for ($i = 1; $i <= count($template->content); $i++) {
                        $text = new OfferTemplateContent();
                        $text->offer_template_id = $saveTemplate->id;
                        $text->content = $sessionData['template_data_' . $request->offer_create_id]['text_content_' . $i] ?? $template->content[$c]->content;
                        $text->content_color = $sessionData['template_data_' . $request->offer_create_id]['text_content_color_' . $i] ?? $template->content[$c]->content_color;

                        $text->save();

                        $c++;
                    }
                }
            }

            if (isset($template->button) && !empty($template->button)) {
                $offerTemplateButton = OfferTemplateButton::where('offer_template_id', $saveTemplate->id)->first();
                if ($offerTemplateButton != null) {
                    $i = 1;
                    foreach ($template->button as $button) {
                        $buttonData = OfferTemplateButton::find($button->id);
                        $buttonData->btn_style_type = $sessionData['template_data_' . $request->offer_create_id]['btn_style_type_' . $i] ?? $button->btn_style_type;
                        $buttonData->name = $sessionData['template_data_' . $request->offer_create_id]['cta_button_name_' . $i] ?? $button->name;
                        $buttonData->link = $sessionData['template_data_' . $request->offer_create_id]['cta_button_url_' . $i] ?? $button->link;
                        $buttonData->btn_text_color = $sessionData['template_data_' . $request->offer_create_id]['cta_button_text_color_' . $i] ?? $button->btn_text_color;
                        $buttonData->btn_style_color = $sessionData['template_data_' . $request->offer_create_id]['cta_button_bg_color_' . $i] ?? $button->btn_style_color;
                        $buttonData->is_hidden = $sessionData['template_data_' . $request->offer_create_id]['cta_button_hide_' . $i] ?? 0;

                        $buttonData->save();

                        $i++;
                    }
                } else {
                    $c = 0;
                    for ($i = 1; $i <= count($template->button); $i++) {
                        $buttonData = new OfferTemplateButton();
                        $buttonData->offer_template_id = $saveTemplate->id;
                        $buttonData->btn_style_type = $sessionData['template_data_' . $request->offer_create_id]['btn_style_type_' . $i] ?? 'Background';
                        $buttonData->name = $sessionData['template_data_' . $request->offer_create_id]['cta_button_name_' . $i] ?? $template->button[$c]->name;
                        $buttonData->link = $sessionData['template_data_' . $request->offer_create_id]['cta_button_url_' . $i] ?? $template->button[$c]->link;
                        $buttonData->btn_text_color = $sessionData['template_data_' . $request->offer_create_id]['cta_button_text_color_' . $i] ?? $template->button[$c]->btn_text_color;
                        $buttonData->btn_style_color = $sessionData['template_data_' . $request->offer_create_id]['cta_button_bg_color_' . $i] ?? $template->button[$c]->btn_style_color;
                        $buttonData->is_hidden = $sessionData['template_data_' . $request->offer_create_id]['cta_button_hide_' . $i] ?? 0;

                        $buttonData->save();

                        $c++;
                    }
                }
            }

            if (isset($template->gallery) && !empty($template->gallery)) {
                $offerGalleryImage = OfferGalleryImage::where('offer_template_id', $saveTemplate->id)->first();
                if ($offerGalleryImage != null) {
                    $i = 1;
                    foreach ($template->gallery as $gallery) {
                        $image = OfferGalleryImage::find($gallery->id);
                        $image->title = $sessionData['template_data_' . $request->offer_create_id]['image_title_' . $i] ?? $gallery->title;
                        $image->title_color = $sessionData['template_data_' . $request->offer_create_id]['image_' . $i . '_color'] ?? $gallery->title_color;

                        $image->tag_1 = $sessionData['template_data_' . $request->offer_create_id]['gallery_tag_1_' . $i] ?? $gallery->tag_1;
                        $image->tag_2 = $sessionData['template_data_' . $request->offer_create_id]['gallery_tag_2_' . $i] ?? $gallery->tag_2;
                        $image->tag_1_bg_color = $sessionData['template_data_' . $request->offer_create_id]['tag_1_bg_' . $i . '_color'] ?? $gallery->tag_1_bg_color;
                        $image->tag_2_bg_color = $sessionData['template_data_' . $request->offer_create_id]['tag_2_bg_' . $i . '_color'] ?? $gallery->tag_2_bg_color;
                        $image->price = $sessionData['template_data_' . $request->offer_create_id]['gallery_price_' . $i] ?? $gallery->price;
                        $image->sale_price = $sessionData['template_data_' . $request->offer_create_id]['gallery_sale_price_' . $i] ?? $gallery->sale_price;

                        $image->show_tag_1 = $gallery->show_tag_1;
                        $image->show_tag_2 = $gallery->show_tag_2;
                        $image->show_price = $gallery->show_price;
                        $image->show_sale_price = $gallery->show_sale_price;

                        if (array_key_exists('image_' . $i, $images)) {
                            $image->image_path = $images['image_' . $i];
                        } else {
                            $image->image_path = $gallery->image_path;
                        }

                        $image->save();

                        $i++;
                    }
                } else {
                    $g = 0;
                    for ($i = 1; $i <= count($template->gallery); $i++) {
                        $image = new OfferGalleryImage();
                        $image->offer_template_id = $saveTemplate->id;
                        $image->title = $sessionData['template_data_' . $request->offer_create_id]['image_title_' . $i] ?? $template->gallery[$g]->title;
                        $image->title_color = $sessionData['template_data_' . $request->offer_create_id]['image_' . $i . '_color'] ?? $template->gallery[$g]->title_color;

                        $image->tag_1 = $sessionData['template_data_' . $request->offer_create_id]['gallery_tag_1_' . $i] ?? $template->gallery[$g]->tag_1;
                        $image->tag_2 = $sessionData['template_data_' . $request->offer_create_id]['gallery_tag_2_' . $i] ?? $template->gallery[$g]->tag_2;
                        $image->tag_1_bg_color = $sessionData['template_data_' . $request->offer_create_id]['tag_1_bg_' . $i . '_color'] ?? $template->gallery[$g]->tag_1_bg_color;
                        $image->tag_2_bg_color = $sessionData['template_data_' . $request->offer_create_id]['tag_2_bg_' . $i . '_color'] ?? $template->gallery[$g]->tag_2_bg_color;
                        $image->price = $sessionData['template_data_' . $request->offer_create_id]['gallery_price_' . $i] ?? $template->gallery[$g]->price;
                        $image->sale_price = $sessionData['template_data_' . $request->offer_create_id]['gallery_sale_price_' . $i] ?? $template->gallery[$g]->sale_price;

                        $image->show_tag_1 = $template->gallery[$g]->show_tag_1;
                        $image->show_tag_2 = $template->gallery[$g]->show_tag_2;
                        $image->show_price = $template->gallery[$g]->show_price;
                        $image->show_sale_price = $template->gallery[$g]->show_sale_price;

                        if (array_key_exists('image_' . $i, $images)) {
                            $image->image_path = $images['image_' . $i];
                        } else {
                            $image->image_path = $template->gallery[$g]->image_path;
                        }

                        $image->save();

                        $g++;
                    }
                }
            }

            Session()->forget(['template_data_' . $request->offer_create_id, 'images_' . $request->offer_create_id]);
            return ['status' => true, 'message' => 'Template saved.'];
        } else {
            return ['status' => false, 'message' => 'Template not saved.'];
        }
    }

    public function saveThumbnail(Request $request)
    {
        ini_set('memory_limit', '512M');

        define('UPLOAD_DIR', 'assets/offer-thumbnails/');
        $img = $_POST['imgBase64'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $image_time = time();
        $file_name = 'thumb-' . date('dmYhis', $image_time) . '.jpg';
        $file = UPLOAD_DIR . $file_name;
        // $success = file_put_contents($file, $data);

        /* Main image upload */
        $success = Image::make($data)->resize(640, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $success->save($file);

        // Save High resolution Image
        $file_name_hq = 'thumb-hq-' . date('dmYhis', $image_time) . '.jpg';
        $file_hq = UPLOAD_DIR . $file_name_hq;

        $success = Image::make($data)->resize(3840, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $success->save($file_hq);

        //Resize image here
        $resize_name = 'share-' . $file_name;
        $resize_path = UPLOAD_DIR . $resize_name;
        $small_img = Image::make($file)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $small_img->save($resize_path);

        if ($success) {
            return response()->json(['status' => true, 'message' => 'Thumbnail Saved Successfully!', 'filename' => $file_name]);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to save the Thumbnail.', 'filename' => '']);
        }
    }

    public function updateYoutubeThumbnail(Request $request)
    {
        $default_path = asset('assets/img/broken-thumbnail.jpg');

        $disk = Storage::build([
            'driver' => 'local',
            'root' => 'assets/templates/' . $request->template_id . '/',
        ]);

        $url = 'https://img.youtube.com/vi/' . $request->video_id . '/hqdefault.jpg';

        if (@file_get_contents($url) == false) {
            return response()->json(['status' => false, 'message' => 'Thumbnail not found.', 'thumb_path' => $default_path]);
        }

        $contents = file_get_contents($url);
        $name = $request->video_id . '.jpg';

        $disk->put($name, $contents);

        $thumb_path = 'assets/templates/' . $request->template_id . '/' . $request->video_id . '.jpg';
        $send_path = asset('assets/templates/' . $request->template_id . '/' . $request->video_id . '.jpg');

        if (file_exists($thumb_path)) {
            return response()->json(['status' => true, 'message' => 'Thumbnail saved.', 'thumb_path' => $send_path]);
        } else {
            return response()->json(['status' => false, 'message' => 'Thumbnail not saved.', 'thumb_path' => $default_path]);
        }
    }

    public function uploadOfferImage($request)
    {
        $image_types = $images = [];
        $data = $request->all();

        $files = $request->allFiles();
        foreach ($files as $k_file => $file) {
            $image_types[] = $k_file;
        }

        foreach ($image_types as $image_file) {
            if ($request->hasFile($image_file)) {
                $image = $request->file($image_file);
                $extension = $image->getClientOriginalExtension();
                $size = $image->getSize();

                $extension = strtolower($extension);
                if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'png') {
                    if ($data['string_' . $image_file] != null) {
                        $folderPath = base_path('../assets/templates/' . $request->template_id . '/');

                        $image_parts = explode(';base64,', $data['string_' . $image_file]);
                        $image_type_aux = explode('image/', $image_parts[0]);

                        $image_type = $image_type_aux[1];
                        $image_base64 = base64_decode($image_parts[1]);
                        $fileName = $image_file . '-' . date('dmYhis', time()) . '.' . $extension;
                        $file = $folderPath . $fileName;
                        file_put_contents($file, $image_base64);
                        $img = Image::make($file);
                        $img->encode($extension, 75)->save($file);

                        $images[$image_file] = $fileName;
                    }
                } else {
                    $images[$image_file] = 'Offer Image File must be an image (jpg, jpeg or png).';
                }
            }
        }

        return $images;
    }

    public function edit($offer_id)
    {
        $offer = Offer::findOrFail($offer_id);

        if ($offer->type == 'custom') {
            return \Redirect::route('business.customOffer', ['id' => $offer_id, 'action' => 'edit', 'offer_create_id' => rand()]);
        } else {
            return \Redirect::route('business.offerCustomise', ['id' => $offer_id, 'action' => 'edit', 'offer_create_id' => rand()]);
        }
    }

    public function customOffer(Request $request)
    {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        $offer_create_id = $_GET['offer_create_id'];

        $custom_offer_data = Session::get('custom_offer_data_' . $offer_create_id);
        if ($custom_offer_data == null) {
            $custom_offer_data = [];
        }
        // dd($custom_offer_data);

        $offer_id = $action = $offer = '';
        if ($request->id) {
            $offer_id = $request->id;
            $action = $request->action;

            $offer = Offer::find($offer_id);
        }

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.custom', compact('notification_list', 'planData', 'offer_id', 'action', 'offer', 'custom_offer_data'));
    }

    public function templatePreview($id)
    {
        $show_meta = 0;
        $only_view = 0;
        $offer = '';
        $is_posted = '';
        
        $template = Template::with('gallery', 'content', 'button')
            ->where('id', $id)
            ->first();
        $business = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        $business['state'] = State::where('id', $business['state'])
            ->pluck('name')
            ->first();

        $template->contact_icons = json_decode($template->contact_icons);

        $video_id = '';
        if ($template->video_url != null) {
            $youtube_url = strpos($template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode('/', parse_url($template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            } else {
                $video_params = explode('?v=', $template->video_url);
                $video_id = $video_params[1];
            }
        }

        $g = $t = 1;
        $gallery_color_titles = $tag_1_bg_colors = $tag_2_bg_colors = [];
        foreach ($template->gallery as $key => $gallery) {
            //Image Title Color
            if (isset($gallery->title_color) && $gallery->title_color != '') {
                $gallery_color_titles[$g] = $gallery->title_color;
            } else {
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if (isset($gallery->tag_1_bg_color) && $gallery->tag_1_bg_color != '') {
                $tag_1_bg_colors[$t] = $gallery->tag_1_bg_color;
            } else {
                $tag_1_bg_colors[$t] = '#ed3535';
            }

            if (isset($gallery->tag_2_bg_color) && $gallery->tag_2_bg_color != '') {
                $tag_2_bg_colors[$t] = $gallery->tag_2_bg_color;
            } else {
                $tag_2_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }

        //Text Content Color
        $text_colors = [];
        $c = 1;
        foreach ($template->content as $key => $text) {
            if (isset($text->content_color) && $text->content_color != '') {
                $text_colors[$c] = $text->content_color;
            } else {
                $text_colors[$c] = '#000000';
            }

            $c++;
        }

        //Button Color
        $button_colors = $button_bg_colors = $btn_style_types = [];
        $b = 1;
        foreach ($template->button as $key => $button) {
            if (isset($button->btn_text_color) && $button->btn_text_color != '') {
                $button_colors[$b] = $button->btn_text_color;
            } else {
                $button_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_color) && $button->btn_style_color != '') {
                $button_bg_colors[$b] = $button->btn_style_color;
            } else {
                $button_bg_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_type) && $button->btn_style_type != '') {
                $btn_style_types[$b] = $button->btn_style_type;
            } else {
                $btn_style_types[$b] = 'Background';
            }

            $b++;
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $isShowPopup = 0;

        return view('builder.preview', compact('id', 'template', 'business', 'only_view', 'show_meta', 'video_id', 'notification_list', 'planData', 'gallery_color_titles', 'tag_1_bg_colors', 'tag_2_bg_colors', 'text_colors', 'offer', 'button_colors', 'button_bg_colors', 'btn_style_types', 'isShowPopup','is_posted'));
    }

    public function preview($offer_id)
    {
        $show_meta = $show_header = 1;
        $only_view = 0;

        $offer = Offer::with('offer_template')
            ->where('id', $offer_id)
            ->first();
        $is_posted = InstantTask::where('user_id', Auth::id())->where('offer_id', $offer->id)->whereNull('deleted_at')->count();    

        $business = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        $business['state'] = State::where('id', $business['state'])
            ->pluck('name')
            ->first();

        $offer->offer_template->contact_icons = json_decode($offer->offer_template->contact_icons);

        $video_id = '';
        if ($offer->offer_template->video_url != null) {
            $youtube_url = strpos($offer->offer_template->video_url, 'youtube.com');
            if ($youtube_url === false) {
                $uriSegments = explode('/', parse_url($offer->offer_template->video_url, PHP_URL_PATH));
                $video_id = array_pop($uriSegments);
            } else {
                $video_params = explode('?v=', $offer->offer_template->video_url);
                $video_id = $video_params[1];
            }
        }

        $g = $t = 1;
        $gallery_color_titles = $tag_1_bg_colors = $tag_2_bg_colors = [];
        foreach ($offer->offer_template->offer_gallery as $key => $gallery) {
            //Image Title Color
            if (isset($gallery->title_color) && $gallery->title_color != '') {
                $gallery_color_titles[$g] = $gallery->title_color;
            } else {
                $gallery_color_titles[$g] = '#000000';
            }

            $g++;

            //Tag Background Color
            if (isset($gallery->tag_1_bg_color) && $gallery->tag_1_bg_color != '') {
                $tag_1_bg_colors[$t] = $gallery->tag_1_bg_color;
            } else {
                $tag_1_bg_colors[$t] = '#ed3535';
            }

            if (isset($gallery->tag_2_bg_color) && $gallery->tag_2_bg_color != '') {
                $tag_2_bg_colors[$t] = $gallery->tag_2_bg_color;
            } else {
                $tag_2_bg_colors[$t] = '#ed3535';
            }

            $t++;
        }

        //Text Content Color
        $text_colors = [];
        $c = 1;
        foreach ($offer->offer_template->content as $key => $text) {
            if (isset($text->content_color) && $text->content_color != '') {
                $text_colors[$c] = $text->content_color;
            } else {
                $text_colors[$c] = '#000000';
            }

            $c++;
        }

        //Button Color
        $button_colors = $button_bg_colors = $btn_style_types = [];
        $b = 1;
        foreach ($offer->offer_template->button as $key => $button) {
            if (isset($button->btn_text_color) && $button->btn_text_color != '') {
                $button_colors[$b] = $button->btn_text_color;
            } else {
                $button_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_color) && $button->btn_style_color != '') {
                $button_bg_colors[$b] = $button->btn_style_color;
            } else {
                $button_bg_colors[$b] = '#000000';
            }

            if (isset($button->btn_style_type) && $button->btn_style_type != '') {
                $btn_style_types[$b] = $button->btn_style_type;
            } else {
                $btn_style_types[$b] = 'Background';
            }

            $b++;
        }

        $template = $offer->offer_template;
        $id = $template->slug;

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        // $currentOfferPosted =   Offer::with('getInstantTasks')
        //             ->has('getInstantTasks')
        //             ->where('id', $offer->id)
        //             ->where('user_id', Auth::id())
        //             ->orderBy('id', 'DESC')
        //             ->first();

        $isCurrentOfferPosted = $planData['is_posted'];

        $edit_url = route('business.offerEdit', $offer->id);
        $isShowPopup = 0;

        return view('builder.preview', compact('id', 'template', 'business', 'only_view', 'show_meta', 'offer', 'video_id', 'notification_list', 'planData', 'gallery_color_titles', 'tag_1_bg_colors', 'tag_2_bg_colors', 'edit_url', 'text_colors', 'show_header', 'button_colors', 'button_bg_colors', 'btn_style_types', 'isCurrentOfferPosted', 'isShowPopup','is_posted'));
    }

    public function customPreview($offer_id)
    {
        $show_meta = $show_header = 1;
        $only_view = 0;

        $offer = Offer::with('offer_template')
            ->where('id', $offer_id)
            ->first();
           
        $is_posted = InstantTask::where('user_id', Auth::id())->where('offer_id', $offer->id)->whereNull('deleted_at')->count();
           

        $business = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $edit_url = route('business.offerEdit', $offer->id);

        $currentOfferPosted = Offer::with('getInstantTasks')
            ->has('getInstantTasks')
            ->where('id', $offer->id)
            ->where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->first();

        $isCurrentOfferPosted = $currentOfferPosted ? 1 : 0;
        $isShowPopup = 0;

        return view('builder.custom-preview', compact('business', 'only_view', 'show_meta', 'offer', 'notification_list', 'planData', 'edit_url', 'show_header', 'isCurrentOfferPosted', 'isShowPopup', 'is_posted'));
    }

    public function details(Request $request)
    {
        $today = date('Y-m-d');

        /*get free user */
        $user = User::where('id', Auth::id())
            ->where('current_account_status', 'free')
            ->first();    

        if ($user == null) {
            $offers = Offer::where('user_id', Auth::id())
            ->where('id', '!=', $request->offer_id)
            ->where('end_date', '>=', $today)
            ->select('start_date', 'end_date')
            ->get();
        }else {

            $offers = Offer::where('user_id', $user->id)
            ->where('id', '!=', $request->offer_id)
            ->where('end_date', '>=', $today)
            ->select('start_date', 'end_date')
            ->get();
        }
        
        $usedDates = [];
        foreach ($offers as $offer) {
            $range = CarbonPeriod::create($offer->start_date, $offer->end_date);
            $formattedDates = $this->formatDates($range);
            $usedDates = array_merge($usedDates, $formattedDates);
        }

        if ($request->offer_id) {
            $offer_id = $request->offer_id;
            $offer = Offer::find($offer_id);
        } else {
            $offer_id = '';
            $offer = new Offer();
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.enter-details', compact('notification_list', 'planData', 'offer', 'offer_id', 'usedDates', 'user'));
    }

    public function formatDates($range)
    {
        $dates = [];
        foreach ($range as $date) {
            $dates[] = $date->format('j-n-Y');
        }
        return $dates;
    }

    public function scriptPage($offer_id)
    {
        $offer = Offer::findorFail($offer_id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.offers.scripts', compact('offer', 'notification_list', 'planData'));
    }

    public function validateOffer($request)
    {
        if ($request->title == '') {
            return ['status' => false, 'message' => 'Offer title can not be empty'];
        }

        if ($request->description == '') {
            return ['status' => false, 'message' => 'Offer description can not be empty'];
        }

        if ($request->start_date != '' && $request->end_date == '') {
            return ['status' => false, 'message' => 'Please select Offer End Date'];
        }

        if ($request->end_date != '' && $request->start_date == '') {
            return ['status' => false, 'message' => 'Please select Offer Start Date'];
        }

        /* if($request->start_date != '' && $request->end_date != ''){
            
            $offer = Offer::where('user_id',Auth::id())
                    ->where(function($query) use ($request){
                        $query->whereBetween('start_date', array(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))));
                    })
                    ->orWhere(function($query) use ($request){
                        $query->whereBetween('end_date', array(date("Y-m-d", strtotime($request->start_date)), date("Y-m-d", strtotime($request->end_date))));
                    })->where('user_id', Auth::id())->where('status', 1)->first();

            if(($offer != null && !isset($request->offer_id)) || ($offer != null && isset($request->offer_id) && $request->offer_id != $offer->id)){
                return ['status'=> false,'message'=> 'Already offer is running in this date range.'];
            }
        } */

        return ['status' => true, 'message' => 'Validated Successfully.'];
    }

    public function validateCustomOffer($request)
    {
        if (!$request->has('image') && $request->offer_id == '' && $request->website_url == '') {
            return ['status' => false, 'message' => 'Please either select an Image or Enter url.'];
        }

        return ['status' => true, 'message' => 'Validated Successfully.'];
    }

    public function createSocialPlatforms($socialPost = null)
    {
        $post = SocialPost::where('user_id', Auth::id())
            ->where('offer_id', $socialPost->offer_id)
            ->first();
        $platforms = Platform::where('status', 1)->get();

        foreach ($platforms as $platform) {
            $socialPlatform = SocialPlatform::where('social_post_id', $post->id)
                ->where('platform_key', $platform->name)
                ->first();
            if ($socialPlatform == null) {
                $socialPlatform = new SocialPlatform();
                $socialPlatform->social_post_id = $post->id;
                $socialPlatform->platform_key = $platform->name;
            }
            $socialPlatform->value = $this->platformKey(10);
            $socialPlatform->save();
        }
    }

    public function platformKey($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $platformKey = '';
        for ($i = 0; $i < $length; $i++) {
            $platformKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $platformKey;
    }

    public function showSpcialConnectPopup(Request $request)
    {
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.design-offers.social-connect', compact('notification_list', 'planData'));
    }

    public function getUrlMetaImage($url = '')
    {
        libxml_use_internal_errors(true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:25.0) Gecko/20100101 Firefox/25.0');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $page_content = curl_exec($ch);
        $meta_val = null;

        if ($page_content != false) {
            $dom_obj = new DOMDocument();
            $dom_obj->loadHTML($page_content);

            if ($dom_obj->getElementsByTagName('meta')) {
                foreach ($dom_obj->getElementsByTagName('meta') as $meta) {
                    if ($meta->getAttribute('property') == 'og:image') {
                        if ($meta->getAttribute('content')) {
                            $meta_val = $meta->getAttribute('content');
                        }
                    }
                }
            }
        }

        return $meta_val;
    }
}
