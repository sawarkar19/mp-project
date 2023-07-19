<?php

namespace App\Http\Controllers\Auth;

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
use App\Models\BusinessDetail;
use App\Models\FreeTransaction;
use App\Models\WhatsappSession;

use App\Models\PlanGroupChannel;

use App\Models\UserNotification;
use App\Models\SocialAccountCount;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\MessageTemplateSchedule;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\WaApiController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SalesroboController;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'number', 'max:10', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Sending OTP to business mobile number
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function send_otp(Request $request)
    {
        
        // dd(Session()->all());
        $mobile=User::where('mobile',$request->mobile_number)->first();
        $email=User::where('email',$request->email)->first();

        if(!empty($mobile)){
            return response()->json(["for"=>"mobile", "type"=>"error", "message"=>"Oops the mobile number already exists...!!"]);
            
        }else if(!empty($email)){
            return response()->json(["for"=>"email", "type"=>"error", "message"=>"Oops the email address already exists...!!"]);

        }else{
            $clientIP = request()->ip();

            $checkOTP = IpUser::where('mobile', $request->mobile_number)
            ->where('date', Carbon::today())
            ->get();

            // echo json_encode($checkOTP);

            if(count($checkOTP) <= 2){

                session_start();
                $number = $request->mobile_number;
                $name = $request->name;
                $email = $request->email;
                $password = $request->password;
                $otp = rand(100000, 999999);

                Session(['session_otp' => $otp]);
                Session(['session_number' => $number]);
                Session(['name' => $name]);
                Session(['email' => $email]);
                Session(['password' => $password]);

                //send OTP
                // $message = $otp." is your OpenLink account verification code.";
                // $this->sendMessage($number, $message);
                $payload = \App\Http\Controllers\WACloudApiController::mp_sendotp('91'.$number, $otp);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_sendotp';
                $addmin_history->message_sent_to = $number;
                $addmin_history->save();
                /* Admin Message History end */

                $otp_save = new IpUser;
                $otp_save->user_ip = $clientIP;
                $otp_save->mobile = $number;
                $otp_save->date = Carbon::today();
                $otp_save->is_sent = 1;
                $otp_save->save();

                $otp_count = IpUser::where('mobile', $number)->whereDate('date', Carbon::today())->count();

                return response()->json(["type"=>"success","message"=>"OTP sent on your whatsapp number.","sessionVal"=> Session()->get('session_number'),"name"=>Session()->get('name'), 'otp_count'=> $otp_count]);

            }else{                
                return response()->json(["type"=>"error","message"=>"OTP usage limit exceeded for this number. Try another number."]);
                
            }
        }
            
    }

    public function resend_otp(Request $request){

        $clientIP = request()->ip();

        $checkOTP = IpUser::where('mobile', $request->mobile_number)
        ->where('date', Carbon::today())
        ->get();

        // echo json_encode($checkOTP);

        if(count($checkOTP) <= 2){

            session_start();
            $number = $request->mobile_number;
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $otp = rand(100000, 999999);

            Session(['session_otp' => $otp]);
            Session(['session_number' => $number]);
            Session(['name' => $name]);
            Session(['email' => $email]);
            Session(['password' => $password]);

            //send OTP
            // $message = $otp." is your OpenLink account verification code.";
            // $this->sendMessage($number, $message);
            $payload = \App\Http\Controllers\WACloudApiController::mp_sendotp('91'.$number, $otp);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_sendotp';
            $addmin_history->message_sent_to = $number;
            $addmin_history->save();
            /* Admin Message History end */

            $otp_save = new IpUser;
            $otp_save->user_ip = $clientIP;
            $otp_save->mobile = $number;
            $otp_save->date = Carbon::today();
            $otp_save->is_sent = 1;
            $otp_save->save();

            $otp_count = IpUser::where('mobile', $number)->whereDate('date', Carbon::today())->count();

            return response()->json(["type"=>"success","message"=>"OTP sent on your whatsapp number.","sessionVal"=> Session()->get('session_number'),"name"=>Session()->get('name'), 'otp_count'=> $otp_count]);
        }
    }

    /* public function sendMessage($number, $message){
        
        $paramDataArray = [
            'number' => "91".$number,
            'type' => 'text',
            'message' => $message,
            'instance_id' => '62E7A59A98BB1',
            'access_token' => 'ff5cf6ba225f2838d8d63dc52a8dcacd'
        ];        

        $waoptions=Option::where('key','oddek_url')->first();
        $waurl=$waoptions->value."/api/send.php";
             
        $paramData = http_build_query($paramDataArray);
        $ch = curl_init();              
        $getUrl = $waurl."?".$paramData;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        $response = curl_exec($ch);
        $output = json_decode($response);
        $err = curl_error($ch);

        if($err){
            return response()->json(["type"=>"error","message"=>"OTP not sent.",]);
        }else{
            return response()->json(["type"=>"success","message"=>"OTP sent on your whatsapp number."]);
        }
    } */

    /**
     * Verifying business new registered mobile number.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    /*
    public function createSocialAccount($pass){
        //API call to get whatsapp access token                       
        $postData = array(
            'fullname' => Session()->get('name'),
            'email' => 'ol_'.rand(100000, 999999).Session()->get('email'),
            'password' => Session()->get('password'),
            'confirm_password' => Session()->get('password'),
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
    */

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

    public function verify_otp(Request $request){

        session_start();
        $number = $request->mobile_number;
        $otp = $request->otp;

        if ($otp == Session()->get('session_otp') && $number == Session()->get('session_number')) { 
            Session()->forget('session_otp');

            // Create social account
            $pass = Hash::make(Session()->get('password'));
            // $access_token = $this->createSocialAccount($pass);

            /* Register user with new WA API Start */
            $api_data = [
                'email' => Session()->get('email'),
                'mobile' => $request->mobile_number,
                'name' => Session()->get('name'),
                'partner_key' => 'PRT-0IDR245P',
                'partner_id' => 3,
            ];
            $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
            /* Register user with new WA API End */
            

            // Create Social Post Account
            $socialPostParam = [
                'name'=>Session()->get('name'),
                'email'=>Session()->get('email'),
                'password'=>Session()->get('password'),
            ];
            $socialPostAuthToken = $this->socialPostAuth($socialPostParam);
            
            //Create User
            $user = new User;
            $user->name = ucwords(Session()->get('name'));
            $user->email = Session()->get('email');       
            $user->mobile = Session()->get('session_number');
            $user->password = $pass;
            $user->role_id = 2;
            // $user->wa_access_token = $access_token;
            $user->social_post_api_token = $socialPostAuthToken;
            $user->status = 1;
            $user->save();

            if($user != null){
                /* Add entry for default contact groups */
                $data = [
                    ['user_id' => $user->id, 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1],
                    ['user_id' => $user->id, 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]
                ];
                ContactGroup::insert($data);


                $data = [
                    ['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 2, 'details' => '{"minimum_task":"1"}'],
                    ['user_id' => $user->id, 'type' => 'Free', 'channel_id' => 3, 'details' => '{"minimum_click":"10"}'],
                ];
                OfferReward::insert($data);

                /* Payment */
                $expiry_date = Carbon::now()->addYears(100)->format('Y-m-d');

                $channelRoutes = \App\Http\Controllers\Business\ChannelController::msg_channels();
                foreach ($channelRoutes as $channel_r) {
                    $route=new MessageRoute;
                    $route->user_id = $user->id;
                    $route->channel_id = $channel_r->id;
                    $route->save();
                } 
                
                /*notification for user start */
                $notifications = Notification::where('status', 1)->get();
                foreach ($notifications as $notification) {
                    $user_notification = new UserNotification;
                    $user_notification->notification_id = $notification->id;
                    $user_notification->user_id = $user->id;
                    $user_notification->save();
                }
                /*notification for user  end*/

                //wallet
                $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
                $options=Option::whereIn('key',$key)->pluck('value')->toArray();
                $wallet = new MessageWallet;
                $wallet->user_id = $user->id;
                $wallet->wallet_balance = 0;
                $wallet->minimum_balance = $options[0];
                $wallet->messaging_api_daily_limit = $options[1];
                $wallet->messaging_api_daily_free_limit = $options[2];
                $wallet->will_expire_on = $expiry_date;
                $wallet->save();

                // $transaction = new FreeTransaction;
                // $transaction->user_id = $user->id;
                // $transaction->amount = $joining_bonus_data->value;
                // $transaction->save();

                // $wa_session = new WhatsappSession;
                $wa_session = WhatsappSession::where('user_id', $user->id)->first();
                if($wa_session == null){
                    $wa_session = new WhatsappSession;
                }
                $wa_session->user_id = $user->id;
                /* Store whatsapp session data for WA API Start */
                if($wa_registration["status"] == true && !empty($wa_registration["data"])){
                    $wa_session->key_id = $wa_registration["data"]["key_id"];
                    $wa_session->key_secret = $wa_registration["data"]["key_secret"];
                }
                /* Store whatsapp session data for WA API End */
                $wa_session->save(); 

                // Get Default V-Card Page
                $vcard = BusinessVcard::where('default_card', 1)->where('status', 1)->first();
                $defaultVcard = 5;
                if($vcard!=NULL){
                    $defaultVcard = $vcard->slug;
                }


                $contactGroup = ContactGroup::where('user_id', $user->id)->pluck('id')->toArray();

                // DB::enableQueryLog();

                // $contactGroup = ContactGroup::where('user_id', $user->id)->pluck('id')->toArray();
               
                // dd(DB::getQueryLog());
               
               
                $groups_id = implode(',', $contactGroup);
                // dd($groups_id);

                $details = new BusinessDetail;
                $details->user_id = $user->id;
                $details->uuid = $user->id.'BUSI'.date("Ymd");
                $details->call_number = Session()->get('session_number');
                $details->business_card_id = $defaultVcard;
                $details->save();


                /* Add Default Entry for Social Counts */
                $socialAccountCount = new SocialAccountCount;
                $socialAccountCount->user_id = $user->id;
                $socialAccountCount->fb_page_url_count = 0;
                $socialAccountCount->insta_profile_url_count = 0;
                $socialAccountCount->tw_username_count = 0;
                $socialAccountCount->li_company_url_count = 0;
                $socialAccountCount->yt_channel_url_count = 0;
                $socialAccountCount->google_review_link_count = 0;
                $socialAccountCount->save();

                $randomSender = \App\Http\Controllers\UuidTokenController::eightCharacterUniqueToken(8);
                
                $wa_api = new WhatsappApi;
                $wa_api->user_id = $user->id;
                $wa_api->username = 'WAAPI'.$user->id;
                $wa_api->password = $this->randomPassword();
                $wa_api->sendername = $randomSender;
                $wa_api->status = '1';
                $wa_api->save();

                //add channels 
                $channels = Channel::all();
                foreach($channels as $channel){
                    $userChannel = new UserChannel;
				    $userChannel->user_id = $user->id;
				    $userChannel->channel_id = $channel->id;
                    
                    if($channel->id == 4){
                        $userChannel->status = 0;
                    }

				    $userChannel->save(); 
                }
                

                // Save Personalised Messages
                // 1 Birthday
                $dobTemp = new MessageTemplateSchedule;
                $dobTemp->user_id = $user->id;
                $dobTemp->channel_id = 5;
                $dobTemp->template_id = 1;
                $dobTemp->related_to = 'Personal';
                $dobTemp->message_type_id = 1;
                $dobTemp->message_template_category_id = 7;
                $dobTemp->save();
                
                // 2 Anniversary
                $anniTemp = new MessageTemplateSchedule;
                $anniTemp->user_id = $user->id;
                $anniTemp->channel_id = 5;
                $anniTemp->template_id = 6;
                $anniTemp->related_to = 'Personal';
                $anniTemp->message_type_id = 1;
                $anniTemp->message_template_category_id = 8;
                $anniTemp->save();
                
                

                $all_festival = DB::table('festivals')->where('status', 1)->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))->get();
                
                // 3 Festivals
                foreach ($all_festival as $festival) {
                   
                    $festivalTemp = new MessageTemplateSchedule;
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
                    'id' => $user->id,
                    'name' => $user->name,
                    'mobile' => $user->mobile,
                    'email' => $user->email
                ];

                /* Send Whatsapp Message */
                $msg = \App\Http\Controllers\CommonMessageController::welcomeWpMessage($user->name);     

                
                $long_link = route('business.dashboard');
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "free_registration");
                
                $payload = \App\Http\Controllers\WACloudApiController::mp_fr_welcome_alert('91'.$user->mobile, $user->name, $shortLinkData->original["code"]);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_fr_welcome_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Send Mail */
                \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($data);


            }else{
                return response()->json(["type"=>"error", "message"=>"User not registered."]);
            }

            /*Add login entry*/
            $loginInfo = UserLogin::where('user_id', $user->id)->first();
            if($loginInfo == null){
                $loginInfo = new UserLogin;
            }
            $loginInfo->user_id = $user->id;
            $loginInfo->is_login = '1';
            $loginInfo->save();

            Auth()->login($user, true);

            $url = url('/registration-free/thankyou');

            return response()->json(["type"=>"success", "message"=>"Your mobile number Verified!",'url' => $url]);
            
        } else {
            return response()->json(["type"=>"error", "message"=>"OTP is incorrect!"]);
        }
    }

    public function getFreeInvoiceNo(){
        $transaction = Transaction::where('invoice_no', '!=', '')->where('invoice_no', 'like', '%FREE%')->orderBy('id','desc')->select('invoice_no')->first();
        
        $sr_no = 1;
        if($transaction != null){
            $sr_no = (substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1);
        }

        $currentYr = Carbon::now()->format('y');
        $month = date('m');

        if($month < 4){
            $currentYr = $currentYr - 1;
        }
        
        $nextYr = $currentYr + 1;

        $invoice_no = 'MP/FREE/'.$currentYr.'-'.$nextYr.'/'.$sr_no;
        
        return $invoice_no;
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
