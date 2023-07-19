<?php

namespace App\Http\Controllers\Business;

use DB;
use Auth;

use Illuminate\Http\Request;
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
use App\Models\DirectPost;
use App\Models\Useroption;
use App\Models\PaymentLink;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\AdminMessage;

use App\Models\Categorymeta;
use App\Models\UserEmployee;
use App\Models\BeforePayment;

use App\Models\MessageWallet;

use App\Models\BusinessDetail;
use App\Helper\Subscription\PayU;

use App\Helper\Subscription\Paytm;

use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\Instamojo;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\Business\CommonSettingController;
use Yajra\DataTables\Facades\DataTables;

class PlanController extends Controller
{
    //

    public function __construct()
    {
        $params = \Request::all();
        if(isset($params['token'])){
            Session([
                'payment_url_from_partner' => \Request::getRequestUri() 
            ]);
        }

        $this->middleware('business');
    }

    public function plans()
    {
        return redirect('business/dashboard');
        
        /* Get user from session */
        $planDataArr = array();
        $paymentLink = '';

        if(request()->token){
            $paymentLink = PaymentLink::where('payment_token', request()->token)->where('status', '1')->first();
            if($paymentLink != null){

                if($paymentLink->is_used == 1){
                    abort(498);
                }
                
                $planDataArr = json_decode($paymentLink->plan_data, true);
                
                Session([
                    'selectedPlan' => $planDataArr,
                ]);
            }
        }
        
        $last_paid_transaction = Transaction::where('user_id',Auth::id())->where('transaction_amount', '>', 0)->orderBy('id','desc')->first();
        $last_paid_tran_date = Carbon::now()->format("Y-m-d");
        if($last_paid_transaction != null){
            $last_paid_tran_date = Carbon::parse($last_paid_transaction->created_at)->format("Y-m-d");
        }

        // dd($last_paid_tran_date);

        $getways=Category::where('type','payment_gateway')
        ->where('status',1)
        ->where('slug','!=','cod')
        ->with('preview')
        ->first();

        $renew_info = Option::where('key', 'renew_before_days')->first();


        $plans = Plan::where("status",1)->get();

        $purchasedChannelIds = UserChannel::where('user_id',Auth::id())->pluck('channel_id')->toArray();

        $paidChannels = Channel::with('user_channel')->whereIn('id', $purchasedChannelIds)->orderBy('price','asc')->get();
        $unpaidChannels = Channel::whereNotIn('id', $purchasedChannelIds)->get();

        $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $message_plan = MessageWallet::where('user_id', Auth::id())->first();
        $message_plans = Recharge::where("status",1)->orderBy('ordering', 'asc')->get();

        /* Plan Setting */
        $setting = Option::where('key','plan_setting')->first();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.plan.index',compact('notification_list','planData','getways','purchasedChannelIds','paidChannels','unpaidChannels','users','employee_price','message_plan','message_plans','plans', 'renew_info','last_paid_tran_date', 'setting', 'paymentLink', 'planDataArr'));
    }

    public function proceedToPay(Request $request)
    {
        $planData = $request->except('_token');
        Session($planData);

        $url = url('business/make-payment/'.$planData['plan_id']);

        return response()->json(["status" => true, "message" => "Data stored in session", "url" => $url]); 
    }

    public function make_payment($id)
    {
        // dd(Session::all());
        if(Session::has('success')){
            Session::flash('success', 'Thank You For Subscribe After Review The Order You Will Get A Notification Mail From Admin');
            return redirect('business/plan'); 
        }

        if(!Session::get('payble_price')){
            return redirect('/pricing');
        }
        
        $payble_price = Session::get('payble_price');

        $planDetails = ['plan_id' => Session::get('plan_id'),'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];


        $info=Plan::findorFail(Session::get('plan_id'));
        
        $getways=Category::where('type','payment_gateway')
        ->where('status',1)
        ->where('slug','!=','cod')
        ->with('preview')
        ->get();

        $states = State::where('status', 1)->get();
        $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
        $currency=json_decode($currency->value);
        $currency_name=$currency->currency_name;

        $total=$payble_price;

        // $price=$currency_name.' '.$total.' Inclusive of GST.';
        $price=' <span class="h6 font-weight-bold text-success">'.$currency_name.' '.$total.'</span> (Inclusive GST).';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $businessDetail = BusinessDetail::whereUserId(Auth::id())->first();
        // dd($businessDetail);

        return view('business.plan.payment',compact('getways','price','notification_list','planData', 'states','planDetails','info', 'businessDetail'));
    }

    public function make_charge(Request $request,$id)
    {
        #dd(Session::all());
        $payble_price = Session::get('payble_price');

        $planDetails = ['plan_id' => Session::get('plan_id'),'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];

        if($request->gst_claim == null || $request->gst_claim == ''){
            $gst_claim = 0;
        }else{ $gst_claim = $request->gst_claim; }
        if($request->gst_business_name == null || $request->gst_business_name == ''){
            $gst_business_name = 0;
        }else{ $gst_business_name = $request->gst_business_name; }
        if($request->gst_address == null || $request->gst_address == ''){
            $gst_address = 0;
        }else{ $gst_address = $request->gst_address; }
        if($request->gst_state == null || $request->gst_state == ''){
            $gst_state = 0;
        }else{ $gst_state = $request->gst_state; }
        if($request->gst_city == null || $request->gst_city == ''){
            $gst_city = 0;
        }else{ $gst_city = $request->gst_city; }
        if($request->gst_pincode == null || $request->gst_pincode == ''){
            $gst_pincode = 0;
        }else{ $gst_pincode = $request->gst_pincode; }
        if($request->gst_number == null || $request->gst_number == ''){
            $gst_number = 0;
        }else{ $gst_number = $request->gst_number; }

        $info=Plan::findorFail($id);

        $getway=Category::where('type','payment_gateway')->where('featured',1)->where('slug','!=','cod')->findorFail($request->mode);

        $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
        $currency=json_decode($currency->value);
        $currency_name=$currency->currency_name;
        
        $total=$payble_price;

        $data['ref_id']=$id;
        $data['getway_id']=$request->mode;
        $data['amount']=$total;
        $data['email']=Auth::user()->email;
        $data['name']=Auth::user()->name;
        $data['phone']=$request->phone;
        $data['billName']=Session::get('plan_name');
        $data['billing_type']=Session::get('billing_type');
        $data['gst_claim']=$gst_claim;
        $data['gst_business_name']=$gst_business_name;
        $data['gst_address']=$gst_address;
        $data['gst_state']=$gst_state;
        $data['gst_city']=$gst_city;
        $data['gst_pincode']=$gst_pincode;
        $data['gst_number']=$gst_number;
        $data['transaction_type'] = 'plan';
        $data['currency']=strtoupper($currency_name);
        $data['payment_from']= 'business';

        Session::put('order_info',$data);

        // Update User Business Details
        BusinessDetail::whereUserId(Auth::id())->update([
            'billing_address_line_1'=>$request['gst_address'],
            'billing_state'=>$request['gst_state'],
            'billing_city'=>$request['gst_city'],
            'billing_pincode'=>$request['gst_pincode'],
        ]);

        if ($getway->slug=='paypal') {
           return Paypal::make_payment($data);
        }
        if ($getway->slug=='instamojo') {
           return Instamojo::make_payment($data);
        }
        if ($getway->slug=='toyyibpay') {
           return Toyyibpay::make_payment($data);
        }
        if ($getway->slug=='stripe') {
            $data['stripeToken']=$request->stripeToken;
           return Stripe::make_payment($data);
        }
        if ($getway->slug=='mollie') {
            return Mollie::make_payment($data);
        }
        if ($getway->slug=='paystack') {            
            return Paystack::make_payment($data);
        }
        if ($getway->slug=='mercado') {            
            return Mercado::make_payment($data);
        }
        
        if ($getway->slug=='razorpay') {
           return redirect('/business/payment-with/razorpay');
        }
        
        if ($getway->slug=='cashfree') {
           return Cashfree::make_payment($data);
        }
        
        if ($getway->slug=='payu') {
           return PayU::make_payment($data);
        }
        
        if ($getway->slug=='paytm') {
           return Paytm::make_payment($data);
        }
    }

    public function success()
    {

        $user = Auth::user();
        if (Session::has('payment_info')) {

            /* SalesRobo */
            $salesRobo = true;
            $salesRobo_msgs = 'no';
            $salesRobo_prod = 'no';
            $salesRobo_expi = 'no';
            $isExpire = false;
            $user_subscription = UserChannel::where('user_id', Auth::id())->where('channel_id', 2)->first();
            if(!empty($user_subscription)){
                $isExpire = Carbon::now()->format('Ymd') > Carbon::parse($user_subscription->will_expire_on)->format('Ymd');
                if($isExpire){
                    $salesRobo_expi = 'yes';
                }else{
                    $salesRobo = false;
                }
            }
            
            /* Payment Link */
            $paymentLink = '';
            $selectedPlan = array();
            if(Session::get('selectedPlan')){
                $selectedPlan = Session::get('selectedPlan');
                $paymentLink = PaymentLink::where('payment_token', $selectedPlan['payment_token_id'])->where('status', '1')->first();
                
                Session::forget('selectedPlan');
            }
            

            $data = Session::get('payment_info');
            $plan=Plan::findorFail($data['ref_id']);
            $exp_days =  $plan->days;
            
            $newPayment = BeforePayment::where('order_id',$data['payment_id'])->orderBy('id','desc')->first();
            if($newPayment != null){
                $before_payment_data = json_decode($newPayment->session_data, true);

                Session($before_payment_data);
            }

            DB::beginTransaction();
            try {

                $transaction = new Transaction;
                if($paymentLink != ''){
                    $transaction->enterprise_id = $paymentLink->enterprise_id;
                }
                $transaction->invoice_no = $this->getInvoiceNo();
                $transaction->category_id = $data['getway_id'];
                $transaction->user_id = $user->id;
                $transaction->transaction_id = $data['payment_id'];
                $transaction->transaction_amount= $data['amount'];
                $transaction->total_amount = Session::get('total_price');
                $transaction->gst_claim = $data['gst_claim'];
                $transaction->gst_business_name = $data['gst_business_name'];
                $transaction->gst_number = $data['gst_number'];
                $transaction->gst_address = $data['gst_address'];
                $transaction->gst_state = $data['gst_state'];
                $transaction->gst_city = $data['gst_city'];
                $transaction->gst_pincode = $data['gst_pincode'];
                $transaction->transaction_type = $data['transaction_type'];

                if (isset($data['payment_status'])) {
                    $transaction->status = $data['payment_status'];
                }else{
                    $transaction->status = 1;
                }
                $transaction->save();

                $today = \Carbon\Carbon::now()->format("Y-m-d");
                if($plan->slug == 'monthly'){
                    $invoice_date = Carbon::now()->addMonth(1)->format('Y-m-d');
                }elseif($plan->slug == 'yearly'){
                    $invoice_date = Carbon::now()->addYear(1)->format('Y-m-d');
                }

                /* Message Plan */
                if(Session::get('message_plan_id') != ''){
                    $message_plan = Recharge::findOrFail(Session::get('message_plan_id'));
                    $message_expiry = Carbon::now()->addYear(1)->format('Y-m-d');
                    
                    $wallet = MessageWallet::where('user_id', Auth::id())->first();
                    if($wallet == null){
                        $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
                        $options=Option::whereIn('key',$key)->pluck('value')->toArray();
                        $wallet = new MessageWallet;
                        $wallet->user_id = Auth::id();
                        $wallet->minimum_balance = $options[0];
                        $wallet->messaging_api_daily_limit = $options[1];
                        $wallet->messaging_api_daily_free_limit = $options[2];
                    }
                    $wallet->total_messages = $wallet->total_messages + $message_plan->messages;
                    $wallet->will_expire_on = $message_expiry;
                    $wallet->save();

                    /* SalesRobo */
                    $salesRobo_msgs = 'yes';
                }else{
                    $wallet = MessageWallet::where('user_id', Auth::id())->first();
                    if($wallet != null && $invoice_date > $wallet->will_expire_on){
                        $wallet->will_expire_on = $invoice_date;
                        $wallet->save();
                    } 
                }

                /* Buy Users */
                $paidEmployeeIds = $freeEmployeeIds = array();
                if(Session::get('buy_users') != ''){
                    for($i = 0; $i < Session::get('buy_users'); $i++){
                        $paid_employee = new UserEmployee;
                        $paid_employee->user_id = $user->id;
                        $paid_employee->is_free = 0;
                        $paid_employee->will_expire_on = $invoice_date;
                        $paid_employee->save();

                        $paidEmployeeIds[] = $paid_employee->id;
                    }
                }

                /* Renew Users */
                if(Session::get('renew_users') != ''){
                    $userIds = explode(',', Session::get('renew_users'));

                    foreach($userIds as $userId){
                        $renew_paid_employee = UserEmployee::findOrFail($userId);

                        $prev_renew_date = Carbon::parse($renew_paid_employee->will_expire_on)->format('Y-m-d');
                        $todays_date = Carbon::now()->format('Y-m-d');
                        if(Carbon::now()->format('Y-m-d') > $prev_renew_date){
                            if($plan->slug == 'monthly'){
                                $paid_emply_renew_date = Carbon::now()->addMonth(1)->format('Y-m-d');
                            }elseif($plan->slug == 'yearly'){
                                $paid_emply_renew_date = Carbon::now()->addYear(1)->format('Y-m-d');
                            }
                        }else{
                            if($plan->slug == 'monthly'){
                                $paid_paid_emply_renew_date = Carbon::parse($renew_paid_employee->will_expire_on)->addMonth(1)->format('Y-m-d');
                            }elseif($plan->slug == 'yearly'){
                                $paid_emply_renew_date = Carbon::parse($renew_paid_employee->will_expire_on)->addYear(1)->format('Y-m-d');
                            }
                        }

                        $renew_paid_employee->will_expire_on = $paid_emply_renew_date;
                        $renew_paid_employee->save();

                        $paidEmployeeIds[] = $renew_paid_employee->id;
                    }
                }

                /* Buy Channel */
                $channelIds = array();
                if(Session::get('buy_channels') != ''){
                    $buyChannelIds = explode(',', Session::get('buy_channels'));

                    foreach($buyChannelIds as $buyChannelId){
                        $channel = Channel::findOrFail($buyChannelId);
                        
                        if($channel->free_employee > 0){
                            for($i = 0; $i < $channel->free_employee; $i++){
                                $free_employee = new UserEmployee;
                                $free_employee->user_id = $user->id;
                                $free_employee->is_free = 1;
                                $free_employee->free_with_channel = $channel->id;
                                $free_employee->will_expire_on = $invoice_date;
                                
                                $free_employee->save();
        
                                $freeEmployeeIds[] = $free_employee->id;
                            }
                        }

                        $buy_channel = new UserChannel;
                        $buy_channel->user_id = $user->id;
                        $buy_channel->channel_id = $buyChannelId;
                        if($channel->price <= 0){
                            Carbon::now()->addYears(100)->format('Y-m-d');
                        }else{
                            $buy_channel->will_expire_on = $invoice_date;
                        }
                        $buy_channel->save();

                        $channelIds[] = $buy_channel->id;
                    }

                    /* First time purchase */
                    $wallet = MessageWallet::where('user_id', Auth::id())->first();
                    if($wallet == null){
                        $wallet = new MessageWallet;
                        $wallet->total_messages = $plan->months * 1000;
                    }else{
                        $wallet->total_messages = $wallet->total_messages + ($plan->months * 1000);
                    }
                    $wallet->will_expire_on = $invoice_date;
                    $wallet->save();

                    /* SalesRobo */
                    $salesRobo_prod = 'yes';

                }

                /* Renew Channels */
                if(Session::get('renew_channels') != ''){
                    $renewChannelIds = explode(',', Session::get('renew_channels'));

                    foreach($renewChannelIds as $renewChannelId){
                        $freeEmployees = UserEmployee::where('user_id', Auth::id())->where('free_with_channel', $renewChannelId)->get();

                        if(!empty($freeEmployees)){
                            foreach($freeEmployees as $emply){
                                
                                $free_employee = UserEmployee::findOrFail($emply->id);

                                $prev_date = Carbon::parse($free_employee->will_expire_on)->format('Y-m-d');

                                if(Carbon::now()->format('Y-m-d') > $prev_date){
                                    if($plan->slug == 'monthly'){
                                        $emply_renew_date = Carbon::now()->addMonth(1)->format('Y-m-d');
                                    }elseif($plan->slug == 'yearly'){
                                        $emply_renew_date = Carbon::now()->addYear(1)->format('Y-m-d');
                                    }
                                }else{
                                    if($plan->slug == 'monthly'){
                                        $emply_renew_date = Carbon::parse($free_employee->will_expire_on)->addMonth(1)->format('Y-m-d');
                                    }elseif($plan->slug == 'yearly'){
                                        $emply_renew_date = Carbon::parse($free_employee->will_expire_on)->addYear(1)->format('Y-m-d');
                                    }
                                }
                                

                                $free_employee->will_expire_on = $emply_renew_date;
                                $free_employee->save();
        
                                $freeEmployeeIds[] = $free_employee->id;
                            }
                        }

                        $renew_channel = UserChannel::where('user_id', Auth::id())->where('channel_id',$renewChannelId)->first();

                        $prev_renew_date = Carbon::parse($renew_channel->will_expire_on)->format('Y-m-d');

                        if(Carbon::now()->format('Y-m-d') > $prev_renew_date){
                            if($plan->slug == 'monthly'){
                                $channel_renew_date = Carbon::now()->addMonth(1)->format('Y-m-d');
                            }elseif($plan->slug == 'yearly'){
                                $channel_renew_date = Carbon::now()->addYear(1)->format('Y-m-d');
                            }
                        }else{
                            if($plan->slug == 'monthly'){
                                $channel_renew_date = Carbon::parse($renew_channel->will_expire_on)->addMonth(1)->format('Y-m-d');
                            }elseif($plan->slug == 'yearly'){
                                $channel_renew_date = Carbon::parse($renew_channel->will_expire_on)->addYear(1)->format('Y-m-d');
                            }
                        }

                        $renew_channel->user_id = $user->id;
                        $renew_channel->channel_id = $renewChannelId;
                        $renew_channel->will_expire_on = $channel_renew_date;
                        $renew_channel->save();

                        $channelIds[] = $renew_channel->id;
                    }

                    /* SalesRobo */
                    if($isExpire){
                        $salesRobo_expi = 'no';
                    }
                    $salesRobo_prod = 'yes';
                }

                $channelArr = $paidEmplooyeeArr = $freeEmplooyeeArr = '';
                if(!empty($channelIds)){
                    $channelArr = implode(',', $channelIds);
                }

                if(!empty($paidEmployeeIds)){
                    $paidEmplooyeeArr = implode(',', $paidEmployeeIds);
                }

                if(!empty($freeEmployeeIds)){
                    $freeEmplooyeeArr = implode(',', $freeEmployeeIds);
                }

                /* Userplan */
                $userplan = new Userplan;
                $userplan->user_id = $user->id;
                $userplan->plan_id = $plan->id;
                $userplan->transaction_id = $transaction->id;
                $userplan->will_expire_on = $invoice_date;
                $userplan->channel_ids = $channelArr;
                $userplan->free_employee_ids = $freeEmplooyeeArr;
                $userplan->paid_employee_ids = $paidEmplooyeeArr;
                $userplan->recharge_plan_id = Session::get('message_plan_id');
                $userplan->save();

                Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

                $data['info'] = $user;
                $data['to_admin'] = env('MAIL_TO');
                $data['from_email'] = Auth::user()->email;
            
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            /* Mark as used */
            if($paymentLink != ''){
                $paymentLink->is_used = 1;
                $paymentLink->save();
            }

            $amount = $data['amount'];
            $plan_name = $plan->name;

            $gst = $amount - ($amount * (100 / (100 + 18 ) ) );
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
                'plan_date' => $userplan->created_at
            ];

            // dd($emailData);

            $date = Carbon::parse($emailData['plan_date'])->format('d M, Y g:i A');
            $price = round($emailData['plan_without_gst'],2);
            $gst = round($emailData['plan_gst'],2);
            $total = round($emailData['plan_price'],2);

            $long_link = URL::to('/').'/business/subscriptions/history';
            $shortLinkData = ShortLinkController::callShortLinkApi($long_link, $user->id ?? 0, "subscription");


            $state_name = State::with('state')->where('id', $gst_state)->pluck('name')->first();
            if ($state_name != 'Maharashtra') {
                $gst_name = "IGST(18%)";
            }else {
                $gst_name = "CGST + SGST(18%)";
            }
            $gst_data = $gst.'( '.$gst_name.' )';

            $payload = \App\Http\Controllers\WACloudApiController::mp_paidwelcome_alert('91'.$user->mobile, $user->name, $plan_name, $date, $plan_name, $price, $gst_data, $total, $shortLinkData->original["code"]);
            $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

            /* Admin Message History start */
            $addmin_history = new AdminMessage();
            $addmin_history->template_name = 'mp_paidwelcome_alert';
            $addmin_history->message_sent_to = $user->mobile;
            $addmin_history->save();
            /* Admin Message History end */

            \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);


            /*
            * Sending the data to the SalesRobo form.
            */
            
            if(!empty($user_subscription)){
                /* user purchaseproduct  */
            }

            if ($salesRobo) {
                $sb_form_id = 1;
                $sb_form_data = array(
                    'mauticform[f_name]' => $data['name'],
                    'mauticform[email_id]' => $data['email'],
                    'mauticform[whatsapp_number]' => $data['phone'],
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
                    'mauticform[formName]' => 'checkoutform'
                );
                $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($sb_form_id, $sb_form_data);
            }
            /* END SalesRobo code */

            return redirect('business/thank-you');
        }
        abort(404);
    }

    public function thankYou(Request $request)
    {
        // dd(Session::all());
        if(!Session::has('payment_info')){
            return redirect()->route('business.planHistory');
        }

        $user = Auth::User();
        $paymentData = Session::get('payment_info');
        $transaction = Transaction::where('transaction_id', $paymentData['payment_id'])->first();
        
        Session::forget('payment_info');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        
        return view('business.payment-success', compact('user','notification_list','planData', 'paymentData', 'transaction'));
    }

    public function planHistory()
    {

        // $plans= Transaction::where('user_id',Auth::id())->where('transaction_amount', '>', 0)->where('transaction_type','plan')->orderBy('id','desc')->latest()->paginate(10);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.plan.history',compact('notification_list','planData'));
    }

    public function getStatement(Request $request)
    {
        if ($request->ajax()) {
            $plans= Transaction::where('user_id',Auth::id())->where('transaction_amount', '>', 0)->where('transaction_type','plan')->orderBy('id','desc')->latest()->get();

            return Datatables::of($plans)
                ->addIndexColumn()
                ->addColumn('payment id', function ($q) {
                    return '<a href="'.route('business.viewHistory',$q->id).'">'. $q->transaction_id.'</a>';
                })
                ->addColumn('status', function ($q) {
                    return '<span class="badge badge-success">Paid</span>';
                })
                ->addColumn('amount', function ($q) {
                    return '&#8377;'.$q->transaction_amount;
                })
                ->addColumn('transaction date', function ($q) {
                    return Carbon::parse($q->created_at)->format('j F, Y');
                })
                ->addColumn('action', function ($q) {
                    return '<a href="'.route('business.viewHistory',$q->id).'" class="btn btn-warning">Invoice</a>';
                })
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function viewHistory($id)
    {
        
        $transaction= Transaction::with('method','userplans')->where('id',$id)->orderBy('id','desc')->first();

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);

                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();
        
        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();
        // dd($plan_period);

        if(!empty($transaction) && $transaction->user_id == Auth::id()){
            //notification_list
            $notification_list = CommonSettingController::getNotification();
            $planData = CommonSettingController::getBusinessPlanDetails();
            
            
            return view('business.plan.view-history',compact('transaction','notification_list','planData','plan_period', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'));
        }else{
            abort(404);
        }
    }

    public function downloadHistory($id)
    {
        
        $transaction= Transaction::with('method','userplans','state')->where('id',$id)->orderBy('id','desc')->first();

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);
                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();
        // $transaction->userplans_channel->emp = UserEmployee::whereIsFree(0)->whereUserId(Auth::id())->count();

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();

        if(!empty($transaction) && $transaction->user_id == Auth::id()){
            $business = BusinessDetail::with('stateDetail')->where('user_id', Auth::id())->orderBy('id', 'desc')->first();
            $user = User::findorFail(Auth::id());
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);

            $pdf = \PDF::loadView('business.plan.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            #return $pdf->stream('invoice.pdf');
            return $pdf->download('invoice.pdf');
        }else{
            abort(404);
        }
    }

    public function viewInvoice($id)
    {
        
        $transaction= Transaction::with('method','userplans','state')->where('id',$id)->orderBy('id','desc')->first();

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);
                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();
        // $transaction->userplans_channel->emp = UserEmployee::whereIsFree(0)->whereUserId(Auth::id())->count();

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();

        if(!empty($transaction) && $transaction->user_id == Auth::id()){

            $business = BusinessDetail::with('stateDetail')->where('user_id', Auth::id())->orderBy('id', 'desc')->first();
            $user = User::findorFail(Auth::id());
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);
            $pdf = \PDF::loadView('business.plan.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            return $pdf->stream('invoice.pdf');
        }else{
            // dd('Not exist!');
            abort(404);
        }
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
        $coupon = Coupon::where('code',$request->coupon)->where('status','1')->first();
        if($coupon != null){
            return response()->json([
                "status" => true,
                "coupon" => $coupon,
                "message" => "Coupon found." 
            ]);
        }else{
            return response()->json([
                "status" => false,
                "coupon" => '',
                "message" => "Coupon not found." 
            ]);
        }
    }




}
