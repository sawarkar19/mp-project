<?php

namespace App\Http\Controllers\Business;

use DB;
use Auth;
use Image;
use Session;

use Carbon\Carbon;
use App\Models\Offer;
use App\Models\Target;
use App\Models\Business;
use App\Models\Platform;
use App\Models\Template;
use App\Models\TimeSlot;
use App\Models\Userplan;
use App\Models\SocialPost;
use App\Models\Transaction;

use Illuminate\Http\Request;
use App\Models\OfferTemplate;

use App\Models\BusinessDetail;
use App\Models\SocialPlatform;
use App\Models\OfferGalleryImage;
use App\Models\OfferTemplateButton;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\OfferTemplateContent;

use App\Models\UserSocialConnection;
use App\Models\MessageTemplateSchedule;
use App\Jobs\DeleteExpiredOfferInstantTaskJob;
use App\Http\Controllers\Business\CommonSettingController;

class DesignOfferController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(Request $request)
    {
        // Update Social Connections
        app('App\Http\Controllers\Business\SocialConnectController')->updateUserConnections();

        /* fullcalender events json data variable */
        $events_json_data = [];

        $todays = date('Y-m-d');
        $scheduled = Offer::with('offer_template')
            ->withCount('unique_clicks', 'extra_clicks')
            ->where('user_id', Auth::id())
            ->where('end_date', '>=', $todays)
            ->orderBy('start_date', 'asc')
            ->get();

        $unscheduled = Offer::with('offer_template')
            ->withCount('unique_clicks', 'extra_clicks')
            ->where('user_id', Auth::id())
            ->whereNull('start_date')
            ->whereNull('end_date')
            ->orderBy('created_at', 'DESC')
            ->get();

        $expired = Offer::with('offer_template')
            ->withCount('unique_clicks', 'extra_clicks')
            ->where('user_id', Auth::id())
            ->where('end_date', '<', $todays)
            ->orderBy('end_date', 'desc')
            ->orderBy('id', 'desc')
            ->offset(0)
            ->limit(10)
            ->get();

        // dd($expired);

        /* Fetching the upcoming Personalised Messages from the database and then creating an array for the FullCallender event. */
        // $personalisedTemp = MessageTemplateSchedule::where('user_id', Auth::id())->whereNotIn('message_template_category_id', [7,8])->orderBy('scheduled', 'ASC')->get();

        /* Time slots which are not passed */
        $time_slot_ids = TimeSlot::where('value', '>=', date('H:i:s'))
            ->pluck('id')
            ->toArray();

        $whereConditions = [['message_template_schedules.user_id', '=', Auth::id()], ['message_template_schedules.channel_id', '=', 5], ['message_template_schedules.scheduled', '>', Carbon::now()->format('Y-m-d')]];

        $orWhereConditions = [['message_template_schedules.user_id', '=', Auth::id()], ['message_template_schedules.channel_id', '=', 5], ['message_template_schedules.scheduled', '=', Carbon::now()->format('Y-m-d')]];

        $personalisedTemp = MessageTemplateSchedule::select('message_template_schedules.*')
            ->leftjoin('time_slots', 'message_template_schedules.time_slot_id', '=', 'time_slots.id')
            ->whereNotIn('message_template_schedules.message_template_category_id', [7, 8])
            ->where($whereConditions)
            ->orWhere(function ($query) use ($time_slot_ids, $orWhereConditions) {
                $query->where($orWhereConditions)->whereIn('message_template_schedules.time_slot_id', $time_slot_ids);
            })
            ->orderBy('message_template_schedules.scheduled', 'ASC')
            ->orderBy('time_slots.value', 'ASC')
            ->get();

        // dd($personalisedTemp);

        $business_details = BusinessDetail::where('user_id', Auth::id())->first();
        $biz_name = $business_details->business_name ?? 'business';
        if (strlen($biz_name) > 28) {
            $biz_name = substr($biz_name, 0, 28) . '..';
        }

        if (!empty($personalisedTemp)) {
            foreach ($personalisedTemp as $p_msg) {
                $message = $p_msg->template->message;
                $message = str_replace('[business_name]', $biz_name, $message);
                $message = str_replace('{#var#}', $biz_name, $message);

                $offer_dtl = [
                    'start' => Carbon::parse($p_msg->scheduled)->format('Y-m-d'),
                    'overlap' => false,
                    'description' => $message,
                    'event_type' => 'personalised_msg',
                    'title_ex' => $p_msg->template->category->name,
                    'icon' => 'bell',
                ];
                $events_json_data[] = $offer_dtl;
            }
        }

        /* Creating an array of backround colors for offer's to specify current offer and upcoming offer. */
        $offers_background_colors = ['#8dfc8a' /* Current Offer BG Color */, '#f9fc8a' /* Next upcoming BG Color */, '#00289e' /* Blue dark color */, '#009ea6' /* blue light color, so and so ...... */, '#00289e', '#009ea6', '#00289e', '#009ea6', '#00289e', '#009ea6', '#00289e', '#009ea6', '#00289e', '#009ea6'];

        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        $isConnectAnySocialMedia = 1;
        if ($userSocialConnection != null) {
            if (($userSocialConnection->is_facebook_auth == 0 || $userSocialConnection->is_facebook_auth == null) && $userSocialConnection->is_twitter_auth == 0 && ($userSocialConnection->is_linkedin_auth == 0 || $userSocialConnection->is_linkedin_auth == null) && ($userSocialConnection->is_instagram_auth == 0 || $userSocialConnection->is_instagram_auth == null) && ($userSocialConnection->is_youtube_auth == 0 || $userSocialConnection->is_youtube_auth == null)) {
                $isConnectAnySocialMedia = 0;
            }
        } else {
            $isConnectAnySocialMedia = 0;
        }
        return view('business.design-offers.index', compact('notification_list', 'planData', 'scheduled', 'unscheduled', 'expired', 'events_json_data', 'offers_background_colors', 'isConnectAnySocialMedia'));
    }

    public function action(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());

            if ($request->type == 'add' || $request->type == 'update') {
                $start_date = date('Y-m-d', strtotime($request->start));
                $end_date = date('Y-m-d', strtotime($request->end));

                $offerExist = Offer::where(function ($query) use ($start_date, $end_date) {
                    $query
                        ->where('start_date', '>=', $start_date)
                        ->where('start_date', '<=', $end_date)
                        ->where('user_id', Auth::id());
                })
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query
                            ->where('end_date', '>=', $start_date)
                            ->where('end_date', '<=', $end_date)
                            ->where('user_id', Auth::id());
                    })
                    ->first();

                if ($offerExist != null) {
                    return response()->json(['status' => false, 'data' => [], 'message' => 'Offer already running in this date range.']);
                }
            }

            $event = Offer::find($request->id);
            $event->start_date = $request->start;
            $event->end_date = $request->end;
            $event->save();

            return response()->json(['status' => true, 'data' => $event]);
        }
    }

    public function offerList()
    {
        $offers = Offer::where('user_id', Auth::id())
            ->where('start_date', null)
            ->where('end_date', null)
            ->get();

        return response()->json(['offers' => $offers, 'count' => count($offers)]);
    }

    public function templates(Request $request)
    {
        $request_data = $request->all();

        $todays_date = date('Y-m-d');
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('status', 1)
            ->where('transaction_amount', '>', 0)
            ->select('invoice_no')
            ->first();

        //conditions
        if (isset($request_data['business_type_id']) && isset($request_data['template_type_id'])) {
            $conditions[] = ['business_type', '=', $request_data['business_type_id']];
            $conditions[] = ['template_type', '=', $request_data['template_type_id']];
        } elseif (isset($request_data['business_type_id']) && !isset($request_data['template_type_id'])) {
            $conditions[] = ['business_type', '=', $request_data['business_type_id']];
        } elseif (!isset($request_data['business_type_id']) && isset($request_data['template_type_id'])) {
            $conditions[] = ['template_type', '=', $request_data['template_type_id']];
        }

        $conditions[] = ['status', '=', 1];

        // if($transaction == null){
        //     $templates = Template::where($conditions)->orderBy('id','desc')->where('is_free', 1)->paginate(8);
        // }else{
        //     $templates = Template::where($conditions)->orderBy('id','desc')->paginate(8);
        // }

        $templates = Template::where($conditions)
            ->orderBy('id', 'desc')
            ->paginate(8);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $businesses = Business::all();

        return view('business.design-offers.templates', compact('templates', 'businesses', 'notification_list', 'planData', 'request_data', 'transaction'));
    }

    public function duplicate(Request $request)
    {
        DB::beginTransaction();

        try {
            $offer_id = decrypt($request->offer_id);
            $offer = Offer::find($offer_id);

            $newOffer = $offer->replicate();

            $newOffer->social_post__db_id = null;
            $newOffer->is_social_post_created = 0;
            $newOffer->title = $offer->title . '-Copy';
            $newOffer->start_date = null;
            $newOffer->end_date = null;
            $newOffer->status = 1;
            $newOffer->created_at = Carbon::now();
            $newOffer->updated_at = Carbon::now();

            if ($newOffer->save()) {
                // CREATE COPY OF TEMPLATE
                if ($offer->type == 'custom') {
                    if ($offer->website_url != '') {
                    } else {
                        if (file_exists('assets/templates/custom/' . $offer->image)) {
                            // echo file_exists(('assets/templates/custom/'.$offer->image));

                            $offerImgName = pathinfo(asset('assets/templates/custom') . '/' . $offer->image, PATHINFO_FILENAME);
                            $offerImgExt = pathinfo(asset('assets/templates/custom') . '/' . $offer->image, PATHINFO_EXTENSION);

                            // DB COLUMN
                            $newOffer->image = 'custom-offer-' . date('dmYhis', time()) . '.' . $offerImgExt;

                            $oldOfferCustomImageFolder = $folderPath = base_path('../assets/templates/custom/');
                            $oldOfferCustomImagePath = $oldOfferCustomImageFolder . $offer->image;
                            $newOfferCustomImagePath = $oldOfferCustomImageFolder . $newOffer->image;

                            if (\File::copy($oldOfferCustomImagePath, $newOfferCustomImagePath)) {
                                $this->_createShareThumbnail('custom', $newOffer->image, $offerImgExt);
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Unable to dublicate offer!',
                                ]);
                            }
                        } else {
                            $newOffer->image = $offer->image;
                        }
                    }
                } else {
                    $offertemp = OfferTemplate::whereOfferId($offer_id)->first();

                    $newOfferTemplates = [];
                    $newOfferTemplates = $offertemp->replicate();
                    $newOfferTemplates->offer_id = $newOffer->id;
                    $newOfferTemplates->slug = $offertemp->slug;

                    if (!empty($offertemp->thumbnail)) {
                        // echo "<br />offer-thumbnails <br />";
                        // echo 'assets/offer-thumbnails/'.$offertemp->thumbnail;
                        if (file_exists('assets/offer-thumbnails/' . $offertemp->thumbnail)) {
                            // echo "suc";
                            $offerThumbnailName = pathinfo(asset('assets/offer-thumbnails') . '/' . $offertemp->thumbnail, PATHINFO_FILENAME);
                            $offerThumbnailExt = pathinfo(asset('assets/offer-thumbnails') . '/' . $offertemp->thumbnail, PATHINFO_EXTENSION);

                            // DB COLUMN
                            $newOfferTemplates->thumbnail = 'thumb-' . date('dmYhis', time()) . '.' . $offerThumbnailExt;

                            $oldOfferThumbnailImageFolder = base_path('../assets/offer-thumbnails/');
                            $oldOfferThumbnailImagePath = $oldOfferThumbnailImageFolder . $offertemp->thumbnail;
                            $newOfferThumbnailImagePath = $oldOfferThumbnailImageFolder . $newOfferTemplates->thumbnail;

                            if (\File::copy($oldOfferThumbnailImagePath, $newOfferThumbnailImagePath)) {
                                $this->_createShareThumbnail('standard', $newOfferTemplates->thumbnail, $offerThumbnailExt);
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Unable to dublicate offer!',
                                ]);
                            }
                        } else {
                            // DB COLUMN
                            // echo "not ava ";
                            $newOfferTemplates->thumbnail = $offertemp->thumbnail;
                        }
                    } else {
                        // echo "not ava 2";
                        // DB COLUMN
                        $newOfferTemplates->thumbnail = $offertemp->thumbnail;
                    }
                    // echo "thumbnail: ".$newOfferTemplates->thumbnail;

                    if (!empty($offertemp->bg_image)) {
                        // echo "<br />bg_image <br />";
                        // echo 'assets/templates/'.$offertemp->slug.'/'.$offertemp->bg_image;

                        if (file_exists('assets/templates/' . $offertemp->slug . '/' . $offertemp->bg_image)) {
                            // echo "suc";

                            $offerBgImageName = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $offertemp->bg_image, PATHINFO_FILENAME);
                            $offerBgImagelExt = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $offertemp->bg_image, PATHINFO_EXTENSION);

                            // DB COLUMN
                            $newOfferTemplates->bg_image = 'background-' . date('dmYhis', time()) . '.' . $offerBgImagelExt;

                            $oldOfferBgImageFolder = base_path('../assets/templates/') . $offertemp->slug . '/';
                            $oldOfferBgImagePath = $oldOfferBgImageFolder . $offertemp->bg_image;
                            $newOfferBgImagePath = $oldOfferBgImageFolder . $newOfferTemplates->bg_image;

                            if (\File::copy($oldOfferBgImagePath, $newOfferBgImagePath)) {
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Unable to dublicate offer!',
                                ]);
                            }
                        } else {
                            // echo "not ava ";
                            $newOfferTemplates->bg_image = $offertemp->bg_image;
                        }
                    } else {
                        // echo "not ava 2";
                        $newOfferTemplates->bg_image = $offertemp->bg_image;
                    }

                    if (!empty($offertemp->hero_image)) {
                        // echo "<br />hero_image <br />";
                        // echo 'assets/templates/'.$offertemp->slug.'/'.$offertemp->hero_image;

                        if (file_exists('assets/templates/' . $offertemp->slug . '/' . $offertemp->hero_image)) {
                            // echo "su";
                            $offerHeroImageName = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $offertemp->hero_image, PATHINFO_FILENAME);
                            $offerHeroImagelExt = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $offertemp->hero_image, PATHINFO_EXTENSION);

                            // DB COLUMN
                            $newOfferTemplates->hero_image = 'hero_image-' . date('dmYhis', time()) . '.' . $offerHeroImagelExt;

                            $oldOfferHeroImageFolder = base_path('../assets/templates/') . $offertemp->slug . '/';
                            $oldOfferHeroImagePath = $oldOfferHeroImageFolder . $offertemp->hero_image;
                            $newOfferHeroImagePath = $oldOfferHeroImageFolder . $newOfferTemplates->hero_image;

                            if (\File::copy($oldOfferHeroImagePath, $newOfferHeroImagePath)) {
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => false,
                                    'message' => 'Unable to dublicate offer!',
                                ]);
                            }
                        } else {
                            // echo "not ava ";
                            $newOfferTemplates->hero_image = $offertemp->hero_image;
                        }
                    } else {
                        // echo "not ava 2";
                        $newOfferTemplates->hero_image = $offertemp->hero_image;
                    }

                    // echo "<br/> ".$newOfferTemplates->hero_image;

                    $newOfferTemplates->hero_title = $offertemp->hero_title;
                    $newOfferTemplates->hero_text = $offertemp->hero_text;
                    $newOfferTemplates->status = 1;
                    $newOfferTemplates->created_at = Carbon::now();
                    $newOfferTemplates->updated_at = Carbon::now();

                    $newOfferTemplates->save();

                    // OFFER TEMPLATE CONTENT
                    $offerTemplateContent = OfferTemplateContent::whereOfferTemplateId($offertemp->id)->get();
                    foreach ($offerTemplateContent as $contentKey => $content) {
                        $newOfferTemplatesContent = [];
                        $newOfferTemplatesContent = $content->replicate();
                        $newOfferTemplatesContent->offer_template_id = $newOfferTemplates->id;
                        $newOfferTemplatesContent->created_at = Carbon::now();
                        $newOfferTemplatesContent->updated_at = Carbon::now();

                        $newOfferTemplatesContent->save();
                    }

                    // OFFER TEMPLATE BUTTON
                    $offerTemplateButtons = OfferTemplateButton::whereOfferTemplateId($offertemp->id)->get();
                    foreach ($offerTemplateButtons as $contentKey => $button) {
                        $newOfferTemplatesButton = [];
                        $newOfferTemplatesButton = $button->replicate();
                        $newOfferTemplatesButton->offer_template_id = $newOfferTemplates->id;
                        $newOfferTemplatesButton->created_at = Carbon::now();
                        $newOfferTemplatesButton->updated_at = Carbon::now();

                        $newOfferTemplatesButton->save();
                    }

                    // OFFER GALLERY IMAGES
                    $offerGalleryImage = OfferGalleryImage::whereOfferTemplateId($offertemp->id)->get();
                    foreach ($offerGalleryImage as $galleryImageKey => $galleryImage) {
                        $newOfferGalleryImage = [];
                        $newOfferGalleryImage = $galleryImage->replicate();
                        $newOfferGalleryImage->offer_template_id = $newOfferTemplates->id;

                        if (!empty($galleryImage->image_path)) {
                            if (file_exists('assets/templates/' . $offertemp->slug . '/' . $galleryImage->image_path)) {
                                $offerGalleryImageName = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $galleryImage->image_path, PATHINFO_FILENAME);
                                $offerGalleryImagelExt = pathinfo(asset('assets/templates/') . $offertemp->slug . '/' . $galleryImage->image_path, PATHINFO_EXTENSION);

                                // DB COLUMN
                                $newOfferTemplates->image_path = 'image_path-' . date('dmYhis', time()) . '.' . $offerGalleryImagelExt;

                                $oldOfferGalleryImageFolder = base_path('../assets/templates/') . $offertemp->slug . '/';
                                $oldOfferGalleryImagePath = $oldOfferGalleryImageFolder . $galleryImage->image_path;
                                $newOfferGalleryImagePath = $oldOfferGalleryImageFolder . $newOfferTemplates->image_path;

                                if (\File::copy($oldOfferGalleryImagePath, $newOfferGalleryImagePath)) {
                                } else {
                                    DB::rollback();
                                    return response()->json([
                                        'status' => false,
                                        'message' => 'Unable to dublicate offer!',
                                    ]);
                                }
                            } else {
                                $newOfferTemplates->image_path = $galleryImage->image_path;
                            }
                        } else {
                            $newOfferTemplates->image_path = $galleryImage->image_path;
                        }

                        $newOfferGalleryImage->created_at = Carbon::now();
                        $newOfferGalleryImage->updated_at = Carbon::now();
                        $newOfferGalleryImage->save();
                    }
                }

                $newOffer->uuid = 'SHR' . Auth::id() . 'F' . $newOffer->id;
                $newOffer->save();

                $socialPost = new SocialPost();
                $socialPost->user_id = Auth::id();
                $socialPost->offer_id = $newOffer->id;
                $socialPost->save();

                if ($socialPost) {
                    $this->createSocialPlatforms($socialPost);
                }

                // GET Social Platforms
                $socialPlatform = SocialPost::with('social_platforms')
                    ->where('offer_id', $newOffer->id)
                    ->first();

                $facebook_url = '';
                $twitter_url = '';
                $linkedin_url = '';

                foreach ($socialPlatform->social_platforms as $platformKey => $platform) {
                    if ($newOffer->website_url == '') {
                        if ($platform->platform_key == 'facebook') {
                            $facebook_url = URL::to('/f') . '/' . $newOffer->uuid . '?media=' . $platform->value;
                        } elseif ($platform->platform_key == 'twitter') {
                            $twitter_url = URL::to('/f') . '/' . $newOffer->uuid . '?media=' . $platform->value;
                        } elseif ($platform->platform_key == 'linkedin') {
                            $linkedin_url = URL::to('/f') . '/' . $newOffer->uuid . '?media=' . $platform->value;
                        }
                    } else {
                        if ($platform->platform_key == 'facebook') {
                            $facebook_url = $newOffer->website_url . '?media=' . $platform->value;
                        } elseif ($platform->platform_key == 'twitter') {
                            $twitter_url = $newOffer->website_url . '?media=' . $platform->value;
                        } elseif ($platform->platform_key == 'linkedin') {
                            $linkedin_url = $newOffer->website_url . '?media=' . $platform->value;
                        }
                    }
                }

                if ($newOffer->type == 'custom') {
                    // Create a cURL handle
                    $img_url = $url = '';
                    if ($newOffer->website_url != '') {
                        $img_url = '';
                        $url = $newOffer->website_url;
                    } else {
                        $img_url = 'assets/templates/custom/' . $newOffer->image;
                    }

                    $postParams = [
                        'offer_id' => $newOffer->id,
                        'name' => $newOffer->title,
                        'message' => $newOffer->description,
                        'url' => $url,
                        'single_image' => $img_url,
                        'start_date' => $newOffer->start_date,
                        'end_date' => $newOffer->end_date,
                        'facebook_url' => $facebook_url,
                        'twitter_url' => $twitter_url,
                        'linkedin_url' => $linkedin_url,
                    ];
                    app('App\Http\Controllers\Business\SocialConnectController')->createOfferDesignPost($postParams);
                } else {
                    $offerTemplate = OfferTemplate::where('offer_id', $newOffer->id)->first();
                    $img_url = 'assets/offer-thumbnails/' . $offerTemplate->thumbnail;

                    $postParams = [
                        'offer_id' => $newOffer->id,
                        'name' => $newOffer->title,
                        'message' => $newOffer->description,
                        'url' => '',
                        'single_image' => $img_url,
                        'start_date' => $newOffer->start_date,
                        'end_date' => $newOffer->end_date,
                        'facebook_url' => $facebook_url,
                        'twitter_url' => $twitter_url,
                        'linkedin_url' => $linkedin_url,
                    ];
                    // dd("create standard ", $postParams);
                    app('App\Http\Controllers\Business\SocialConnectController')->createOfferDesignPost($postParams);
                }

                DB::commit();

                $redirect_url = route('business.designOffer');
                return response()->json([
                    'status' => true,
                    'message' => 'Duplicate Offer Created Successfully!',
                    'redirect_url' => $redirect_url,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Unable to dublicate offer!',
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    // extension
    private function _createShareThumbnail($type, $fileName, $extension)
    {
        if ($type == 'custom') {
            $folderPath = base_path('../assets/templates/custom/');
            $newIamgeName = 'share-custom-offer-';
            $ext = '.' . $extension;
        } else {
            $folderPath = base_path('../assets/offer-thumbnails/');
            $newIamgeName = 'share-thumb-';
            $ext = '.jpg';
        }
        $file = $folderPath . $fileName;

        //Resize image here
        $resize_name = $newIamgeName . date('dmYhis', time()) . $ext;
        $resize_path = $folderPath . $resize_name;
        $small_img = Image::make($file)->resize(400, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $small_img->save($resize_path);
        return true;
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

    public function setUnscheduleOffer(Request $request)
    {
        $offer_id = decrypt($request->offer_id);
        if ($offer_id != null) {
            Offer::where('id', $offer_id)->update([
                'start_date' => null,
                'end_date' => null,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Successfully transfer to Unschedule offer',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found',
            ]);
        }
    }

    public function deleteOffer(Request $request)
    {
        DB::beginTransaction();
        try {
            $offer_id = decrypt($request->offer_id);
            $offer = Offer::find($offer_id);

            Offer::whereId($offer_id)->delete();

            // CUSTOM TEMPLATE
            if ($offer->type == 'custom') {
                // @unlink(base_path() . '/../assets/templates/custom/' . $offer->image);
            } else {
                // echo "standard";

                $offerTemplates = OfferTemplate::whereOfferId($offer_id)->get();

                foreach ($offerTemplates as $key => $offertemp) {
                    OfferTemplateContent::whereOfferTemplateId($offertemp->id)->delete();

                    $offerGalleryImage = OfferGalleryImage::whereOfferTemplateId($offertemp->id)->get();
                    OfferGalleryImage::whereOfferTemplateId($offertemp->id)->delete();
                }
                OfferTemplate::whereOfferId($offer_id)->delete();
            }

            DB::commit();

            $redirect_url = route('business.designOffer');
            return response()->json([
                'status' => true,
                'message' => 'Offer deleted Successfully!',
                'redirect_url' => $redirect_url,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function expireOffer(Request $request)
    {
        DB::beginTransaction();
        try {
            $offer_id = decrypt($request->offer_id);
            $offer = Offer::find($offer_id);

            $today = Carbon::today();
            $yesterday = Carbon::now()->subDays(1);

            if ($today == $offer->start_date) {
                $offer->start_date = $yesterday;
            }

            $offer->stop_date = $offer->end_date;
            $offer->end_date = $yesterday;
            $offer->save();

            // Update Offer in Managemedia side
            if($offer->social_post__db_id!=NULL){
                $img_url = $url = '';
                if ($offer->type == 'custom') {
                    if($offer->website_url != ''){
                        $url = $offer->website_url;
                    }else{
                        $img_url = app('App\Http\Controllers\Business\OfferController')->reduceImage1080("custom", $offer->image);
                        $img_url = "assets/templates/resize-file/".$img_url;
                    }
                }else{
                    $offerTemplate = OfferTemplate::where('offer_id', $offer->id)->first();
                    $img_url = app('App\Http\Controllers\Business\OfferController')->reduceImage1080("standard", $offerTemplate->thumbnail);
                    $img_url = "assets/templates/resize-file/".$img_url;
                }

                // GET Social Platforms
                $socialPlatform = SocialPost::with('social_platforms')->where('offer_id', $offer->id)->first();

                $facebook_url = $twitter_url = $linkedin_url = "";
                foreach ($socialPlatform->social_platforms as $platformKey => $platform) {
                    if($offer->website_url == ''){
                        if($platform->platform_key == "facebook"){
                            $facebook_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                        }
                        else if($platform->platform_key == "twitter"){
                            $twitter_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                        }
                        else if($platform->platform_key == "linkedin"){
                            $linkedin_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                        }
                    }
                    else{
                        if($platform->platform_key == "facebook"){
                            $facebook_url = $offer->website_url.'?media='.$platform->value;
                        }
                        else if($platform->platform_key == "twitter"){
                            $twitter_url = $offer->website_url.'?media='.$platform->value;
                        }
                        else if($platform->platform_key == "linkedin"){
                            $linkedin_url = $offer->website_url.'?media='.$platform->value;
                        }
                    }
                }

                $postParams = [
                    'offer_id' => $offer->id,
                    'name' => $offer->title,
                    'message' => $offer->description,
                    'single_image' => $img_url,
                    'url' => '',
                    'post_id' => $offer->social_post__db_id,
                    'start_date' => $offer->start_date,
                    'end_date' => $offer->end_date,
                    'facebook_url' => $facebook_url,
                    'twitter_url' => $twitter_url,
                    'linkedin_url' => $linkedin_url,
                ];
                app('App\Http\Controllers\Business\SocialConnectController')->updateOfferDesignPost($postParams);
            }

            //mark expired
            dispatch(new DeleteExpiredOfferInstantTaskJob());

            DB::commit();
            $redirect_url = route('business.designOffer');
            return response()->json([
                'status' => true,
                'message' => 'Offer stopped Successfully!',
                'redirect_url' => $redirect_url,
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function _duplicateFile()
    {
    }
}
