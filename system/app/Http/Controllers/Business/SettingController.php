<?php

namespace App\Http\Controllers\Business;

use DB;
use Str;

use Auth;
use File;
use Hash;
use Image;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\State;
use App\Models\Option;
use App\Models\Channel;
use App\Models\EmailJob;

use App\Models\InstantTask;
use App\Models\OfferReward;
use App\Models\MessageRoute;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BusinessVcard;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use App\Models\UserNotification;

use App\Models\OfferSubscription;
use App\Models\UserSocialPlatform;
use App\Models\NotificationContact;
use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;
use App\Models\MessageScheduleContact;
use App\Models\MessageTemplateSchedule;
use App\Helper\Deductions\DeductionHelper;
use App\Jobs\DeleteExpiredOfferInstantTaskJob;
use App\Http\Controllers\Business\CommonSettingController;

use App\Jobs\AddSocialMediaConnectedTasksJob;

class SettingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function settings(Request $request)
    {
        $wa_session = WhatsappSession::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        $whatsapp_num = '';
        if ($wa_session) {
            $whatsapp_num = $wa_session->wa_number;
        }

        $basic = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        if ($basic == null) {
            $basic = new BusinessDetail();
        }

        $states = State::select('id', 'name')->get();
        $userData = User::where('id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        // $wa_url = Option::where('key', 'oddek_url')->first();
        $wa_api_url = Option::where('key', 'wa_api_url')->first();
        $channels = Channel::where('is_use_msg', 1)
            ->orderBy('ordering', 'asc')
            ->get();
        $routes = RouteToggleContoller::routeDetails();

        $logo_url = asset('assets/business/logos');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $vcard = BusinessVcard::where('status', 1)->get();

        $googleReviewDeductCost = DeductionHelper::getActiveDeductionDetail('slug', 'google_review_verification');

        $activeRoute = MessageRoute::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('wa', 1)->orWhere('sms', 1);
            })
            ->first();

        /* notifications tab check active or not status */
        $notification_status_active = UserNotification::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('wa', 1)->orWhere('email', 1);
            })
            ->first();

        /*notifications get all data*/
        $notifications = Notification::where('status', 1)->get();

        /*notification contact get 5 record only*/
        $notification_contacts = NotificationContact::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        $setting_url = route('business.settings');

        /* Social Connections */
        app('App\Http\Controllers\Business\SocialConnectController')->updateUserConnections();

        // Add Social Task e.g facebook page, instagram profile, twitter follow etc.
        dispatch(new AddSocialMediaConnectedTasksJob(Auth::id()));

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        if ($userSocialConnection == null) {
            $userSocialConnection = new UserSocialConnection();
        }

        $isFacebookCheck = $isTwitterCheck = $islinkedInCheck = $isInstagramCheck = 0;
        $isFacebookConnected = $isInstagramConnected = 0;
        if ($request->has('facebook')) {
            $isFacebookCheck = 1;
            $isFacebookConnected = $userSocialConnection->is_facebook_auth ?? null;
        } elseif ($request->has('twitter')) {
            $isTwitterCheck = 1;
        } elseif ($request->has('linkedin')) {
            $islinkedInCheck = 1;
        } elseif ($request->has('instagram')) {
            $isInstagramCheck = 1;
            $isInstagramConnected = $userSocialConnection->is_instagram_auth ?? null;
        }

        $userSocialPlatform = UserSocialPlatform::orderBy('sort_no', 'ASC')->get();
        $googleReviewDeductCost = DeductionHelper::getActiveDeductionDetail('slug', 'google_review_verification');

        $youtubeTasks = InstantTask::where('user_id', Auth::id())
            ->whereIn('task_id', [10, 11, 12])
            ->whereNull('deleted_at')
            ->count();

        $youtubeChannelTask = InstantTask::where('user_id', Auth::id())
            ->whereIn('task_id', [10])
            ->whereNull('deleted_at')
            ->select('task_value')
            ->first();
        $googleReviewTasks = InstantTask::where('user_id', Auth::id())
            ->whereIn('task_id', [13])
            ->whereNull('deleted_at')
            ->select('task_value')
            ->first();
        $showLinkTasks = [];
        $showLinkTasks['youtube_channel'] = $youtubeChannelTask;
        $showLinkTasks['google_review'] = $googleReviewTasks;

        return view('business.settings', compact('basic', 'states', 'notification_list', 'planData', 'wa_session', 'whatsapp_num', 'userData', 'wa_api_url', 'routes', 'channels', 'logo_url', 'vcard', 'googleReviewDeductCost', 'activeRoute', 'setting_url', 'userSocialConnection', 'isFacebookCheck', 'isFacebookConnected', 'isTwitterCheck', 'islinkedInCheck', 'isInstagramCheck', 'isInstagramConnected', 'userSocialPlatform', 'googleReviewDeductCost', 'youtubeTasks', 'showLinkTasks', 'notifications', 'notification_contacts', 'notification_status_active'));
    }

    public function basicDetails(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        $validatedData = $request->validate([
            'business_name' => 'required|min:2|max:255',
            // 'daily_reporting_time' => 'required',
            'tag_line' => 'nullable|min:2|max:100',
            'message' => 'nullable|min:5|max:300',
        ]);

        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->hasFile('logo')) {
            $logoImage = $this->logoImage($request);
            if ($logoImage['status'] == false) {
                return response()->json(['status' => false, 'message' => $logoImage['message']]);
            } else {
                $logo = $logoImage['file'];
            }
        } else {
            if ($details) {
                $logo = $details->logo;
            } else {
                $logo = '';
            }
        }

        if ($details == null) {
            $details = new BusinessDetail();
            $details->user_id = $user_id;
            $details->uuid = $user_id . 'BUSI' . date('Ymd');
        }

        $details->business_name = $request->business_name;
        $details->tag_line = $request->tag_line;
        $details->logo = $logo;
        $details->website = $request->website;
        $details->business_msg = $request->message;
        // $details->daily_reporting_time = $request->daily_reporting_time;

        $this->updateBusinessThumbnail($details);

        if ($details->save()) {
            return response()->json(['status' => true, 'logo' => $logo, 'message' => 'Business Basic Info Updated Successfully', 'tab' => 'basic']);
        } else {
            return response()->json(['status' => false, 'message' => 'Business Basic Info Not Updated.']);
        }
    }

    public function updateBusinessThumbnail($details)
    {
        $img = Image::make(public_path('assets/business/Website-offer-thumb.jpg'));
        $user = User::where('id', $details->user_id)
            ->orderBy('id', 'desc')
            ->first();

        $businessName = $details->business_name;
        $businessLogo = $details->logo;
        $businessEmail = $user->email;
        $businessNumber = $user->mobile;

        if ($businessLogo != '') {
            /*Move logo to public directory*/
            File::copy(asset('assets/business/logos/' . $businessLogo), public_path('assets/business/logos/' . $businessLogo));
            if (file_exists(public_path('assets/business/logos/' . $businessLogo))) {
                $img->insert(public_path('assets/business/logos/' . $businessLogo), 'center-top', 0, 50);
            }

            $img->text($businessName, 365, 400, function ($font) {
                $font->file(public_path('fonts/Poppins-Bold.ttf'));
                $font->size(36);
                $font->color('#000000');
                $font->align('center');
                $font->valign('top');
                $font->angle(0);
            });

            $img->insert(public_path('assets/business/icons.png'), 'left-bottom', 50, 50);

            $img->text($businessEmail, 110, 520, function ($font) {
                $font->file(public_path('fonts/Poppins-Medium.ttf'));
                $font->size(28);
                $font->color('#000000');
                $font->angle(0);
            });

            $img->text($businessNumber, 110, 590, function ($font) {
                $font->file(public_path('fonts/Poppins-Medium.ttf'));
                $font->size(28);
                $font->color('#000000');
                $font->angle(0);
            });
        } else {
            $nameArr = explode(' ', $businessName);
            $name = '';
            $height = 150;
            foreach ($nameArr as $word) {
                $img->text($word, 365, $height, function ($font) {
                    $font->file(public_path('fonts/Poppins-Bold.ttf'));
                    $font->size(45);
                    $font->color('#000000');
                    $font->align('center');
                    $font->valign('top');
                    $font->angle(0);
                });
                $height = $height + 70;
            }

            $img->insert(public_path('assets/business/icons.png'), 'left-bottom', 150, 150);

            $img->text($businessEmail, 210, 415, function ($font) {
                $font->file(public_path('fonts/Poppins-Medium.ttf'));
                $font->size(28);
                $font->color('#000000');
                $font->angle(0);
            });

            $img->text($businessNumber, 210, 490, function ($font) {
                $font->file(public_path('fonts/Poppins-Medium.ttf'));
                $font->size(28);
                $font->color('#000000');
                $font->angle(0);
            });
        }

        $img->save(public_path('assets/business/Website-offer-thumb-' . $user->id . '.jpg'));

        $details->thumbnail = 'Website-offer-thumb-' . $user->id . '.jpg';
        $details->save();
    }

    public function businessAddress(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        $findGoogleMap = 'https://www.google.com/maps/';
        $find_google_map = strpos($request->google_map_link, $findGoogleMap);

        if ($find_google_map != 0 || $find_google_map === false) {
            $findGoogleMap = 'https://www.google.co.in/maps/';
            $find_google_map = strpos($request->google_map_link, $findGoogleMap);
        }

        if ($find_google_map != 0 || $find_google_map === false) {
            $findGoogleMap = 'https://goo.gl/maps/';
            $find_google_map = strpos($request->google_map_link, $findGoogleMap);
        }

        if ($request->google_map_link != '' && ($find_google_map != 0 || $find_google_map === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid google map link']);
        }

        $whatsappSession = WhatsappSession::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();

        if (isset($whatsappSession->wa_number)) {
            $wa_number = substr($whatsappSession->wa_number, 2);
        } else {
            $wa_number = '';
        }

        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($request->chkNumber == 'on') {
            $whatsapp_number = $wa_number;
            $calling_number = $wa_number;
        } else {
            $whatsapp_number = $wa_number;
            $calling_number = $request->call_number;
        }

        if ($details != null) {
            $details->call_number = $calling_number;
            // $details->whatsapp_number = $whatsapp_number;
            $details->address_line_1 = ucwords(strtolower($request->address_line_1));
            $details->address_line_2 = ucwords(strtolower($request->address_line_2));
            $details->pincode = $request->pincode;
            $details->city = ucwords(strtolower($request->city));
            $details->state = ucwords(strtolower($request->state));
            $details->google_map_link = $request->google_map_link ?? '';
        } else {
            $details = new BusinessDetail();
            $details->user_id = $user_id;
            $details->uuid = $user_id . 'BUSI' . date('Ymd');
            $details->call_number = $calling_number;
            // $details->whatsapp_number = $whatsapp_number;
            $details->address_line_1 = ucwords(strtolower($request->address_line_1));
            $details->address_line_2 = ucwords(strtolower($request->address_line_2));
            $details->pincode = $request->pincode;
            $details->city = ucwords(strtolower($request->city));
        }

        if ($details->is_same_address == 1) {
            $details->billing_address_line_1 = ucwords(strtolower($request->address_line_1));
            $details->billing_address_line_2 = ucwords(strtolower($request->address_line_2));
            $details->billing_pincode = $request->pincode;
            $details->billing_city = ucwords(strtolower($request->city));
        }

        $details->google_map_link = $request->google_map_link ?? '';

        if ($details->save()) {
            return response()->json(['status' => true, 'message' => 'Business Address Updated Successfully', 'tab' => 'business_address']);
        } else {
            return response()->json(['status' => false, 'message' => 'Business Address Not Updated.']);
        }
    }

    public function checkSameBilling(Request $request)
    {
        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($details != null) {
            if ($details->state != null) {
                $details->is_same_address = 1;
                $details->billing_address_line_1 = ucwords(strtolower($details->address_line_1));
                $details->billing_address_line_2 = ucwords(strtolower($details->address_line_2));
                $details->billing_pincode = $details->pincode;
                $details->billing_city = ucwords(strtolower($details->city));
                $details->billing_state = ucwords(strtolower($details->state));
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Submit Billing Address First!']);
        }

        if ($details->save()) {
            return response()->json(['status' => true, 'message' => 'Billing Address Updated Successfully', 'details' => $details, 'tab' => 'billing_address']);
        } else {
            return response()->json(['status' => false, 'message' => 'Billing Address Not Updated.']);
        }
    }

    public function billingAddress(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($details != null) {
            // $details->is_same_address = 0;
            $details->billing_address_line_1 = ucwords(strtolower($request->billing_address_line_1));
            $details->billing_address_line_2 = ucwords(strtolower($request->billing_address_line_2));
            $details->billing_pincode = $request->billing_pincode;
            $details->billing_city = ucwords(strtolower($request->billing_city));
            $details->billing_state = ucwords(strtolower($request->billing_state));
        } else {
            $details = new BusinessDetail();
            $details->uuid = $user_id . 'BUSI' . date('Ymd');
            // $details->is_same_address = 0;
            $details->billing_address_line_1 = ucwords(strtolower($request->billing_address_line_1));
            $details->billing_address_line_2 = ucwords(strtolower($request->billing_address_line_2));
            $details->billing_pincode = $request->billing_pincode;
            $details->billing_city = ucwords(strtolower($request->billing_city));
            $details->billing_state = ucwords(strtolower($request->billing_state));
        }

        if ($details->is_same_address == 1) {
            $details->address_line_1 = ucwords(strtolower($request->billing_address_line_1));
            $details->address_line_2 = ucwords(strtolower($request->billing_address_line_2));
            $details->pincode = $request->billing_pincode;
            $details->city = ucwords(strtolower($request->billing_city));
            $details->state = ucwords(strtolower($request->billing_state));
        }

        if ($details->save()) {
            return response()->json(['status' => true, 'message' => 'Billing Address Updated Successfully', 'tab' => 'billing_address']);
        } else {
            return response()->json(['status' => false, 'message' => 'Billing Address Not Updated.']);
        }
    }

    public function deleteBilling()
    {
        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        $details->is_same_address = 0;
        $details->billing_address_line_1 = null;
        $details->billing_address_line_2 = null;
        $details->billing_pincode = null;
        $details->billing_city = null;
        $details->billing_state = null;

        $details->save();

        return response()->json(['status' => true, 'message' => 'Business Address Deleted.', 'tab' => 'billing_delete']);
    }

    public function socialLinks(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        $findfb = 'facebook.com';
        $findin = 'instagram.com';
        $findtw = 'twitter.com';
        $findli = 'linkedin.com';
        $findyt = 'youtube.com';

        if ($request->facebook_link == '' && $request->instagram_link == '' && $request->twitter_link == '' && $request->linkedin_link == '' && $request->youtube_link == '' && $request->google_review_placeid == '') {
            return response()->json(['status' => false, 'message' => 'Can not update blank fields.']);
        }

        $find_fb_url = strpos($request->facebook_link, $findfb);
        if ($request->facebook_link != '' && ($find_fb_url === false || strpos($request->facebook_link, 'https') === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid facebook page link.']);
        }

        $insta_profile_url = strpos($request->instagram_link, $findin);
        if ($request->instagram_link != '' && ($insta_profile_url === false || strpos($request->instagram_link, 'https') === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid instagram profile link.']);
        }

        $find_tw_tweet_url = strpos($request->twitter_link, $findtw);
        if ($request->twitter_link != '' && ($find_tw_tweet_url === false || strpos($request->twitter_link, 'https') === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid twitter link.']);
        }

        $find_li_company_url = strpos($request->linkedin_link, $findli);
        if ($request->linkedin_link != '' && ($find_li_company_url === false || strpos($request->linkedin_link, 'https') === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid linkedin page link.']);
        }

        $find_yt_channel_url = strpos($request->youtube_link, $findyt);
        if ($request->youtube_link != '' && ($find_yt_channel_url === false || strpos($request->youtube_link, 'https') === false)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid youtube channel link.']);
        }

        if ($request->google_review_placeid != '' && Str::length($request->google_review_placeid) < 0) {
            return response()->json(['status' => false, 'message' => 'Please enter valid place id.']);
        }

        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($details) {
            $details->facebook_link = $request->facebook_link;
            $details->instagram_link = $request->instagram_link;
            $details->twitter_link = $request->twitter_link;
            $details->linkedin_link = $request->linkedin_link;
            $details->youtube_link = $request->youtube_link;
            $details->google_review_placeid = $request->google_review_placeid;
            $details->website = $request->website;
        } else {
            $details = new BusinessDetail();
            $details->user_id = $user_id;
            $details->uuid = $user_id . 'BUSI' . date('Ymd');
            $details->facebook_link = $request->facebook_link;
            $details->instagram_link = $request->instagram_link;
            $details->twitter_link = $request->twitter_link;
            $details->linkedin_link = $request->linkedin_link;
            $details->youtube_link = $request->youtube_link;
            $details->google_review_placeid = $request->google_review_placeid;
            $details->website = $request->website;
        }

        if ($details->save()) {
            $instanceTask = InstantTask::whereUserId(Auth::id())
                ->whereNull('deleted_at')
                ->whereTaskId(13)
                ->orderBy('id', 'DESC')
                ->first();

            $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
            if ($userSocialConnection == null) {
                $userSocialConnection = new UserSocialConnection();
                $userSocialConnection->user_id = Auth::id();
            }

            if ($request->google_review_placeid != '') {
                if ($instanceTask == null) {
                    $newInstantTask = new InstantTask();
                    $newInstantTask->user_id = Auth::id();
                    $newInstantTask->task_id = 13;
                    $newInstantTask->task_value = $request->google_review_placeid;
                    $newInstantTask->save();
                } else {
                    if ($instanceTask->task_value != $request->google_review_placeid) {
                        $instanceTask->deleted_at = Carbon::now();
                        $instanceTask->save();

                        $newInstantTask = new InstantTask();
                        $newInstantTask->user_id = Auth::id();
                        $newInstantTask->task_id = 13;
                        $newInstantTask->task_value = $request->google_review_placeid;
                        $newInstantTask->save();
                    }
                }

                $userSocialConnection->is_google_auth = 1;
                $userSocialConnection->save();
            } else {
                if ($instanceTask != null) {
                    $instanceTask->deleted_at = Carbon::now();
                    $instanceTask->save();
                }

                $userSocialConnection->is_google_auth = 0;
                $userSocialConnection->save();
            }

            return response()->json(['status' => true, 'message' => 'Details Updated Successfully', 'tab' => 'social']);
        } else {
            return response()->json(['status' => false, 'message' => 'Details Not Updated.']);
        }
    }

    public function logoImage($request)
    {
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
                $folderPath = base_path('../assets/business/logos/');

                $image_parts = explode(';base64,', $request->imagestring);

                $image_type_aux = explode('image/', $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fileName = 'openlink-business-logo-' . date('dmYhis', time()) . '.' . $extension;
                $file = $folderPath . $fileName;

                file_put_contents($file, $image_base64);

                $img = Image::make($file);
                $img->encode($extension, 75)->save($file);

                //dd($file);

                return ['status' => true, 'file' => $fileName];
            } else {
                return ['status' => false, 'message' => 'Business Logo file must be an image (jpg, jpeg or png).'];
            }
        } else {
            return ['status' => false, 'message' => 'Please select an Business Logo.'];
        }
    }

    public function deleteLogo(Request $request)
    {
        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($details) {
            $logo = asset('assets/business/logos/' . $details->logo);
            $logo_folder = asset('assets/business/logos');
            if (file_exists($logo)) {
                unlink(base_path() . 'assets/business/logos/' . $details->logo);
            }
            BusinessDetail::where('user_id', $user_id)->update([
                'logo' => '',
            ]);
            return ['status' => true, 'message' => 'Business Logo has been removed!', 'icon' => 'success'];
        } else {
            return ['status' => false, 'message' => 'Something went wrong.', 'icon' => 'error'];
        }
    }

    public function updateListStyle(Request $request)
    {
        $business = Session('bussiness_detail');

        $businessDetail = BusinessDetail::where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();
        $businessDetail->list_type = $request->data;
        $businessDetail->save();

        return response()->json(['Updated']);
    }

    public function viewNotification($id)
    {
        $notification = EmailJob::where('id', $id)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        $notification->mark_read = '1';
        $notification->save();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.message_view', compact('notification', 'notification_list', 'planData'));
    }

    public function markRead(Request $request)
    {
        $notification = EmailJob::where('id', $request->noti_id)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        $notification->mark_read = '1';
        $notification->save();

        return response()->json(['Marked as read!']);
    }

    public function markUnRead(Request $request)
    {
        $notification = EmailJob::where('id', $request->noti_id)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        $notification->mark_read = '0';
        $notification->save();

        return response()->json(['Marked as unread!']);
    }

    public function markDeleted(Request $request)
    {
        $notification = EmailJob::where('id', $request->noti_id)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();
        $notification->mark_deleted = '1';
        $notification->save();

        return response()->json(['Deleted Successfully!']);
    }

    // Dataload function
    public function notifications(Request $request)
    {
        header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
        header('Pragma: no-cache'); // HTTP 1.0.
        header('Expires: 0 '); // Proxies.

        $results = EmailJob::where('user_id', Auth::id())
            ->where('mark_deleted', '0')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // dd($results);
        $notifications = ''; 

        if ($request->ajax()) {
            foreach ($results as $notification) {
                if ($notification->mark_read == '1') {
                    $readed = 'readed';
                    $read_hide_btn = 'hide_btn';
                } else {
                    $readed = '';
                    $read_hide_btn = '';
                }

                if ($notification->mark_read == '0') {
                    $unread_hide_btn = 'hide_btn';
                } else {
                    $unread_hide_btn = '';
                }

                $date = $notification->created_at->diffForHumans();

                $url = route('business.viewNotification', $notification->id);

                $notifications .=
                    '<div id="notification_sec' .
                    $notification->id .
                    '" class="activity ' .
                    $readed .
                    '"><div class="activity-icon bg-primary text-white shadow-primary"><i class="fa fa-bell"></i></div><div class="activity-detail"><div class="mb-2 d-flex justify-content-between"><span class="text-job text-primary">' .
                    $date .
                    '</span><div class="dropdown"><a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a><div class="dropdown-menu dropdown-menu-right"><div class="dropdown-title">Action</div><a href="#" id="' .
                    $notification->id .
                    '" class="dropdown-item has-icon mark-read mark-read-' .
                    $notification->id .
                    ' ' .
                    $read_hide_btn .
                    '"><i class="fas fa-eye"></i> Mark as Read</a><a href="#" id="' .
                    $notification->id .
                    '" class="dropdown-item has-icon mark-unread mark-unread-' .
                    $notification->id .
                    ' ' .
                    $unread_hide_btn .
                    '"><i class="fas fa-eye-slash"></i> Mark as Unread</a><a href="#" id="' .
                    $notification->id .
                    '" class="dropdown-item has-icon mark-deleted"><i class="fas fa-trash"></i> Delete</a><a id="noti_url_' .
                    $notification->id .
                    '" href="' .
                    $url .
                    '" style="display:none">URL</a></div></div></div><div class="mt-3 notification-detail" id="notification_detail' .
                    $notification->id .
                    '"><p class="noti-title"><b style="font-size: 15px;">' .
                    $notification->subject .
                    '</b></p><hr class="my-2"><p style="font-size: 13px;">' .
                    $notification->message .
                    '</p></div></div></div>';
            }

            return $notifications;
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.message_list', compact('notification_list', 'planData', 'results'));
    }

    public function cropper()
    {
        return view('business.cropper');
    }

    public function upload(Request $request)
    {
        $folderPath = public_path('upload/');

        $image_parts = explode(';base64,', $request->image);

        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.jpg';

        file_put_contents($file, $image_base64);

        $img = Image::make($file);

        $img->encode('jpg', 75)->save($folderPath . uniqid() . '_hq.jpg');

        // --------- [ Resize Image ] ---------------
        $img->resize(150, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($folderPath . uniqid() . '_150x100.jpg');

        return response()->json(['success' => 'success']);
    }

    public function updateSocialLink(Request $request)
    {
        $findfb = 'facebook.com';
        $findin = 'instagram.com';
        $findtw = 'twitter.com';
        $findli = 'linkedin.com';
        $findyt = 'youtube.com';

        $businessDetail = BusinessDetail::where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->first();
        if ($request->social_link == 'twitter_link') {
            $find_tw_url = strpos($request->social_value, $findtw);
            if ($request->social_value != '' && $find_tw_url === false) {
                return response()->json(['status' => false, 'message' => 'Please enter valid Twitter page link.']);
            }

            $businessDetail->twitter_link = $request->social_value;
        } elseif ($request->social_link == 'facebook_link') {
            $find_fb_url = strpos($request->social_value, $findfb);
            if ($request->social_value != '' && $find_fb_url === false) {
                return response()->json(['status' => false, 'message' => 'Please enter valid Facebook page link.']);
            }

            $businessDetail->facebook_link = $request->social_value;
        } elseif ($request->social_link == 'linkedin_link') {
            $find_li_url = strpos($request->social_value, $findli);
            if ($request->social_value != '' && $find_li_url === false) {
                return response()->json(['status' => false, 'message' => 'Please enter valid LinkedIn page link.']);
            }

            $businessDetail->linkedin_link = $request->social_value;
        }

        if ($businessDetail->save()) {
            return response()->json(['status' => true, 'message' => 'Link update successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to update Link!']);
        }
    }

    public function storeVcardDetail(Request $request)
    {
        /* Restrict Sale Person */
        if (Auth::user()->is_sales_person == 1 && Auth::user()->is_sales_admin == 0 && Auth::user()->is_demo == 0) {
            return response()->json(['status' => false, 'message' => 'You are not authorised to perform this action.']);
        }

        $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
        if ($businessDetail == null) {
            $businessDetail = new BusinessDetail();
        }

        $businessDetail->vcard_type = $request->vw_page;
        $businessDetail->business_card_id = $request->select_v_card;
        $businessDetail->webpage_url = $request->website_url;

        if ($businessDetail->save()) {
            return response()->json(['status' => true, 'message' => 'Data updated successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to update data!']);
        }
    }

    // preview V-card
    public function vcardInfoPreview(Request $request, $id = null)
    {
        $businessDetail = BusinessDetail::with('owner', 'stateDetail')
            ->where('user_id', Auth::id())
            ->first();
        // dd($businessDetail);
        return view('front.business_cards.' . $id, compact('businessDetail'));
    }

    //convert Paid To Free
    public function convertPaidToFree()
    {
        $yesterday = Carbon::now()
            ->subDays(1)
            ->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');

        $activeOffersIds = Offer::where('user_id', Auth::id())
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->pluck('id')
            ->toArray();

        if (!empty($activeOffersIds)) {
            $subscriptionsIds = OfferSubscription::whereIn('offer_id', $activeOffersIds)
                ->where('status', '1')
                ->pluck('id')
                ->toArray();

            if (!empty($subscriptionsIds)) {
                OfferSubscription::whereIn('id', $subscriptionsIds)->update(['status' => '3']);
            }

            foreach ($activeOffersIds as $offersId) {
                $offer = Offer::find($offersId);
                if (\Carbon\Carbon::parse($offer->start_date)->format('Y-m-d') == $today) {
                    $offer->start_date = $yesterday;
                }
                $offer->end_date = $yesterday;
                $offer->save();
            }
        }

        $shareReward = OfferReward::where('user_id', Auth::id())
            ->where('channel_id', 3)
            ->first();
        if ($shareReward != null) {
            $shareReward->type = 'Free';
            $shareReward->details = '{"minimum_click":"1"}';
            $shareReward->save();
        }

        $instantReward = OfferReward::where('user_id', Auth::id())
            ->where('channel_id', 2)
            ->first();
        if ($instantReward != null) {
            $instantReward->type = 'Free';
            $instantReward->details = '{"minimum_task":"1"}';
            $instantReward->save();
        }

        $smsRouteData = MessageRoute::where('user_id', Auth::id())
             ->pluck('id')
             ->toArray();
         if ($smsRouteData != null) {
             foreach ($smsRouteData as $smsId) {
                 $oldSmsRoute = MessageRoute::find($smsId);
                 $oldSmsRoute->old_sms = $oldSmsRoute->sms;
                 $oldSmsRoute->sms = 0;
                 $oldSmsRoute->save();
             }
         }

        $user = User::find(Auth::id());
        $user->current_account_status = 'free';
        $user->save();

        /*$message = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 7)
            ->first();
        $message->is_scheduled = 0;
        $message->save();*/

        /*$message = MessageTemplateSchedule::where('user_id', Auth::id())
            ->where('message_template_category_id', 8)
            ->first();
        $message->is_scheduled = 0;
        $message->save();*/

        //mark expired
        dispatch(new DeleteExpiredOfferInstantTaskJob());

        return response()->json(['status' => true, 'message' => 'Success']);
    }

    public function storeUserMobile(Request $request)
    {
        $rules = [
            'mobile' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10',
        ];

        $messages = [
            'mobile.required' => 'Mobile number can not empty!',
        ];

        $this->validate($request, $rules, $messages);

        $user_id = Auth::id();
        $checkNumber = NotificationContact::where('mobile', $request->mobile)->where('user_id', $user_id)->first();
        $checkWaNumber = BusinessDetail::where('whatsapp_number', '91'.$request->mobile)->where('user_id', $user_id)->first();
        $total_contact = NotificationContact::where('user_id', $user_id)->count();

        if (!$checkNumber && !$checkWaNumber) {
            $notification_contact = new NotificationContact();
            $notification_contact->user_id = $user_id;
            $notification_contact->mobile = $request->mobile;

            if ($total_contact < 5) {
                $notification_contact->save();
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'You can not add more than 5 number!',
                ]);
            }

            if ($notification_contact) {
                return response()->json([
                    'status' => true,
                    'message' => 'Number Saved Successfully!',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Number Saving Failed!',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'The mobile has already been taken',
            ]);
        }
    }

    public function destroyNumber(Request $request, $id)
    {
        NotificationContact::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Number deleted successfully!',
        ]);
    }

    /* Daily report time save start */
    public function dailyReportTime(Request $request)
    {
        $validatedData = $request->validate([
            'daily_reporting_time' => 'required',
        ]);

        $user_id = Auth::id();
        $details = BusinessDetail::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($details !== '') {
            $details->daily_reporting_time = $request->daily_reporting_time;
        } else {
            $details = '';
        }

        if ($details->save()) {
            return response()->json([
                'status' => true,
                'message' => 'Daily report time update successfully!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Daily report time not update successfully!',
            ]);
        }
    }
    /* Daily report time save end */

    /* mark all as read start */
    public function markAllAsRead(Request $request)
    {
        $user_id = Auth::id();
        $results = EmailJob::where('user_id', $user_id)
        ->where('mark_read', '0')
        ->where('mark_deleted', '0')
        ->orderBy('created_at', 'desc')
        ->get();
        
        if (count($results) > 0) {
            foreach ($results as $key => $notification) {
                if ($notification->mark_read == '0') {
                    $notification->mark_read = 1;
                    $notification->save();
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'All notification marked as read!']);
        }else {
            return response()->json([
                'status' => false,
                'message' => 'No unread notification available!']);
        }
    }
    /* mark all as read end */
}
