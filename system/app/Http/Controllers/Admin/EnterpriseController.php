<?php

namespace App\Http\Controllers\Admin;
use DB;
use URL;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Email;
use App\Models\IpUser;

use App\Models\Option;
use App\Models\Channel;
use App\Models\Feature;
use PHPExcel_IOFactory;
use App\Models\EmailJob;
use App\Models\Userplan;
use App\Models\PlanGroup;

use App\Models\UserLogin;
use App\Models\Enterprise;
use App\Models\OfferReward;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use Illuminate\Support\Str;

use App\Models\AdminMessage;
use App\Models\ContactGroup;

use App\Models\MessageRoute;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use App\Exports\ContactExport;
use App\Models\BusinessDetail;
use App\Models\FreeTransaction;
use App\Models\WhatsappSession;
use Illuminate\Console\Command;

use App\Jobs\ImportFreeUsersJob;
use App\Mail\CreatePasswordMail;
use App\Models\PlanGroupChannel;
use App\Models\UserNotification;
use App\Models\SocialAccountCount;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\MessageTemplateSchedule;
use App\Providers\RouteServiceProvider;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\WaApiController;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Controllers\SalesroboController;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Foundation\Auth\RegistersUsers;

class EnterpriseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enterprises = Enterprise::latest()->paginate(10);
        $enterprises_url = Session(['enterprises_url' => '#']);
        return view('admin.enterprises.index', compact('enterprises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enterprises = [];
        return view('admin.enterprises.create', compact('enterprises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:80',
            'email' => 'required',
            'mobile' => 'required|max:10',
        ];

        $messages = [
            'name.required' => 'Name can not be empty !',
            'email.required' => 'Email can not be empty !',
            'mobile.required' => 'Mobile can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $checkEmail = Enterprise::where('email', $request->email)->first();

        $checkMobile = Enterprise::where('mobile', $request->mobile)->first();

        if (!$checkEmail && !$checkMobile) {
            $checkUserEmail = User::where('email', $request->email)->first();
            $checkUserMobile = User::where('mobile', $request->mobile)->first();

            if (!$checkUserEmail && !$checkUserMobile) {
                $enterprise = new Enterprise();
                $enterprise->name = $request->name;
                $enterprise->email = $request->email;
                $enterprise->mobile = $request->mobile;
                $enterprise->wa_per_month_limit = $request->wa_per_month_limit;
                $enterprise->discount = $request->discount;
                $enterprise->commission = $request->commission;
                $enterprise->onetime_signup = $request->onetime_signup;
                $enterprise->type = $request->type;
                $enterprise->save();

                //uuid
                $enterprise->uuid = $enterprise->id.'E'.rand(100000,999999);
                $enterprise->save();

                if ($enterprise) {

                    // Create social account
                    $password = 12345678;
                    $pass = Hash::make($password);
                    $userData = [
                        'name' => $enterprise->name,
                        'email' => $enterprise->email,
                        'mobile' => $enterprise->mobile,
                        'password' => $pass,
                    ];
                    $access_token = $this->createSocialAccount($userData);

                    /* Register user with new WA API Start */
                    $api_data = [
                        'name' => $enterprise->name,
                        'email' => $enterprise->email,
                        'mobile' => $enterprise->mobile,
                        'partner_key' => 'PRT-0IDR245P',
                        'partner_id' => 3,
                    ];
                    $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
                    /* Register user with new WA API End */

                    // Create Social Post Account
                    $socialPostParam = [
                        'name' => $enterprise->name,
                        'email' => $enterprise->email,
                        'password' => $pass,
                    ];
                    $socialPostAuthToken = $this->socialPostAuth($socialPostParam);

                    $date = \Carbon\Carbon::now()->format('Ymd');
                    $randomCode = $this->getRandomCode(180);

                    //Create User
                    $user = new User();
                    $user->name = ucwords($enterprise->name);
                    $user->email = $enterprise->email;
                    $user->mobile = $enterprise->mobile;
                    $user->password = $pass;
                    $user->role_id = 2;
                    $user->is_enterprise = 1;
                    $user->pass_token = $randomCode . $date;
                    $user->wa_access_token = $access_token;
                    $user->social_post_api_token = $socialPostAuthToken;
                    $user->status = 1;
                    $user->save();

                    $enterprise->user_id = $user->id;
                    $enterprise->save();

                    

                    if ($user != null) {
                        /* Add entry for default contact groups */
                        $data = [['user_id' => $user->id, 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1], ['user_id' => $user->id, 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]];
                        ContactGroup::insert($data);

                        $data = [['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 2, 'details' => '{"minimum_task":"1"}'], ['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 3, 'details' => '{"minimum_click":"10"}']];
                        OfferReward::insert($data);

                        /* Payment */
                        $expiry_date = Carbon::now()
                            ->addYears(100)
                            ->format('Y-m-d');

                        $channelRoutes = \App\Http\Controllers\Business\ChannelController::msg_channels();
                        foreach ($channelRoutes as $channel_r) {
                            $route = new MessageRoute();
                            $route->user_id = $user->id;
                            $route->channel_id = $channel_r->id;
                            $route->save();
                        }

                        /*notification for user start */
                        $notifications = Notification::where('status', 1)->get();
                        foreach ($notifications as $notification) {
                            $user_notification = new UserNotification();
                            $user_notification->notification_id = $notification->id;
                            $user_notification->user_id = $user->id;
                            $user_notification->save();
                        }
                        /*notification for user  end*/

                        //Minimum Wallet Balance
                        $minimum_balance = Option::where('key', 'minimum_balance')->first();

                        //wallet
                        $wallet = new MessageWallet();
                        $wallet->user_id = $user->id;
                        $wallet->wallet_balance = 0;
                        $wallet->minimum_balance = $minimum_balance->value;
                        $wallet->enterprise_api_wa_limit = $enterprise->wa_per_month_limit;
                        $wallet->will_expire_on = $expiry_date;
                        $wallet->save();

                        // $wa_session = new WhatsappSession;
                        $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                        if ($wa_session == null) {
                            $wa_session = new WhatsappSession();
                        }
                        $wa_session->user_id = $user->id;
                        /* Store whatsapp session data for WA API Start */
                        if ($wa_registration['status'] == true && !empty($wa_registration['data'])) {
                            $wa_session->key_id = $wa_registration['data']['key_id'];
                            $wa_session->key_secret = $wa_registration['data']['key_secret'];
                        }
                        /* Store whatsapp session data for WA API End */
                        $wa_session->save();

                        // Get Default V-Card Page
                        $vcard = BusinessVcard::where('default_card', 1)
                            ->where('status', 1)
                            ->first();
                        $defaultVcard = 5;
                        if ($vcard != null) {
                            $defaultVcard = $vcard->slug;
                        }

                        $contactGroup = ContactGroup::where('user_id', $user->id)
                            ->pluck('id')
                            ->toArray();

                        $groups_id = implode(',', $contactGroup);

                        $details = new BusinessDetail();
                        $details->user_id = $user->id;
                        $details->uuid = $user->id . 'BUSI' . date('Ymd');
                        $details->call_number = $enterprise->mobile;
                        $details->business_card_id = $defaultVcard;
                        $details->save();

                        /* Add Default Entry for Social Counts */
                        $socialAccountCount = new SocialAccountCount();
                        $socialAccountCount->user_id = $user->id;
                        $socialAccountCount->fb_page_url_count = 0;
                        $socialAccountCount->insta_profile_url_count = 0;
                        $socialAccountCount->tw_username_count = 0;
                        $socialAccountCount->li_company_url_count = 0;
                        $socialAccountCount->yt_channel_url_count = 0;
                        $socialAccountCount->google_review_link_count = 0;
                        $socialAccountCount->save();

                        $randomSender = \App\Http\Controllers\UuidTokenController::eightCharacterUniqueToken(8);

                        $wa_api = new WhatsappApi();
                        $wa_api->user_id = $user->id;
                        $wa_api->username = 'WAAPI' . $user->id;
                        $wa_api->password = $this->randomPassword();
                        $wa_api->sendername = $randomSender;
                        $wa_api->status = '1';
                        $wa_api->save();

                        //add channels
                        $channels = Channel::all();
                        foreach ($channels as $channel) {
                            $userChannel = new UserChannel();
                            $userChannel->user_id = $user->id;
                            $userChannel->channel_id = $channel->id;

                            if ($channel->id == 4) {
                                $userChannel->status = 0;
                            }

                            $userChannel->save();
                        }

                        // Save Personalised Messages
                        // 1 Birthday
                        $dobTemp = new MessageTemplateSchedule();
                        $dobTemp->user_id = $user->id;
                        $dobTemp->channel_id = 5;
                        $dobTemp->template_id = 1;
                        $dobTemp->related_to = 'Personal';
                        $dobTemp->message_type_id = 1;
                        $dobTemp->message_template_category_id = 7;
                        $dobTemp->save();

                        // 2 Anniversary
                        $anniTemp = new MessageTemplateSchedule();
                        $anniTemp->user_id = $user->id;
                        $anniTemp->channel_id = 5;
                        $anniTemp->template_id = 6;
                        $anniTemp->related_to = 'Personal';
                        $anniTemp->message_type_id = 1;
                        $anniTemp->message_template_category_id = 8;
                        $anniTemp->save();

                        $all_festival = DB::table('festivals')
                            ->where('status', 1)
                            ->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))
                            ->get();

                        // 3 Festivals
                        foreach ($all_festival as $festival) {
                            $festivalTemp = new MessageTemplateSchedule();
                            $festivalTemp->user_id = $user->id;
                            $festivalTemp->channel_id = 5;
                            $festivalTemp->template_id = $festival->template_id;
                            $festivalTemp->message_type_id = $festival->message_type_id;
                            $festivalTemp->time_slot_id = $festival->time_slot_id;
                            $festivalTemp->related_to = 'Festival';
                            $festivalTemp->groups_id = $groups_id;
                            $festivalTemp->scheduled = $festival->festival_date;
                            $festivalTemp->message_template_category_id = $festival->message_template_category_id;
                            $festivalTemp->save();
                        }

                        $data = [
                            'user_id' => $user->id,
                            'name' => $user->name,
                            'mobile' => $user->mobile,
                            'email' => $user->email,
                            'token' => $user->pass_token,
                        ];

                        /* Send Whatsapp Message */
                        // $msg = \App\Http\Controllers\CommonMessageController::welcomeWpMessage($user->name);

                        $long_link = URL::to('/') . '/signin';
                        $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, 'free_registration');

                        $payload = \App\Http\Controllers\WACloudApiController::mp_genrate_password('91' . $user->mobile, $user->name, $shortLinkData->original['code']);
                        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                        /* Admin Message History start */
                        $addmin_history = new AdminMessage();
                        $addmin_history->template_name = 'mp_genrate_password';
                        $addmin_history->message_sent_to = $user->mobile;
                        $addmin_history->save();
                        /* Admin Message History end */

                        /* Send Email */
                        // $email_info = Email::where('id', 23)->first();

                        // $email = new CreatePasswordMail($data);
                        // Mail::to($data['email'])->send($email);

                        // $job = new EmailJob();
                        // $job->user_id = $user->id;
                        // $job->email_id = $email_info->id;
                        // $job->email = $user->email;
                        // $job->subject = $email_info->subject;
                        // $job->message = $email_info->content;
                        // $job->save();

                        // \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($data);
                    }

                    /*Add login entry*/
                    $loginInfo = UserLogin::where('user_id', $user->id)->first();
                    if ($loginInfo == null) {
                        $loginInfo = new UserLogin();
                    }
                    $loginInfo->user_id = $user->id;
                    $loginInfo->is_login = '1';
                    $loginInfo->save();

                    // Auth()->login($user, true);

                    /*
                     * Sending the data to the SalesRobo form.
                     */
                    $form_id = 5;
                    $data = [
                        'mauticform[f_name]' => $user->name,
                        'mauticform[whatsapp_number]' => $user->mobile,
                        'mauticform[email]' => $user->email,
                        'mauticform[formId]' => $form_id,
                        'mauticform[return]' => '',
                        'mauticform[formName]' => 'registerorsignupform',
                    ];
                    $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
                    /* END SalesRobo code */
                }

                $url = route('admin.enterprises.index', $request->id);
                return response()->json([
                    'status' => true,
                    'message' => 'Enterprise Added Successfully !',
                    'url' => $url,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Email and mobile is already exists !',
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email and mobile is already exists !',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $enterprises = Enterprise::find($id);
        Session([
            'id' => $id,
        ]);
        $users = User::where('enterprise_id', $id)
            ->where('status', 1)
            ->paginate(10);
        return view('admin.enterprises.show', compact('enterprises', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $enterprises_url = Session(['enterprises_url' => URL::previous()]);
        $enterprises = Enterprise::find($id);
        return view('admin.enterprises.edit', compact('enterprises'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:2|max:80',
            'email' => 'required',
            'mobile' => 'required|max:10',
        ];

        $messages = [
            'name.required' => 'Name can not be empty !',
            'email.required' => 'Email can not be empty !',
            'mobile.required' => 'Mobile can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $enterprises = Enterprise::find($id);
        $enterprises_url = Session::get('enterprises_url');
        $enterprises->name = $request->name;
        $enterprises->email = $request->email;
        $enterprises->mobile = $request->mobile;
        $enterprises->wa_per_month_limit = $request->wa_per_month_limit;
        $enterprises->discount = $request->discount;
        $enterprises->commission = $request->commission;
        $enterprises->onetime_signup = $request->onetime_signup;
        $enterprises->type = $request->type;
        $enterprises->save();

        return response()->json([
            'status' => true,
            'message' => 'Enterprise Updated Successfully !',
            'url' => $enterprises_url,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ids) {
            foreach ($request->ids as $id) {
                Enterprise::destroy($id);
            }
            return response()->json(['status' => true, 'message' => 'Successfully deleted !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Please select enterprise !']);
        }
    }

    public function importUsers(Request $request)
    {
        $file = $request->file('customer_list');

        if ($file) {
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            foreach ($sheetData as $key => $rows) {
                if ($key > 1) {
                    $mobile = $rows['C'];
                    $email = $rows['D'];
                    $name = $rows['B'];
                    $password = 12345678;

                    $userData = [
                        'name' => $name,
                        'email' => $email,
                        'mobile' => $mobile,
                        'password' => $password,
                    ];

                    $checkUser = User::where('email', $email)
                        ->where('mobile', $mobile)
                        ->first();
                    if ($checkUser == null) {
                        // Create social account
                        $pass = Hash::make($password);
                        $access_token = $this->createSocialAccount($userData);

                        /* Register user with new WA API Start */
                        $api_data = [
                            'email' => $email,
                            'mobile' => $mobile,
                            'name' => $name,
                            'partner_key' => 'PRT-0IDR245P',
                            'partner_id' => 3,
                        ];
                        $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
                        /* Register user with new WA API End */

                        // Create Social Post Account
                        $socialPostParam = [
                            'name' => $name,
                            'email' => $email,
                            'password' => $pass,
                        ];
                        $socialPostAuthToken = $this->socialPostAuth($socialPostParam);

                        $date = \Carbon\Carbon::now()->format('Ymd');
                        $randomCode = $this->getRandomCode(180);

                        //Create User
                        $user = new User();
                        $user->name = ucwords($name);
                        $user->email = $email;
                        $user->mobile = $mobile;
                        $user->enterprise_id = session()->get('id');
                        $user->password = $pass;
                        $user->role_id = 2;
                        $user->pass_token = $randomCode . $date;
                        $user->wa_access_token = $access_token;
                        $user->social_post_api_token = $socialPostAuthToken;
                        $user->status = 1;
                        $user->save();

                        if ($user != null) {
                            /* Add entry for default contact groups */
                            $data = [['user_id' => $user->id, 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1], ['user_id' => $user->id, 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]];
                            ContactGroup::insert($data);

                            $data = [['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 2, 'details' => '{"minimum_task":"1"}'], ['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 3, 'details' => '{"minimum_click":"10"}']];
                            OfferReward::insert($data);

                            /* Payment */
                            $expiry_date = Carbon::now()
                                ->addYears(100)
                                ->format('Y-m-d');

                            $channelRoutes = \App\Http\Controllers\Business\ChannelController::msg_channels();
                            foreach ($channelRoutes as $channel_r) {
                                $route = new MessageRoute();
                                $route->user_id = $user->id;
                                $route->channel_id = $channel_r->id;
                                $route->save();
                            }

                            /*notification for user start */
                            $notifications = Notification::where('status', 1)->get();
                            foreach ($notifications as $notification) {
                                $user_notification = new UserNotification();
                                $user_notification->notification_id = $notification->id;
                                $user_notification->user_id = $user->id;
                                $user_notification->save();
                            }
                            /*notification for user  end*/

                            //Minimum Wallet Balance
                            $minimum_balance = Option::where('key', 'minimum_balance')->first();

                            /*check enterprises id*/
                            $enterprise = Enterprise::where('id', session()->get('id'))->first();

                            //wallet
                            $wallet = new MessageWallet();
                            $wallet->user_id = $user->id;
                            $wallet->wallet_balance = 0;
                            $wallet->minimum_balance = $minimum_balance->value;
                            $wallet->enterprise_api_wa_limit = $enterprise->wa_per_month_limit;
                            $wallet->will_expire_on = $expiry_date;
                            $wallet->save();

                            // $wa_session = new WhatsappSession;
                            $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                            if ($wa_session == null) {
                                $wa_session = new WhatsappSession();
                            }
                            $wa_session->user_id = $user->id;
                            /* Store whatsapp session data for WA API Start */
                            if ($wa_registration['status'] == true && !empty($wa_registration['data'])) {
                                $wa_session->key_id = $wa_registration['data']['key_id'];
                                $wa_session->key_secret = $wa_registration['data']['key_secret'];
                            }
                            /* Store whatsapp session data for WA API End */
                            $wa_session->save();

                            // Get Default V-Card Page
                            $vcard = BusinessVcard::where('default_card', 1)
                                ->where('status', 1)
                                ->first();
                            $defaultVcard = 5;
                            if ($vcard != null) {
                                $defaultVcard = $vcard->slug;
                            }

                            $contactGroup = ContactGroup::where('user_id', $user->id)
                                ->pluck('id')
                                ->toArray();

                            $groups_id = implode(',', $contactGroup);

                            $details = new BusinessDetail();
                            $details->user_id = $user->id;
                            $details->uuid = $user->id . 'BUSI' . date('Ymd');
                            $details->call_number = $mobile;
                            $details->business_card_id = $defaultVcard;
                            $details->save();

                            /* Add Default Entry for Social Counts */
                            $socialAccountCount = new SocialAccountCount();
                            $socialAccountCount->user_id = $user->id;
                            $socialAccountCount->fb_page_url_count = 0;
                            $socialAccountCount->insta_profile_url_count = 0;
                            $socialAccountCount->tw_username_count = 0;
                            $socialAccountCount->li_company_url_count = 0;
                            $socialAccountCount->yt_channel_url_count = 0;
                            $socialAccountCount->google_review_link_count = 0;
                            $socialAccountCount->save();

                            $randomSender = \App\Http\Controllers\UuidTokenController::eightCharacterUniqueToken(8);

                            $wa_api = new WhatsappApi();
                            $wa_api->user_id = $user->id;
                            $wa_api->username = 'WAAPI' . $user->id;
                            $wa_api->password = $this->randomPassword();
                            $wa_api->sendername = $randomSender;
                            $wa_api->status = '1';
                            $wa_api->save();

                            //add channels
                            $channels = Channel::all();
                            foreach ($channels as $channel) {
                                $userChannel = new UserChannel();
                                $userChannel->user_id = $user->id;
                                $userChannel->channel_id = $channel->id;

                                if ($channel->id == 4) {
                                    $userChannel->status = 0;
                                }

                                $userChannel->save();
                            }

                            // Save Personalised Messages
                            // 1 Birthday
                            $dobTemp = new MessageTemplateSchedule();
                            $dobTemp->user_id = $user->id;
                            $dobTemp->channel_id = 5;
                            $dobTemp->template_id = 1;
                            $dobTemp->related_to = 'Personal';
                            $dobTemp->message_type_id = 1;
                            $dobTemp->message_template_category_id = 7;
                            $dobTemp->save();

                            // 2 Anniversary
                            $anniTemp = new MessageTemplateSchedule();
                            $anniTemp->user_id = $user->id;
                            $anniTemp->channel_id = 5;
                            $anniTemp->template_id = 6;
                            $anniTemp->related_to = 'Personal';
                            $anniTemp->message_type_id = 1;
                            $anniTemp->message_template_category_id = 8;
                            $anniTemp->save();

                            $all_festival = DB::table('festivals')
                                ->where('status', 1)
                                ->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))
                                ->get();

                            // 3 Festivals
                            foreach ($all_festival as $festival) {
                                $festivalTemp = new MessageTemplateSchedule();
                                $festivalTemp->user_id = $user->id;
                                $festivalTemp->channel_id = 5;
                                $festivalTemp->template_id = $festival->template_id;
                                $festivalTemp->message_type_id = $festival->message_type_id;
                                $festivalTemp->time_slot_id = $festival->time_slot_id;
                                $festivalTemp->related_to = 'Festival';
                                $festivalTemp->groups_id = $groups_id;
                                $festivalTemp->scheduled = $festival->festival_date;
                                $festivalTemp->message_template_category_id = $festival->message_template_category_id;
                                $festivalTemp->save();
                            }

                            $data = [
                                'user_id' => $user->id,
                                'name' => $user->name,
                                'mobile' => $user->mobile,
                                'email' => $user->email,
                                'token' => $user->pass_token,
                            ];

                            $long_link = URL::to('/') . '/signin';
                            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, 'free_registration');

                            $payload = \App\Http\Controllers\WACloudApiController::mp_genrate_password('91' . $user->mobile, $user->name, $shortLinkData->original['code']);
                            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                            /* Admin Message History start */
                            $addmin_history = new AdminMessage();
                            $addmin_history->template_name = 'mp_genrate_password';
                            $addmin_history->message_sent_to = $user->mobile;
                            $addmin_history->save();
                            /* Admin Message History end */

                            /* Send Mail */
                            dispatch(new ImportFreeUsersJob($data));
                        }
                    }
                }
            }
            return response()->json([
                'status' => true,
                'message' => 'Users added successfully !',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Please select file to upload !',
            ]);
        }
    }

    public function createSocialAccount($userData)
    {
        
        //API call to get whatsapp access token
        $postData = [
            'fullname' => $userData['name'],
            'email' => 'ol_' . rand(100000, 999999) . $userData['email'],
            'password' => $userData['password'],
            'confirm_password' => $userData['password'],
        ];

        //API URL
        $wa_url = Option::where('key', 'wa_api_url')->first();
        $url = $wa_url->value . '/api/signup.php';

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            //,CURLOPT_FOLLOWLOCATION => true
        ]);

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);

        if ($output != null) {
            if ($output->status == 'error') {
                $access_token = '';
            } else {
                $access_token = $output->token;
            }
        } else {
            $access_token = '';
        }

        return $access_token;
    }

    public function socialPostAuth($params = [])
    {
        //API URL
        $option = Option::where('key', 'social_post_url')->first();
        $url = $option->value . '/api/register';

        $params['webhook'] = route('getSocialPostInfo');

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params,
            //,CURLOPT_FOLLOWLOCATION => true
        ]);

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);

        if (isset($output->status) && $output->status == true) {
            $access_token = $output->data->api_token;
        } else {
            $access_token = '';
        }
        return $access_token;
    }

    public function getRandomCode($char = 8)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $char; $i++) {
            $index = rand(0, strlen($string) - 1);
            $randomCode .= $string[$index];
        }

        return $randomCode;
    }

    public function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = []; //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
