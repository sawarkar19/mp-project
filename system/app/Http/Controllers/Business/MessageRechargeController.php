<?php
namespace App\Http\Controllers\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Business\CommonSettingController;
use App\Models\Userrechargemeta;
use App\Models\UserRecharge;
use App\Models\Userplan;
use App\Models\Recharge;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\State;
use App\Models\Option;
use App\Models\MessageWallet;
use Session;
use Auth;
use DB;


use App\Helper\Subscription\Cashfree;

class MessageRechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('business');
    }

    public function msgRecharge(Request $request)
    {
        $userrechargemeta = UserRecharge::where('user_id',Auth::id())->select('recharge_id','status','will_expire_on')->orderBy('id','desc')->first();
        $todays_date = date('Y-m-d');
        
       
        Session(['recharge_id' => '']);
        
        
        $posts=Recharge::where('status','1')->where('is_default',0)->get();
        // $posts=Recharge::get();
        // dd($posts);
        $notification_list = CommonSettingController::getNotification();
        $rechargeData = CommonSettingController::getRechargeDetails();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.recharges.index',compact('posts','notification_list','rechargeData','planData'));
        
    }

    public function checkRechargeSubscription(Request $request)
    {

        $url = route('business.recharge_payment', $request->recharge_id);
        return response()->json([
            'status' => true,
            'url' => $url,
            'message' => 'Can subscribe to new recharge.'
        ]);
        
    }

    public function make_payment($id)
    {

        // dd($id);
        if(Session::has('success')){
            Session::flash('success', 'Thank You For Subscribe After Review The Order You Will Get A Notification Mail From Admin');
            return redirect('business/message-recharges'); 
        }

        $info=Recharge::where('status','1')->where('is_default',0)->where('price','>',0)->findorFail($id);
        $getways=Category::where('type','payment_gateway')
        ->where('status',1)
        ->where('slug','!=','cod')
        ->with('preview')
        ->get();
        $states = State::where('status', 1)->get();
        $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
        $currency=json_decode($currency->value);
        $currency_name=$currency->currency_name;

        $total=$info->price;

        $price=' <span class="h6 font-weight-bold text-success">'.$currency_name.' '.$total.'</span> (Inclusive of GST).';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $rechargeDetails = Recharge::where('id', $id)->first();
        // dd($rechargeDetails);

        return view('business.recharges.payment',compact('info','getways','price','notification_list','planData', 'states','rechargeDetails'));
    }

    public function make_recharge_charge(Request $request,$id)
    { 
        // dd($request);

        if($request->gst_claim == null || $request->gst_claim == ''){
            $gst_claim = 0;
        }else{ $gst_claim = $request->gst_claim; }
        if($request->gst_business_name == null || $request->gst_business_name == ''){
            $gst_business_name = 0;
        }else{ $gst_business_name = $request->gst_business_name; }
        if($request->gst_state == null || $request->gst_state == ''){
            $gst_state = 0;
        }else{ $gst_state = $request->gst_state; }
        if($request->gst_number == null || $request->gst_number == ''){
            $gst_number = 0;
        }else{ $gst_number = $request->gst_number; }
        if($request->gst_address == null || $request->gst_address == ''){
            $gst_address = 0;
        }else{ $gst_address = $request->gst_address; }
        if($request->gst_city == null || $request->gst_city == ''){
            $gst_city = 0;
        }else{ $gst_city = $request->gst_city; }
        if($request->gst_pincode == null || $request->gst_pincode == ''){
            $gst_pincode = 0;
        }else{ $gst_pincode = $request->gst_pincode; }

        $info=Recharge::where('status','1')->where('is_default',0)->where('price','>',0)->findorFail($id);
        $getway=Category::where('type','payment_gateway')->where('featured',1)->where('slug','!=','cod')->findorFail($request->mode);

        $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
        $currency=json_decode($currency->value);
        $currency_name=$currency->currency_name;
        
        $total=$info->price;

        $data['ref_id']=$id;
        $data['getway_id']=$request->mode;
        $data['amount']=$total;
        $data['email']=Auth::user()->email;
        $data['name']=Auth::user()->name;
        $data['phone']=$request->phone;
        $data['billName']=$info->name;
        $data['billing_type'] = "recharge";
        $data['gst_claim']=$gst_claim;
        $data['gst_business_name']=$gst_business_name;
        $data['gst_state']=$gst_state;
        $data['gst_number']=$gst_number;
        $data['gst_address']=$gst_address;
        $data['gst_city']=$gst_city;
        $data['gst_pincode']=$gst_pincode;
        $data['transaction_type'] = 'recharge'; 
        $data['currency']=strtoupper($currency_name);
        $data['previousURL'] = route('business.messageRecharge');

        // dd($data);

        Session::put('order_info',$data);
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
    }

    public function success()
    {
        // dd('hey');

        if (Session::has('payment_info')) {
            $data = Session::get('payment_info');

            $recharge=Recharge::findorFail($data['ref_id']);

            DB::beginTransaction();
            try {
                $transection=new Transaction;
                $transection->category_id = $data['getway_id'];
                $transection->user_id = Auth::user()->id;
                $transection->transaction_id = $data['payment_id'];
                if (isset($data['payment_status'])) {
                    $transection->status = $data['payment_status'];
                }else{
                    $transection->status = 1;
                }
                $transection->gst_claim = $data['gst_claim'];
                $transection->gst_business_name = $data['gst_business_name'];
                $transection->gst_number = $data['gst_number'];
                $transection->gst_address = $data['gst_address'];
                $transection->gst_state = $data['gst_state'];
                $transection->gst_city = $data['gst_city'];
                $transection->gst_pincode = $data['gst_pincode'];
                $transection->transaction_type = $data['transaction_type'];
                $transection->save();

                //old subscription
                $userrechargemeta = UserRecharge::where('user_id',Auth::id())->where('status','1')->select('id','recharge_id','status','will_expire_on')->orderBy('id','desc')->first();

                $exp_days =  $recharge->days;
                if($userrechargemeta != null && $data['ref_id'] == $userrechargemeta->recharge_id){
                    $expiry_date = date('Y-m-d',strtotime($userrechargemeta->will_expire_on . " + 365 day"));
                }else{
                    $expiry_date = \Carbon\Carbon::now()->addDays(300)->format('Y-m-d');
                }


                $max_order=UserRecharge::max('id');
                $order_prefix=Option::where('key','order_prefix')->orderBy('id', 'desc')->first();

                $recharge_no = $order_prefix->value.$max_order;


                //set others to 0
                UserRecharge::where('user_id',Auth::user()->id)->update(['status' => '0']);

                $user=new UserRecharge;
                $user->recharge_no=$recharge_no;
                $user->amount=$data['amount'];
                $user->user_id =Auth::id();
                $user->recharge_id = $recharge->id;
                $user->transaction_id = $transection->id;
                $user->will_expire_on=$expiry_date;
                
                if($transection->status == 1){
                    $user->status=1;
                }                 
                $user->save();
               
                if($transection->status == 1){
                    $msg = 0;
                    $walletMeta=MessageWallet::where('user_id',Auth::id())->orderBy('id', 'desc')->first();
                    if(empty($walletMeta)){
                        $key=array('free_whatsapp_limit','messaging_api_limit','minimum_balance');
                        $options=Option::whereIn('key',$key)->pluck('value')->toArray();
                        $walletMeta=new MessageWallet;
                        $walletMeta->user_id=Auth::id();
                        $walletMeta->minimum_balance = $options[0];
                        $walletMeta->messaging_api_daily_limit = $options[1];
                        $walletMeta->messaging_api_daily_free_limit = $options[2];
                    }
                    $msgRecharge = Recharge::where('id', $recharge->id)->first();
                    $msg = $walletMeta->recharge_wallet + $msgRecharge->messages;
                    $walletMeta->recharge_wallet=$msg;
                    $walletMeta->save();
                }
                
                Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

                $data['info']=$user;
                $data['to_admin']=env('MAIL_TO');
                $data['from_email']=Auth::user()->email;
                
                try {
                    if(env('QUEUE_MAIL') == 'on'){
                        dispatch(new \App\Jobs\SendInvoiceEmail($data));
                    }
                    else{
                        // \Mail::to(env('MAIL_TO'))->send(new OrderMail($data));
                    }
                } catch (Exception $e) {
                    
                }
            
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            return redirect('business/dashboard');
        }
       abort(404);
    }

}