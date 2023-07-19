<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;

use App\Helper\Subscription\Instamojo;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\PayU;
use Illuminate\Http\Request;
use App\Models\Categorymeta;
use App\Models\Userplanmeta;
use App\Models\Useroption;
use App\Models\Transaction;
use App\Models\Userplan;
use App\Models\Category;
use App\Mail\OrderMail;
use App\Models\Option;
use App\Models\State;
use App\Models\User;
use App\Models\Plan;
use Session;
use Auth;
use DB;

class PlanController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function plans()
    {
        $userplanmeta = Userplan::where('user_id',Auth::id())->select('plan_id','status','will_expire_on')->orderBy('id','desc')->first();
        $todays_date = date('Y-m-d');
        
        if($userplanmeta->will_expire_on > $todays_date){
            Session(['plan_id' => $userplanmeta->plan_id]);
        }else{
            Session(['plan_id' => '']);
        }
        
        $posts=Plan::where('status',1)->where('is_default',0)->get();

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.plan.index',compact('posts','notification_list','planData'));
    }

    public function checkSubscription(Request $request){
        $userplanmeta = Userplan::where('user_id',Auth::id())->where('status',1)->select('id','plan_id','status','will_expire_on')->orderBy('id','desc')->first();
        $todays_date = date('Y-m-d');
        $expiry_date = date('Y-m-d', strtotime($userplanmeta->will_expire_on. ' - 5 days')); 
        $url = url('/business/make-payment/'.$request->plan_id);

        if(Session('plan_id') == $request->plan_id){
            if($todays_date > $expiry_date){
                return response()->json([
                    'status' => true,
                    'url' => $url,
                    'message' => 'Can subscribe again to the old plan.'
                ]);
            }else{
                return response()->json([
                    'status' => false,                    
                    'message' => 'You have already Subscribed to this Plan!'
                ]);
            }
        }else{
            return response()->json([
                'status' => true,
                'url' => $url,
                'message' => 'Can subscribe to new plan.'
            ]);
        }
        
    }

    public function planHistory()
    {
        $posts= Userplan::with('plan_info','payment_method')->where('amount', '!=', 0)->where('user_id',Auth::id())->latest()->paginate(20);
        //dd($posts);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.plan.history',compact('posts','notification_list','planData'));
    }

    public function planSubscription()
    {
        $info= Userplan::with('plan_info','payment_method')->where('user_id',Auth::id())->latest()->orderBy('id', 'desc')->first();
         // dd($info);
        if(Auth::user()->status == '3'){
            return redirect()->route('business.plan');
        }else{

            //notification_list
            $notification_list = CommonSettingController::getNotification();
            $planData = CommonSettingController::getBusinessPlanDetails();

            return view('business.plan.subscription',compact('info','notification_list','planData'));
        }
    }

    public function make_payment($id)
    {
        if(Session::has('success')){
            Session::flash('success', 'Thank You For Subscribe After Review The Order You Will Get A Notification Mail From Admin');
            return redirect('business/plan'); 
        }

        $info=Plan::where('status',1)->where('is_default',0)->where('price','>',0)->findorFail($id);
        // dd('hey');
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

        $price=$currency_name.' '.$total.' Inclusive of GST.';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.plan.payment',compact('info','getways','price','notification_list','planData', 'states'));
    }

    public function make_charge(Request $request,$id)
    {

        if($request->gst_claim == null || $request->gst_claim == ''){
            $gst_claim = 0;
        }else{ $gst_claim = $request->gst_claim; }
        if($request->gst_state == null || $request->gst_state == ''){
            $gst_state = 0;
        }else{ $gst_state = $request->gst_state; }
        if($request->gst_number == null || $request->gst_number == ''){
            $gst_number = 0;
        }else{ $gst_number = $request->gst_number; }

        $info=Plan::where('status',1)->where('is_default',0)->where('price','>',0)->findorFail($id);
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
        $data['gst_claim']=$gst_claim;
        $data['gst_state']=$gst_state;
        $data['gst_number']=$gst_number;
        $data['currency']=strtoupper($currency_name);

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

        if (Session::has('payment_info')) {
            $data = Session::get('payment_info');

            $plan=Plan::findorFail($data['ref_id']);

            // dd($data);

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
                $transection->gst_number = $data['gst_number'];
                $transection->gst_state = $data['gst_state'];
                $transection->save();

                //old subscription
                $userplanmeta = Userplan::where('user_id',Auth::id())->where('status',1)->select('id','plan_id','status','will_expire_on')->orderBy('id','desc')->first();

                $exp_days =  $plan->days;
                if($userplanmeta != null && $data['ref_id'] == $userplanmeta->plan_id){
                    $expiry_date = date('Y-m-d',strtotime($userplanmeta->will_expire_on . " + 365 day"));
                }else{
                    $expiry_date = \Carbon\Carbon::now()->addDays(($exp_days - 1))->format('Y-m-d');
                }


                $max_order=Userplan::max('id');
                $order_prefix=Option::where('key','order_prefix')->orderBy('id', 'desc')->first();

                $order_no = $order_prefix->value.$max_order;


                //set others to 0
                Userplan::where('user_id',Auth::user()->id)->update(['status' => 0]);

                $user=new Userplan;
                $user->order_no=$order_no;
                $user->amount=$data['amount'];
                $user->user_id =Auth::id();
                $user->plan_id = $plan->id;
                $user->transaction_id = $transection->id;
                $user->will_expire_on=$expiry_date;
                
                if($transection->status == 1){
                    $user->status=1;
                }                 
                $user->save();
                
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

    public function thankYou(Request $request)
    {
        // dd('ok');
        if(!Session::has('payment_info')){
            return redirect()->route('business.dashboard');
        }
        $user = Auth::User();
        // dd($user->user_plan);
        // dd(Session::get('payment_info'));
        Session::forget('payment_info');

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.payment-success', compact('user','notification_list','planData'));
    }
}
