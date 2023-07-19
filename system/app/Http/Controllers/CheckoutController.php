<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\State;
use App\Models\Option;
use App\Models\Channel;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Recharge;
use App\Models\Userplan;
use App\Models\PlanGroup;
use App\Models\UserLogin;
use App\Models\DirectPost;
use App\Models\OfferReward;
use App\Models\PaymentLink;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\WhatsappApi;
use App\Models\AdminMessage;
use App\Models\ContactGroup;
use App\Models\MessageRoute;

use App\Models\Notification;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use App\Models\BeforePayment;
use App\Models\BusinessVcard;

use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\FreeTransaction;
use App\Models\WhatsappSession;
use App\Models\PlanGroupChannel;
use App\Models\UserNotification;
use App\Helper\Subscription\PayU;
use App\Helper\Subscription\Paytm;
use App\Models\SocialAccountCount;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\Instamojo;
use App\Models\MessageTemplateSchedule;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UuidTokenController;

class CheckoutController extends Controller
{
    //

    public function checkoutSubscription(Request $request)
    {
        // $enterprise_id = 0;
        $payable_amt = $paymentData = '';


        $plan = Plan::where('is_default', 1)->first();

        $planData = [
            'plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'payble_price' => 100,
        ];

        if (isset($request->token)) {
            $paymentData = PaymentLink::where('payment_token', $request->token)->first();
            

            if ($paymentData != null) {
                if($paymentData->is_used == 1){
                    abort(419);
                }

                $planData = json_decode($paymentData->plan_data, true);
                $payable_amt = $planData['payble_price'];
                
            }
        }
        // dd($plan);
        // GST calculation
        $gst_price = $planData['payble_price'] - $planData['payble_price'] * (100 / (100 + 18));
        $cgst_price = $gst_price / 2;
        $sgst_price = $gst_price / 2;
        $withoutGst_price = $planData['payble_price'] - $gst_price;

        // Other Information
        $info = PageController::socialAndSupport();
        $states = State::where('status', 1)->get();

        // Payment Gateway
        $getway = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->where('slug', '!=', 'cod')
            ->with('preview')
            ->first();

        return view('website.price.checkout', compact('info', 'getway', 'states', 'planData', 'gst_price', 'cgst_price', 'sgst_price', 'withoutGst_price', 'payable_amt', 'paymentData'));
    }

    public function checkUserPayment(Request $request)
    {
        if (!Auth::id() && $request->payment_link_token == '') {
            $user = User::where('mobile', $request->mobile)
                ->where('email', $request->email)
                ->where('status', 1)
                ->first();
            $mobile = User::where('mobile', $request->mobile)
                ->where('status', 1)
                ->first();
            $email = User::where('email', $request->email)
                ->where('email', '<>', null)
                ->where('status', 1)
                ->first();

            if ($user != null || $mobile != null || $email != null) {
                return response()->json(['status' => false, 'message' => 'User exists.']);
            }
        }

        return response()->json(['status' => true, 'message' => 'User does not exists.']);
    }

    public function checkoutMakePayment(Request $request, $id)
    {
        $getway = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->first();

        $currency = Option::where('key', 'currency_info')
            ->orderBy('id', 'desc')
            ->first();
        $currency = json_decode($currency->value);
        $currency_name = $currency->currency_name;

        $total = $request->payble_price;

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
        // if ($request->enterprise_id == null || $request->enterprise_id == '') {
        //     $enterprise_id = 0;
        // } else {
        //     $enterprise_id = $request->enterprise_id;
        // }

        $data['ref_id'] = $id;
        $data['getway_id'] = $request->mode;
        // $data['plan_group_id']=$request->plan_group_id;
        $data['amount'] = $total;
        $data['email'] = $request->email;
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['billName'] = $request->plan_name;
        // $data['billing_type']=$request->billing_type;
        $data['gst_claim'] = $gst_claim;
        $data['gst_business_name'] = $gst_business_name;
        $data['gst_address'] = $gst_address;
        $data['gst_state'] = $gst_state;
        $data['gst_city'] = $gst_city;
        $data['gst_pincode'] = $gst_pincode;
        $data['gst_number'] = $gst_number;
        $data['transaction_type'] = 'plan';
        $data['currency'] = strtoupper($currency_name);
        $data['previousURL'] = route('checkout');
        $data['payment_from'] = '';
        $data['old_user_id'] = $request->old_user_id ?? '';
        // $data['enterprise_id'] = $enterprise_id;

        // dd($data);
        Session::put('previous_url', 'checkout');

        Session::put('order_info', $data);

        // get token id start
        $session = Session::all();
        $previousUrl = $session['_previous']['url'];
        $tokenArr = explode('?token=', $previousUrl);

        if (isset($tokenArr[1])) {
            Session([
                'payment_token_id' => $tokenArr[1],
            ]);
        }

        // get token id end

        if ($getway->slug == 'razorpay') {
            return redirect('/payment-with/razorpay');
        }

        if ($getway->slug == 'cashfree') {
            return Cashfree::make_payment($data);
        }
    }

    public function failed()
    {
        $response = Request()->all();
        // dd($response);

        if (empty($response) || $response == null || $response == '') {
            return redirect()->route('pricing');
        }

        return view('subscription.failed-payment');
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

    public function success()
    {
        if (Session::has('payment_info')) {
            $data = Session::get('payment_info');

            //get payment info saved before payment because some payment gateway flush session before payment
            $newPayment = BeforePayment::where('order_id', $data['payment_id'])
                ->orderBy('id', 'desc')
                ->first();
            if ($newPayment != null) {
                $before_payment_data = json_decode($newPayment->session_data, true);

                Session($before_payment_data);
            }

            //purchase details
            $amount = $data['amount'];
            $plan_name = $data['billName'];

            $user = User::where('email', $data['email'])
                ->where('mobile', $data['phone'])
                ->first();
            $new_registration = 0;
            // dd($data);
            if ($user == null) {
                $new_registration = 1;
                $randomPass = $this->getRandomCode(8);
                $pass = Hash::make($randomPass);

                // Create social account
                // $access_token = $this->createSocialAccount($data, $pass);
                $access_token=NULL;
                $user = $this->saveUser($data, $pass, $access_token);

                if ($user) {
                    // Create Social Post Account
                    $socialPostParam = [
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => 12345678,
                    ];

                    $socialPostAuthToken = $this->socialPostAuth($socialPostParam);

                    if ($socialPostAuthToken) {
                        $userDetail = User::find($user->id);
                        $userDetail->social_post_api_token = $socialPostAuthToken;
                        $userDetail->save();
                    }

                    /* Register user with new WA API Start */
                    $api_data = [
                        'email' => $user->email,
                        'mobile' => $user->mobile,
                        'name' => $user->name,
                        'partner_key' => 'PRT-0IDR245P',
                        'partner_id' => 3,
                    ];
                    $wa_registration = app('App\Http\Controllers\WaApiController')->waRegistration($api_data);
                    /* Register user with new WA API End */

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
                }
            }

            /* Payment Link */
            $paymentLink = '';
            $enterprise_id = '';
            if (Session::get('payment_token_id')) {
                $token = Session::get('payment_token_id');
                $paymentLink = PaymentLink::where('payment_token', $token)
                    ->where('status', '1')
                    ->first();
                $enterprise_id = $paymentLink->enterprise_id; 

                Session::forget('payment_token_id');
            }

            //save transaction details
            DB::beginTransaction();
            try {

                $wallet = MessageWallet::where('user_id', $user->id)->first();
                $transaction = Transaction::where('transaction_id', $data['payment_id'])->first();
                $sendMail = false;
                if($transaction == null){
                    $transaction = new Transaction();
                    $transaction->invoice_no = $this->getInvoiceNo();
                    $transaction->category_id = $data['getway_id'];
                    $transaction->user_id = $user->id;
                    $transaction->enterprise_id = $enterprise_id;
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

                    if (isset($data['payment_status'])) {
                        $transaction->status = $data['payment_status'];
                    } else {
                        $transaction->status = 1;
                    }
                    $transaction->save();

                    $expiry_date = Carbon::now()->addYears(100)->format('Y-m-d');

                    if($wallet != null && $wallet->wallet_balance <= 0){
                        $convert = app('App\Http\Controllers\CommonLoginController')->convertFreeToPaid($user->id);
                    }else if($wallet == null){
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
                    }

                    $wallet->wallet_balance = $wallet->wallet_balance + $data['amount'];
                    $wallet->save();

                    //send mail
                    $sendMail = true;
                }

                Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

                $data['to_admin'] = env('MAIL_TO');
                $data['from_email'] = $user->email;

                /*Add login entry*/
                $loginInfo = UserLogin::where('user_id', $user->id)->first();
                if ($loginInfo == null) {
                    $loginInfo = new UserLogin();
                }
                $loginInfo->user_id = $user->id;
                $loginInfo->is_login = '1';
                $loginInfo->save();

                if (!Auth::id()) {
                    Auth::loginUsingId($user->id);
                    $userAuth = Auth::User();
                    Auth()->login($user, true);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            /* Mark as used */
            if ($paymentLink != '') {
                $paymentLink->is_used = 1;
                $paymentLink->save();
            }

            $gst_state = $data['gst_state'];
            $gst_price = $amount - $amount * (100 / (100 + 18));
            $cgst_price = $gst_price / 2;
            $sgst_price = $gst_price / 2;
            $withoutGst_price = $amount - $gst_price;

            $emailData = [
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'token' => $user->pass_token,
                'plan_name' => $plan_name,
                'plan_price' => $amount,
                'plan_gst' => $gst_price,
                'gst_state' => $gst_state,
                'plan_without_gst' => $withoutGst_price,
                'plan_date' => $transaction->created_at,
            ];

            /* Welcome Notification */
            if ($new_registration == 1 && $sendMail == true) {
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


            if($sendMail == true){
                $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

                /* Admin Message History start */
                $addmin_history = new AdminMessage();
                $addmin_history->template_name = 'mp_new_registration';
                $addmin_history->message_sent_to = $user->mobile;
                $addmin_history->save();
                /* Admin Message History end */

                \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);
            }

            /* Remove Session */
            Session()->forget(['plan_slug', 'total_price', 'payble_price', 'name', 'email', 'mobile']);

            if ($new_registration == 1 || $user->status == 0) {
                return redirect(url('generate-password/' . '?token=' . $user->pass_token));
            } else {
                if (Auth::user()->role_id == 3) {
                    return redirect('employee/thank-you');
                } else {
                    return redirect('/checkout-paid-register/thankyou');
                }
            }
        }
        abort(404);
    }

    public function sendToSalesRobo($data = [])
    {
        $sb_form_id = 8;
        $sb_form_data = [
            'mauticform[f_name]' => $data['name'],
            'mauticform[email]' => $data['email'],
            'mauticform[whatsapp_number]' => $data['phone'],
            'mauticform[address]' => $data['gst_address'],
            'mauticform[state]' => $data['gst_state'],
            'mauticform[city]' => $data['gst_city'],
            'mauticform[pincode]' => $data['gst_pincode'],
            'mauticform[gst_number]' => $data['gst_number'],
            'mauticform[business_name]' => $data['gst_business_name'],
            /* 'mauticform[purchased_messages]' => 'no',
            'mauticform[purchased_product]' => 'yes', */
            'mauticform[expired_subscription]' => 'no',
            'mauticform[paid_subscription]' => 'yes',
            'mauticform[formId]' => $sb_form_id,
            'mauticform[return]' => '',
            'mauticform[formName]' => 'checkoutform',
        ];
        $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($sb_form_id, $sb_form_data);
    }

    public function saveUser($data = [], $pass = '', $access_token = '')
    {
        $date = \Carbon\Carbon::now()->format('Ymd');
        $randomCode = $this->getRandomCode(180);

        //create user
        $user = new User();
        $user->name = ucwords($data['name']);
        $user->email = $data['email'];
        $user->mobile = $data['phone'];
        $user->password = $pass;
        $user->pass_token = $randomCode . $date;
        $user->wa_access_token = $access_token;
        $user->role_id = 2;
        $user->is_paid = 1;
        $user->status = 1;
        $user->save();

        // Get Default V-Card Page
        $vcard = BusinessVcard::where('default_card', 1)
            ->where('status', 1)
            ->first();
        $defaultVcard = 5;
        if ($vcard != null) {
            $defaultVcard = $vcard->slug;
        }

        /* Add entry for default contact groups */
        $contactData = [['user_id' => $user->id, 'name' => 'MESSAGING API Contacts', 'channel_id' => 4, 'is_default' => 1], ['user_id' => $user->id, 'name' => 'Instant Challenge Contacts', 'channel_id' => 2, 'is_default' => 1]];

        ContactGroup::insert($contactData);

        $contactGroup = ContactGroup::where('user_id', $user->id)
            ->pluck('id')
            ->toArray();

        $groups_id = implode(',', $contactGroup);
        // dd($groups_id);

        //save business details
        $details = new BusinessDetail();
        $details->user_id = $user->id;
        $details->uuid = $user->id . 'BUSI' . date('Ymd');
        $details->call_number = $data['phone'];
        // $details->whatsapp_number = '91'.$data['phone'];

        $details->address_line_1 = $data['gst_address'];
        $details->state = $data['gst_state'];
        $details->city = $data['gst_city'];
        $details->pincode = $data['gst_pincode'];

        $details->billing_address_line_1 = $data['gst_address'];
        $details->billing_state = $data['gst_state'];
        $details->billing_city = $data['gst_city'];
        $details->billing_pincode = $data['gst_pincode'];
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

        // $all_festival = DB::table('festivals')
        //     ->where('status', 1)
        //     ->get();
        $all_festival = DB::table('festivals')->where('status', 1)->where('festival_date', '>=', Carbon::now()->format('Y-m-d'))->get();

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

        //create message routes for user
        $channels = \App\Http\Controllers\Business\ChannelController::msg_channels();
        foreach ($channels as $channel) {
            $msgRoute = new MessageRoute();
            $msgRoute->user_id = $user->id;
            $msgRoute->channel_id = $channel->id;
            $msgRoute->save();
        }

        /*notification for user start*/
        $notifications = Notification::where('status', 1)->get();
        foreach ($notifications as $notification) {
            $user_notification = new UserNotification();
            $user_notification->notification_id = $notification->id;
            $user_notification->user_id = $user->id;
            $user_notification->save();
        }
        /*notification for user end*/

        $randomSender = UuidTokenController::eightCharacterUniqueToken(8);

        $wa_api = new WhatsappApi();
        $wa_api->user_id = $user->id;
        $wa_api->username = 'WAAPI' . $user->id;
        $wa_api->password = $this->randomPassword();
        $wa_api->sendername = $randomSender;
        $wa_api->status = '1';
        $wa_api->save();


        $expiry_date = Carbon::now()
            ->addYears(100)
            ->format('Y-m-d');


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


        $expiry_date = Carbon::now()->addYears(100)->format('Y-m-d');


        //create message wallet
        $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
        $options=Option::whereIn('key',$key)->pluck('value')->toArray();
        $wallet = new MessageWallet();
        $wallet->user_id = $user->id;
        $wallet->wallet_balance = 0;
        $wallet->minimum_balance = $options[0];
        $wallet->messaging_api_daily_limit = $options[1];
        $wallet->messaging_api_daily_free_limit = $options[2];
        $wallet->will_expire_on = $expiry_date;
        $wallet->save();

        // dd($data['phone']);

        return $user;
    }

    /*
    public function createSocialAccount($data = [], $pass)
    {
        //API call to get whatsapp access token
        $postData = [
            'fullname' => $data['name'],
            'email' => 'ol_' . rand(100000, 999999) . $data['email'],
            'password' => $pass,
            'confirm_password' => $pass,
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
