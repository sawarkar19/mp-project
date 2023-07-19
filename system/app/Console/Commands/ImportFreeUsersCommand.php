<?php

namespace App\Console\Commands;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\IpUser;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Feature;

use PHPExcel_IOFactory;
use App\Models\Userplan;
use App\Models\PlanGroup;
use App\Models\UserLogin;
use App\Models\OfferReward;
use App\Models\Transaction;
use App\Models\UserChannel;

use App\Models\WhatsappApi;
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
use App\Models\PlanGroupChannel;
use App\Models\UserNotification;
use App\Models\SocialAccountCount;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;

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

class ImportFreeUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $address = base_path('../assets/business/customer-imports/Free_contact_users.xlsx');
        $spreadsheet = IOFactory::load($address);
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

                    // ===================================
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

                        //wallet
                        $wallet = new MessageWallet();
                        $wallet->user_id = $user->id;
                        $wallet->wallet_balance = 0;
                        $wallet->minimum_balance = $minimum_balance->value;
                        $wallet->will_expire_on = $expiry_date;
                        $wallet->save();

                        // $transaction = new FreeTransaction;
                        // $transaction->user_id = $user->id;
                        // $transaction->amount = $joining_bonus_data->value;
                        // $transaction->save();

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

                        // DB::enableQueryLog();

                        // $contactGroup = ContactGroup::where('user_id', $user->id)->pluck('id')->toArray();

                        // dd(DB::getQueryLog());

                        $groups_id = implode(',', $contactGroup);
                        // dd($groups_id);

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
    
                        
                        /* Send Mail */
                        dispatch(new ImportFreeUsersJob($data));
                        // \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($data);
                    } 
                    
                    // else {
                    //     return response()->json(['type' => 'error', 'message' => 'User not registered.']);
                    // }

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
                        'mauticform[f_name]' => $name,
                        'mauticform[whatsapp_number]' => $mobile,
                        'mauticform[email]' => $email,
                        'mauticform[formId]' => $form_id,
                        'mauticform[return]' => '',
                        'mauticform[formName]' => 'registerorsignupform',
                    ];
                    $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
                    /* END SalesRobo code */

                    // ===================================
                }
            }
        }
    }

    public function createSocialAccount($userData){
        //API call to get whatsapp access token                       
        $postData = array(
            'fullname' => $userData['name'],
            'email' => 'ol_'.rand(100000, 999999).$userData['email'],
            'password' => $userData['password'],
            'confirm_password' => $userData['password'],
        );

        //API URL
        $wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/signup.php";

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);

        if($output != null){
            if ($output->status == 'error') {
                $access_token = '';
            } else {
                $access_token = $output->token;
            }
        }else{
            $access_token = '';
        }
        
        return $access_token;
    }

    public function socialPostAuth($params=[]){
        //API URL
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/register";

        $params['webhook'] = route('getSocialPostInfo');

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);
        
        if(isset($output->status) && $output->status == true){
            $access_token = $output->data->api_token;
        }else{
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
