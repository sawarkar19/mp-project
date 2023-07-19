<?php

namespace App\Http\Controllers\Business\Partner;

use DB;
use Auth;

use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\State;
use App\Models\Coupon;
use App\Models\Option;
use App\Mail\OrderMail;
use App\Models\Channel;
use App\Models\Feature;

use App\Models\Category;

use App\Models\Employee;
use App\Models\Recharge;
use App\Models\Userplan;
use App\Models\PlanGroup;
use App\Models\UserLogin;
use App\Models\DirectPost;
use App\Models\Useroption;
use App\Models\OfferReward;
use App\Models\PaymentLink;
use App\Models\Transaction;

use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\AdminMessage;

use App\Models\Categorymeta;

use App\Models\ContactGroup;
use App\Models\MessageRoute;

use App\Models\UserEmployee;

use Illuminate\Http\Request;
use App\Models\BeforePayment;
use App\Models\BusinessVcard;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\WhatsappSession;
use App\Mail\CreatePasswordMail;
use App\Models\PlanGroupChannel;
use App\Helper\Subscription\PayU;
use App\Helper\Subscription\Paytm;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\Instamojo;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommonMessageController;
use App\Http\Controllers\Business\ChannelController;
use App\Http\Controllers\Business\CommonSettingController;

class PaymentController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function index()
    {
        $old_users = User::where('enterprise_id', Auth::id())
            ->where('role_id', 2)
            ->get();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('partner.plan.index', compact('notification_list', 'planData', 'old_users'));
    }

    public function updateUserDetail(Request $request)
    {
        $data = $request->all();

        if ($data['old_user'] == null) {
            $create = $this->createFreeUser($data);
            if ($create['status'] == false) {
                return response()->json(['status' => false, 'message' => $create['message'], 'link' => '']);
            }

            $data = $create['data'];
        } else {
            $user = User::find($data['old_user']);
            $data['business_name'] = $user->name;
            $data['business_email'] = $user->email;
            $data['business_mobile'] = $user->mobile;
        }

        $token = Auth::id() . rand(10, 100000000000000);
        Session([
            'user_data_' . $token => $data,
            'payment_token_id' => $token,
        ]);

        $link = route('business.partner.subscriptions', ['token' => $token]);

        return response()->json(['status' => true, 'message' => 'success', 'link' => $link]);
    }

    public function subscriptions(Request $request)
    {
        /* Get user from session */
        $planDataArr = $data = [];
        $paymentLink = '';

        $paymentLink = PaymentLink::where('payment_token', $request->token)
            ->where('status', '1')
            ->first();

        if ($paymentLink != null) {
            $planDataArr = json_decode($paymentLink->plan_data, true);
        }

        $data = Session::get('user_data_' . $request->token);
        if ($data == null && $paymentLink != null) {
            $data['old_user'] = $paymentLink->user_id;
            $data['business_name'] = $paymentLink->name;
            $data['business_email'] = $paymentLink->email;
            $data['business_mobile'] = $paymentLink->mobile;
        }

        $last_paid_transaction = Transaction::where('user_id', $data['old_user'])
            ->where('transaction_amount', '>', 0)
            ->orderBy('id', 'desc')
            ->first();
        $last_paid_tran_date = Carbon::now()->format('Y-m-d');
        if ($last_paid_transaction != null) {
            $last_paid_tran_date = Carbon::parse($last_paid_transaction->created_at)->format('Y-m-d');
        }

        $getways = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->where('slug', '!=', 'cod')
            ->with('preview')
            ->first();

        $renew_info = Option::where('key', 'renew_before_days')->first();

        $plans = Plan::where('is_default', 1)->first();
        $user_id = $data['old_user'];

        Session([
            'user_id' => $user_id,
            'plan_id' => $plans->id,
            'plan_name' => $plans->name,
        ]);

        $purchasedChannelIds = UserChannel::where('user_id', $data['old_user'])
            ->pluck('channel_id')
            ->toArray();

        $paidChannels = Channel::whereIn('id', $purchasedChannelIds)
            ->orderBy('price', 'asc')
            ->get();
        $unpaidChannels = Channel::whereNotIn('id', $purchasedChannelIds)->get();

        $users = UserEmployee::with('employee')
            ->where('user_id', $data['old_user'])
            ->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $message_plan = MessageWallet::where('user_id', $data['old_user'])->first();
        $message_plans = Recharge::where('status', 1)
            ->orderBy('ordering', 'asc')
            ->get();

        /* Plan Setting */
        $setting = Option::where('key', 'plan_setting')->first();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /* Save Payment Link */
        $paymentTokenId = Session::get('payment_token_id');

        return view('partner.plan.subscriptions', compact('paymentTokenId', 'notification_list', 'planData', 'getways', 'purchasedChannelIds', 'paidChannels', 'unpaidChannels', 'users', 'employee_price', 'message_plan', 'message_plans', 'plans', 'renew_info', 'last_paid_tran_date', 'setting', 'data', 'planDataArr', 'user_id'));
    }

    public function createFreeUser($userData = [])
    {
        $exist = User::where('email', $userData['business_email'])
            ->orWhere('mobile', $userData['business_mobile'])
            ->first();
        if ($exist != null) {
            return ['status' => false, 'message' => 'Email or mobile number already exist.', 'data' => []];
        }

        // Create social account
        $pass = Hash::make('password#123');
        $userData['pass'] = $pass;
        // $access_token = $this->createSocialAccount($userData);

        /* Register user with new WA API Start */
        $api_data = [
            'email' => $userData['business_email'],
            'mobile' => $userData['business_mobile'],
            'name' => $userData['business_name'],
            'partner_key' => 'PRT-0IDR245P',
            'enterprise_id' => 3,
        ];
        $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
        /* Register user with new WA API End */

        // Create Social Post Account
        $socialPostParam = [
            'name' => $userData['business_name'],
            'email' => $userData['business_email'],
            'password' => $pass,
        ];
        $socialPostAuthToken = $this->socialPostAuth($socialPostParam);

        $date = \Carbon\Carbon::now()->format('Ymd');
        $m = 180;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';
        for ($i = 0; $i < $m; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomCode .= $characters[$index];
        }

        $user = new User();
        $user->enterprise_id = Auth::id();
        $user->name = $userData['business_name'];
        $user->email = $userData['business_email'];
        $user->mobile = $userData['business_mobile'];
        $user->password = $pass;
        $user->role_id = 2;
        $user->pass_token = $randomCode . $date;
        // $user->wa_access_token = $access_token;
        $user->social_post_api_token = $socialPostAuthToken;
        $user->status = 0;
        $user->save();

        if ($user != null) {
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

            //Minimum Wallet Balance
            $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
            $options=Option::whereIn('key',$key)->pluck('value')->toArray();

            //wallet
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

            $randomSender = \App\Http\Controllers\UuidTokenController::eightCharacterUniqueToken(8);
            
            $wa_api = new WhatsappApi;
            $wa_api->user_id = $user->id;
            $wa_api->username = 'WAAPI'.$user->id;
            $wa_api->password = $this->randomPassword();
            $wa_api->sendername = $randomSender;
            $wa_api->status = '1';
            $wa_api->save();
            

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
            

             $all_festival = DB::table('festivals')->where('status', 1)->get();
        
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

            $userData['old_user'] = $user->id;

            return ['status' => true, 'message' => 'success', 'data' => $userData];
        }
    }

    /* 
    public function createSocialAccount($userData)
    {
        //API call to get whatsapp access token
        $postData = [
            'fullname' => $userData['business_name'],
            'email' => 'ol_' . rand(100000, 999999) . $userData['business_email'],
            'password' => $userData['pass'],
            'confirm_password' => $userData['pass'],
        ];

        //API URL
        $wa_url = Option::where('key', 'oddek_url')->first();
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

    public function getFreeInvoiceNo()
    {
        $transaction = Transaction::where('invoice_no', '!=', '')
            ->where('invoice_no', 'like', '%FREE%')
            ->orderBy('id', 'desc')
            ->select('invoice_no')
            ->first();

        $sr_no = 1;
        if ($transaction != null) {
            $sr_no = substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1;
        }

        $currentYr = Carbon::now()->format('y');
        $month = date('m');

        if ($month < 4) {
            $currentYr = $currentYr - 1;
        }

        $nextYr = $currentYr + 1;

        $invoice_no = 'MP/FREE/' . $currentYr . '-' . $nextYr . '/' . $sr_no;

        return $invoice_no;
    }

    public function proceedToPay(Request $request)
    {
        $planData = $request->except('_token');
        Session($planData);

        /* Save Payment Link */
        $paymentTokenId = Session::get('payment_token_id');
        $paymentLink = $this->create_payment_link($paymentTokenId);
        if ($paymentLink == null) {
            return response()->json(['status' => false, 'message' => 'Please try again later.', 'url' => '']);
        }

        $url = url('business/partner/make-payment/' . $planData['plan_id'] . '?token=' . $paymentTokenId);

        return response()->json(['status' => true, 'message' => 'Data stored in session', 'url' => $url]);
    }

    public function updatePriceToSession(Request $request)
    {
        $data = Session::all();

        Session([
            'payble_price' => $request['amount'],
        ]);
        $url = url('business/partner/make-payment/' . $data['plan_id'] . '?token=' . $data['payment_token_id']);

        return response()->json(['status' => true, 'url' => $url]);


    }

    public function make_payment(Request $request, $id)
    {
        $paymentLink = '';
        if($request->token){   
            $paymentLink = PaymentLink::where('payment_token', $request->token)
            ->where('status', '1')
            ->first();
        }

        if($paymentLink == null){
            $data = Session::all();
            $linkData = $this->create_payment_link($data);
            $paymentLink = $linkData['data'];
        } 

        $plan_data = json_decode($paymentLink->plan_data, true);

        Session([
            'total_price' => $plan_data['payble_price'],
            'promocode_amount' => $plan_data['promocode_amount'],
            'user_id' => $plan_data['user_id'],
            'payment_from' => $plan_data['payment_from'],
            'payment_token_id' => $plan_data['payment_token_id'],
            'plan_id' => $plan_data['plan_id'],
            'plan_name' => $plan_data['plan_name'],
            'payble_price' => $plan_data['payble_price'],
            'selectedPlan' => $plan_data,
        ]);

        $planData = Session::all();

        /* Get User Details */
        $userDetail = User::where('id', $paymentLink->user_id)->first();

        /* Get business Details */
        $businessDetail = BusinessDetail::where('user_id', $paymentLink->user_id)->first();

        // GST calculation
        $gst_price = $planData['payble_price'] - $planData['payble_price'] * (100 / (100 + 18));
        $cgst_price = $gst_price / 2;
        $sgst_price = $gst_price / 2;
        $withoutGst_price = $planData['payble_price'] - $gst_price;

        $payble_price = Session::get('payble_price');

        $planDetails = ['plan_id' => Session::get('plan_id'), 'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];

        $info = Plan::findorFail(Session::get('plan_id'));

        $getways = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->where('slug', '!=', 'cod')
            ->with('preview')
            ->get();

        $states = State::where('status', 1)->get();
        $currency = Option::where('key', 'currency_info')
            ->orderBy('id', 'desc')
            ->first();
        $currency = json_decode($currency->value);
        $currency_name = $currency->currency_name;

        $total = $payble_price;

        // $price=$currency_name.' '.$total.' Inclusive of GST.';
        $price = ' <span class="h6 font-weight-bold text-success">' . $currency_name . ' ' . $total . '</span> (Inclusive GST).';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $plan_Data = CommonSettingController::getBusinessPlanDetails();

        return view('partner.plan.payment', compact('planData', 'info', 'getways', 'price', 'notification_list', 'plan_Data', 'states', 'planDetails', 'info', 'businessDetail', 'userDetail', 'paymentLink', 'currency_name'));
    }

    public function make_charge(Request $request, $id)
    {
        $payble_price = $request['payble_price'];

        /* Get User Details */
        $user = User::find(Session::get('user_id'));

        Session([
            'payble_price' => $request['payble_price'],
        ]);

        $planDetails = ['plan_id' => Session::get('plan_id'), 'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];

        if ($request->gst_claim == null || $request->gst_claim == '') {
            $gst_claim = 0;
        } else {
            $gst_claim = $request->gst_claim;
        }
        if ($request->gst_business_name == null || $request->gst_business_name == '') {
            $gst_business_name = 0;
        } else {
            $gst_business_name = $request->gst_business_name;
        }
        if ($request->gst_address == null || $request->gst_address == '') {
            $gst_address = 0;
        } else {
            $gst_address = $request->gst_address;
        }
        if ($request->gst_state == null || $request->gst_state == '') {
            $gst_state = 0;
        } else {
            $gst_state = $request->gst_state;
        }
        if ($request->gst_city == null || $request->gst_city == '') {
            $gst_city = 0;
        } else {
            $gst_city = $request->gst_city;
        }
        if ($request->gst_pincode == null || $request->gst_pincode == '') {
            $gst_pincode = 0;
        } else {
            $gst_pincode = $request->gst_pincode;
        }
        if ($request->gst_number == null || $request->gst_number == '') {
            $gst_number = 0;
        } else {
            $gst_number = $request->gst_number;
        }

        $info = Plan::findorFail($id);

        $getway = Category::where('type', 'payment_gateway')
            ->where('featured', 1)
            ->where('slug', '!=', 'cod')
            ->findorFail($request->mode);

        $currency = Option::where('key', 'currency_info')
            ->orderBy('id', 'desc')
            ->first();
        $currency = json_decode($currency->value);
        $currency_name = $currency->currency_name;

        $total = $payble_price;

        $data['ref_id'] = $id;
        $data['getway_id'] = $request->mode;
        $data['amount'] = $total;
        $data['email'] = $user->email;
        $data['name'] = $user->name;
        $data['phone'] = $request->phone;
        $data['billName'] = Session::get('plan_name');
        $data['billing_type'] = Session::get('billing_type');
        $data['gst_claim'] = $gst_claim;
        $data['gst_business_name'] = $gst_business_name;
        $data['gst_address'] = $gst_address;
        $data['gst_state'] = $gst_state;
        $data['gst_city'] = $gst_city;
        $data['gst_pincode'] = $gst_pincode;
        $data['gst_number'] = $gst_number;
        $data['transaction_type'] = 'plan';
        $data['currency'] = strtoupper($currency_name);
        $data['payment_from'] = 'partner';

        Session::put('order_info', $data);

        // Update User Business Details
        BusinessDetail::whereUserId(Session::get('user_id'))->update([
            'address_line_1' => $request['gst_address'],
            'state' => $request['gst_state'],
            'city' => $request['gst_city'],
            'pincode' => $request['gst_pincode'],

            'billing_address_line_1' => $request['gst_address'],
            'billing_state' => $request['gst_state'],
            'billing_city' => $request['gst_city'],
            'billing_pincode' => $request['gst_pincode'],
        ]);

        if ($getway->slug == 'paypal') {
            return Paypal::make_payment($data);
        }
        if ($getway->slug == 'instamojo') {
            return Instamojo::make_payment($data);
        }
        if ($getway->slug == 'toyyibpay') {
            return Toyyibpay::make_payment($data);
        }
        if ($getway->slug == 'stripe') {
            $data['stripeToken'] = $request->stripeToken;
            return Stripe::make_payment($data);
        }
        if ($getway->slug == 'mollie') {
            return Mollie::make_payment($data);
        }
        if ($getway->slug == 'paystack') {
            return Paystack::make_payment($data);
        }
        if ($getway->slug == 'mercado') {
            return Mercado::make_payment($data);
        }

        if ($getway->slug == 'razorpay') {
            return redirect('/business/partner/payment-with/razorpay');
        }

        if ($getway->slug == 'cashfree') {
            return Cashfree::make_payment($data);
        }

        if ($getway->slug == 'payu') {
            return PayU::make_payment($data);
        }

        if ($getway->slug == 'paytm') {
            return Paytm::make_payment($data);
        }
    }

    public function success()
    {
        $session = Session::all();

        if (Session::has('payment_info')) {
            $data = Session::get('payment_info');

            /* Get Payment Details */
            $newPayment = BeforePayment::where('order_id', $data['payment_id'])
                ->orderBy('id', 'desc')
                ->first();
            if ($newPayment != null) {
                $before_payment_data = json_decode($newPayment->session_data, true);

                Session($before_payment_data);
            }

            $new_registration = 0;

            /* SalesRobo */
            $salesRobo = true;
            $salesRobo_msgs = 'no';
            $salesRobo_prod = 'no';
            $salesRobo_expi = 'no';
            $isExpire = false;
            $user_subscription = UserChannel::where('user_id', Session::get('user_id'))
                ->where('channel_id', 2)
                ->first();
            if (!empty($user_subscription)) {
                $isExpire = Carbon::now()->format('Ymd') > Carbon::parse($user_subscription->will_expire_on)->format('Ymd');
                if ($isExpire) {
                    $salesRobo_expi = 'yes';
                } else {
                    $salesRobo = false;
                }
            }

            /* Payment Link */
            $paymentLink = '';
            $selectedPlan = [];
            if (Session::get('selectedPlan')) {
                $selectedPlan = Session::get('selectedPlan');
                $paymentLink = PaymentLink::where('payment_token', $selectedPlan['payment_token_id'])
                    ->where('status', '1')
                    ->first();

                Session::forget('selectedPlan');
            }

            $plan = Plan::findorFail($session['plan_id']);
            $exp_days = $plan->days;

            /* get user */
            $user = User::find(Session::get('user_id'));

            DB::beginTransaction();
            try {
                $transaction = new Transaction();
                if ($paymentLink != '') {
                    $transaction->enterprise_id = $paymentLink->enterprise_id;
                }
                $transaction->invoice_no = $this->getInvoiceNo();
                $transaction->category_id = $data['getway_id'];
                $transaction->user_id = $user->id;
                $transaction->transaction_id = $data['payment_id'];
                $transaction->transaction_amount = $data['amount'];
                $transaction->total_amount = $data['amount'];
                $transaction->gst_claim = $data['gst_claim'];
                $transaction->gst_business_name = $data['gst_business_name'];
                $transaction->gst_number = $data['gst_number'];
                $transaction->gst_address = $data['gst_address'];
                $transaction->gst_state = $data['gst_state'];
                $transaction->gst_city = $data['gst_city'];
                $transaction->gst_pincode = $data['gst_pincode'];
                $transaction->transaction_type = $data['transaction_type'];

                //mark as paid
                $user = User::find($user->id);
                $user->is_paid = 1;
                $user->current_account_status = 'paid';
                $user->save();

                $convert = app('App\Http\Controllers\CommonLoginController')->convertFreeToPaid($user->id);

                if (isset($data['payment_status'])) {
                    $transaction->status = $data['payment_status'];
                } else {
                    $transaction->status = 1;
                }
                $transaction->save();

                //create message wallet
                $wallet = MessageWallet::where('user_id', $user->id)->first();
                $wallet->wallet_balance = $wallet->wallet_balance + $data['amount'];
                $wallet->save();

                Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

                $data['info'] = $user;
                $data['to_admin'] = env('MAIL_TO');
                $data['from_email'] = $user->email;

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            /* Mark as used */
            if ($paymentLink != '') {
                $paymentLink->is_used = 1;
                $paymentLink->save();
            }

            $amount = $data['amount'];
            $plan_name = $plan->name;

            $gst = $amount - $amount * (100 / (100 + 18));
            $priceWithoutGst = $amount - $gst;

            $gst_state = $data['gst_state'];

            $emailData = [
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'plan_name' => $plan_name,
                'plan_price' => $amount,
                'plan_gst' => $gst,
                'gst_state' => $gst_state,
                'plan_without_gst' => $priceWithoutGst,
                'plan_date' => $transaction->created_at,
            ];

            /* Welcome Notification */
            if ($new_registration == 1) {
                /* Message */
                $long_link = URL::to('/') . '/signin';
                $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "paid_registration");

                $payload = \App\Http\Controllers\WACloudApiController::mp_paidwelcome_alert('91' . $user->mobile, $user->name, $shortLinkData->original['code']);
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_paidwelcome_alert';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                /* Email */
                \App\Http\Controllers\CommonMailController::BusinessWelcomeMail($emailData);
            }

            $date = Carbon::parse($emailData['plan_date'])->format('d M, Y g:i A');
            $price = round($emailData['plan_without_gst'], 2);
            $gst = round($emailData['plan_gst'], 2);
            $total = round($emailData['plan_price'], 2);

            $long_link = URL::to('/') . '/business/subscriptions/view-invoice/'.$transaction->id;
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "paid_registration_subscription");

            $state_name = State::with('state')
                ->where('id', $gst_state)
                ->pluck('name')
                ->first();
            if ($state_name != 'Maharashtra') {
                $gst_name = 'IGST(18%)';
            } else {
                $gst_name = 'CGST + SGST(18%)';
            }
            $gst_data = $gst . '( ' . $gst_name . ' )';

            $payload = \App\Http\Controllers\WACloudApiController::mp_new_registration('91' . $user->mobile, $user->name, $total, $date, $total, $price, $gst_data, $total, $shortLinkData->original['code']);

            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_new_registration';
            $addmin_history->message_sent_to = $user->mobile;
            $addmin_history->save();
            /* Admin Message History end */

            \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);


            if($user->status == 0){
                $user = User::find($user->id);
                $user->status = 1;
                $user->save();

                $emailData['token'] = $user->pass_token;
                
                \App\Http\Controllers\CommonMailController::CreatePasswordMail($emailData);
            }

            /* Sending the data to the SalesRobo form.*/

            if ($salesRobo) {
                $sb_form_id = 6;
                $sb_form_data = [
                    'mauticform[f_name]' => $data['name'],
                    'mauticform[email]' => $data['email'],
                    'mauticform[mobile_number]' => $data['phone'],
                    'mauticform[address]' => $data['gst_address'],
                    'mauticform[state]' => $data['gst_state'],
                    'mauticform[city]' => $data['gst_city'],
                    'mauticform[pincode]' => $data['gst_pincode'],
                    'mauticform[gst_number]' => $data['gst_number'],
                    'mauticform[business_name]' => $data['gst_business_name'],
                    'mauticform[purchased_messages]' => $salesRobo_msgs,
                    'mauticform[purchased_product]' => $salesRobo_prod,
                    'mauticform[expired_subscription]' => $salesRobo_expi,
                    'mauticform[formId]' => $sb_form_id,
                    'mauticform[return]' => '',
                    'mauticform[formName]' => 'checkoutform',
                ];
                $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($sb_form_id, $sb_form_data);
            }
            /* END SalesRobo code */

            return redirect('business/partner/thank-you');
        }
        abort(404);
    }

    public function thankYou(Request $request)
    {
        if (!Session::has('payment_info')) {
            return redirect()->route('business.partner.index');
        }

        $user = Auth::User();
        $paymentData = Session::get('payment_info');
        $transaction = Transaction::where('transaction_id', $paymentData['payment_id'])->first();

        Session::forget('payment_info');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        return view('partner.plan.payment-success', compact('user', 'notification_list', 'planData', 'paymentData', 'transaction'));
    }

    public function getInvoiceNo()
    {
        $currentYr = Carbon::now()->format('y');
        $month = date('m');

        if ($month < 4) {
            $currentYr = $currentYr - 1;
        }

        $nextYr = $currentYr + 1;
        $slug = 'MP/' . $currentYr . '-' . $nextYr;

        $transaction = Transaction::where('invoice_no', '!=', '')
                                    ->where('invoice_no', 'like', '%'.$slug.'%')
                                    ->orderBy('id', 'desc')
                                    ->select('invoice_no')
                                    ->first();
        
        $sr_no = 1;
        if ($transaction != null) {
            $sr_no = substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1;
        }

        if(strlen($sr_no) == 1){
            $sr_no = '0'.$sr_no;
        }
        $invoice_no = $slug . '/' . $sr_no;

        return $invoice_no;
    }

    public function getCouponCode(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon)
            ->where('status', '1')
            ->first();
        if ($coupon != null) {
            return response()->json([
                'status' => true,
                'coupon' => $coupon,
                'message' => 'Coupon found.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'coupon' => '',
                'message' => 'Coupon not found.',
            ]);
        }
    }

    public function create_payment_link($data = null)
    {
        $token = $data['payment_token_id'];

        $domain = URL::to('/');

        $planData = json_encode([
            'total_price' => Session::get('payble_price'),
            'promocode_amount' => Session::get('promocode_amount'),
            'user_id' => Session::get('user_id'),
            'payment_from' => Session::get('payment_from'),
            'payment_token_id' => Session::get('payment_token_id'),
            'plan_id' => Session::get('plan_id'),
            'plan_name' => Session::get('plan_name'),
            'payble_price' => Session::get('payble_price'),
        ]);


        $userData = Session::get('user_data_' . $token);

        $paymentLink = PaymentLink::where('enterprise_id', Auth::id())
            ->where('payment_token', $token)
            ->where('status', '1')
            ->first();

        if ($paymentLink == null) {
            /* Disable old link */
            $oldPaymentLink = PaymentLink::where('enterprise_id', Auth::id())
                ->where('user_id', Session::get('user_id'))
                ->where('status', '1')
                ->where('is_used', 0)
                ->first();
            if ($oldPaymentLink != null) {
                $oldPaymentLink->status = '0';
                $oldPaymentLink->save();
            }

            $paymentLink = new PaymentLink();
            $paymentLink->enterprise_id = Auth::id();
            $paymentLink->user_id = $userData['old_user'];
            $paymentLink->name = $userData['business_name'];
            $paymentLink->email = $userData['business_email'];
            $paymentLink->mobile = $userData['business_mobile'];
            $paymentLink->plan_data = $planData;
            $paymentLink->payment_token = $token;
            $paymentLink->save();

            $is_paid = Transaction::where('user_id', $userData['old_user'])
                ->where('transaction_amount', '>', 0)
                ->first();
            // if($is_paid == null){
            //     $long_link = $domain.'/checkout?token='.$token;
            // }else{
            //     $long_link = $domain.'/business/subscriptions/plans?token='.$token;
            // }
            $long_link = $domain . '/checkout?token=' . $token;

            /*Create Shortlink*/
            $postData = [
                'opnlkey' => env('SHORTNER_API_KEY'),
                'secret' => env('SHORTNER_SECRET_KEY'),
                'long_link' => $long_link,
            ];

            $postData = [
                'opnlkey' => 'ol-PFAb3O0wGo2hHnQY',
                'secret' => 'mEFgF1niz9L6PGuOgaeCet3CgjJ6X4DrpT4T6U3v',
                'long_link' => $long_link,
            ];

            //API URL
            $url = 'https://opnl.in/api/v1/opnl-short-link';

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

            if ($output->status == true) {
                $paymentLink = PaymentLink::findorFail($paymentLink->id);
                $paymentLink->short_link = $output->link;
                $paymentLink->actual_link = $long_link;
                $paymentLink->save();
            } else {
                PaymentLink::destroy($paymentLink->id);
                return [
                    'status' => false,
                    'message' => 'Short link not created.',
                    'data' => null
                ];
            }

            return [
                'status' => true,
                'message' => 'Payment link saved.',
                'data' => $paymentLink
            ];
        }

        return [
            'status' => true,
            'message' => 'Payment link already exist.',
            'data' => $paymentLink
        ];
    }
}
