<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Offer;
use App\Models\Option;
use App\Models\OfferSubscription;
use App\Models\Template;
use App\Models\BusinessDetail;
use App\Models\InstantTask;
use App\Models\AssignTask;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Userplanmeta;
use App\Models\Userplan;
use App\Models\Redeem;
use App\Models\OfferInstant;
use App\Models\SocialChannel;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
use URL;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest, auth');
    }

    // public function socialAndSupport()
    // {
    //     $option= Option::where('key', 'company_info')->first();
    //     $info=json_decode($option->value);
    //     return $info;
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */

    // public function index()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('front.home', compact('info'));
    // }

    // public function pricing()
    // {
    //     $info = $this->socialAndSupport();
    //     $plans = Plan::latest()->where('status', 1)->get();
    //     return view('front.pricing', compact('plans','info'));
    // }

    // public function contact_us()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('front.contact_us', compact('info'));
    // }

    // public function blogs()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('front.blogs', compact('info'));
    // }

    // public function privacy_policy()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('front.info_pages.privacy_policy', compact('info'));
    // }

    // public function terms_and_conditions()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('front.info_pages.terms_and_conditions', compact('info'));
    // }

    // public function track()
    // {
    //     $info = $this->socialAndSupport();
    //     return view('track', compact('info'));
    // }

    // public function checkoutSubscription(Request $request){

    //     $plan_id = Session::get('plan_id');
    //     $plan = Plan::where('id', $plan_id)->first();
    //     $info = $this->socialAndSupport();
    //     $gst = $plan->price - ($plan->price * (100 / (100 + 18 ) ) );
    //     $priceWithoutGst = $plan->price - $gst;

    //     $getway=Category::where('type','payment_gateway')->where('slug','=','razorpay')->first();
    //     // dd($getway);
    //     return view('front.checkout', compact('plan', 'info', 'gst', 'priceWithoutGst', 'getway'));

    // }

    // public function checkoutMakePayment(Request $request, $id){

    //     $info=Plan::where('status',1)->where('is_default',0)->where('price','>',0)->findorFail($id);
    //     $getway=Category::where('type','payment_gateway')->where('slug','=','razorpay')->first();

    //     $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
    //     $currency=json_decode($currency->value);
    //     $currency_name=$currency->currency_name;
        
    //     $total=$info->price;

    //     $data['ref_id']=$id;
    //     $data['getway_id']=$request->mode;
    //     $data['amount']=$total;
    //     $data['email']=$request->email;
    //     $data['name']=$request->name;
    //     $data['phone']=$request->phone;
    //     $data['billName']=$info->name;
    //     $data['currency']=strtoupper($currency_name);

    //     Session::put('order_info',$data);
    //     if ($getway->slug=='paypal') {
    //        return Paypal::make_payment($data);
    //     }
    //     if ($getway->slug=='instamojo') {
    //        return Instamojo::make_payment($data);
    //     }
    //     if ($getway->slug=='toyyibpay') {
    //        return Toyyibpay::make_payment($data);
    //     }
    //     if ($getway->slug=='stripe') {
    //         $data['stripeToken']=$request->stripeToken;
    //        return Stripe::make_payment($data);
    //     }
    //     if ($getway->slug=='mollie') {
    //         return Mollie::make_payment($data);
    //     }
    //     if ($getway->slug=='paystack') {            
    //         return Paystack::make_payment($data);
    //     }
    //     if ($getway->slug=='mercado') {            
    //         return Mercado::make_payment($data);
    //     }
        
    //     if ($getway->slug=='razorpay') {
    //        return redirect('/payment-with/razorpay');
    //     }
    // }

    // public function success()
    // {

    //     if (Session::has('payment_info')) {
    //         $data = Session::get('payment_info');
    //         $checkUser = User::where('email',$data['email'])->where('mobile',$data['phone'])->first();

    //         $plan=Plan::findorFail($data['ref_id']);
    //         $date = \Carbon\Carbon::now()->format('Ymd');
    //         $n = 8;
    //         $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         $randomPass = '';          
    //         for ($i = 0; $i < $n; $i++) { 
    //             $index = rand(0, strlen($char) - 1); 
    //             $randomPass .= $char[$index]; 
    //         }

    //         $m=180;                
    //         $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //         $randomCode = '';      
    //         for ($i = 0; $i < $m; $i++) {
    //             $index = rand(0, strlen($characters) - 1);
    //             $randomCode .= $characters[$index];
    //         }

    //         if(!empty($checkUser)){
    //                 $user = $checkUser;
    //         }else{
    //             $user=new User;
    //             $user->name=$data['name'];
    //             $user->email=$data['email'];       
    //             $user->mobile=$data['phone'];
    //             $user->password=Hash::make($randomPass);
    //             $user->pass_token=$randomCode.$date;
    //             $user->role_id=2;
    //             $user->status=1;
    //             $user->save();

    //             $details = new BusinessDetail;
    //             $details->user_id = $user->id;
    //             $details->uuid = $user->id.'BUSI'.date("Ymd");
    //             $details->save();
    //         }

    //         DB::beginTransaction();
    //         try {

    //             $exp_days =  $plan->days;
    //             $expiry_date = \Carbon\Carbon::now()->addDays(($exp_days - 1))->format('Y-m-d');
    //             $max_order=Userplan::max('id');
    //             $order_prefix=Option::where('key','order_prefix')->first();                

    //             if($user != null){
    //                 $zeroPlan = Plan::where('price',0)->first();

    //                 $transection=new Transaction;
    //                 $transection->category_id = 1;
    //                 $transection->user_id = $user->id;
    //                 $transection->transaction_id = 0;
    //                 $transection->status = 1;
    //                 $transection->save();

    //                 $order_no = $order_prefix->value.$max_order;
    //                 $userplan=new Userplan;
    //                 $userplan->order_no=$order_no;
    //                 $userplan->amount=0;
    //                 $userplan->user_id =$user->id;
    //                 $userplan->plan_id = $zeroPlan->id;
    //                 $userplan->transaction_id = $transection->id;
    //                 $userplan->will_expired=$expiry_date;
    //                 $userplan->status=1;               
    //                 $userplan->save();
                   
    //                 $meta=new Userplanmeta;
    //                 $meta->user_id=$user->id;
    //                 $meta->name=$zeroPlan->name;
    //                 $meta->future_limit=$zeroPlan->future_limit;
    //                 $meta->instant_limit=$zeroPlan->instant_limit;
    //                 $meta->redeem_limit=$zeroPlan->redeem_limit;
    //                 $meta->employee_limit=$zeroPlan->employee_limit;
    //                 $meta->support_limit=$zeroPlan->support_limit;
    //                 $meta->statistic_limit=$zeroPlan->statistic_limit;
    //                 $meta->template_limit=$zeroPlan->template_limit;
    //                 $meta->save();
    //             }

    //             $transection=new Transaction;
    //             $transection->category_id = $data['getway_id'];
    //             $transection->user_id = $user->id;
    //             $transection->transaction_id = $data['payment_id'];
    //             if (isset($data['payment_status'])) {
    //                 $transection->status = $data['payment_status'];
    //             }else{
    //                 $transection->status = 1;
    //             }
    //             $transection->save();

    //             $order_no = $order_prefix->value.$max_order;

    //             Userplan::where('user_id',$user->id)->update(['status' => 0]);

    //             $userplan=new Userplan;
    //             $userplan->order_no=$order_no;
    //             $userplan->amount=$data['amount'];
    //             $userplan->user_id =$user->id;
    //             $userplan->plan_id = $plan->id;
    //             $userplan->transaction_id = $transection->id;
    //             $userplan->will_expired=$expiry_date;
                
    //             if($transection->status == 1){
    //                 $userplan->status=1;
    //             }                 
    //             $userplan->save();
               
    //             if($transection->status == 1){
    //                 $meta=Userplanmeta::where('user_id',$user->id)->orderBy('id', 'desc')->first();
    //                 if(empty($meta)){
    //                     $meta=new Userplanmeta;
    //                     $meta->user_id=$user->id;
    //                 }
    //                 $meta->name=$plan->name;
    //                 $meta->future_limit=$plan->future_limit;
    //                 $meta->instant_limit=$plan->instant_limit;
    //                 $meta->redeem_limit=$plan->redeem_limit;
    //                 $meta->employee_limit=$plan->employee_limit;
    //                 $meta->support_limit=$plan->support_limit;
    //                 $meta->statistic_limit=$plan->statistic_limit;
    //                 $meta->template_limit=$plan->template_limit;
    //                 $meta->save();
    //             }
                
    //             Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

    //             $data['info']=$userplan;
    //             $data['to_admin']=env('MAIL_TO');
    //             $data['from_email']=$user->email;

    //             Auth::loginUsingId($user->id);
    //             $userAuth = Auth::User();
    //             Auth()->login($user, true); 
                
    //             try {
    //                 if(env('QUEUE_MAIL') == 'on'){
    //                     // dispatch(new \App\Jobs\SendInvoiceEmail($data));
    //                 }
    //                 else{
    //                     // \Mail::to(env('MAIL_TO'))->send(new OrderMail($data));
    //                 }
    //             } catch (Exception $e) {
                    
    //             }
            
    //             DB::commit();
    //         } catch (Exception $e) {
    //             DB::rollback();
    //         }


    //         $plan = Plan::where('id', $plan->id)->first();
    //         $gst = $plan->price - ($plan->price * (100 / (100 + 18 ) ) );
    //         $priceWithoutGst = $plan->price - $gst;

    //         $emailData = [
    //             'name' => $user->name,
    //             'mobile' => $user->mobile,
    //             'email' => $user->email,
    //             'token' => $user->pass_token,
    //             'plan_name' => $plan->name,
    //             'plan_price' => $plan->price,
    //             'plan_gst' => $gst,
    //             'plan_without_gst' => $priceWithoutGst,
    //             'plan_date' => $userplan->created_at
    //         ];

    //         if(!empty($checkUser)){
    //             \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);
    //             return redirect('business/thank-you');
    //         }else{
    //             \App\Http\Controllers\CommonMailController::BusinessByAdminMail($emailData);
    //             return redirect(url('generate-password/'.'?token='.$randomCode.$date));
    //         }
            
    //     }
    //     abort(404);
    // }


}
