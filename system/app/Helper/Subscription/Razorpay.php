<?php 

namespace App\Helper\Subscription;
use Session;
use Razorpay\Api\Api;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\BeforePayment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class Razorpay
{
   
    protected static $payment_id;

    public static function redirect_if_payment_success()
    {
        // dd(Session::all());
        $payment_info = Session::get('payment_info');
        $previousURL = $payment_info['previousURL'];
        //    dd($payment_info);

        if ($payment_info['payment_from'] == 'partner') {
            return route('business.partner.payment.success');
        }else{
            return route('payment.success');
        }

   }

   public static function redirect_if_payment_faild()
   {
       $payment_info = Session::get('payment_info');
       if(Session::get('previous_url')){
           $previousURL = '/checkout';
       }else{
           $previousURL = '';
       }
       
       if ($payment_info != '' && url('/checkout') == $previousURL) {
           return url('/checkout');
       }
       else{
            return route('payment.fail');
       }
   }

    public function razorpay_view()
    {
       $data=Session::get('order_info');
       $Info=Razorpay::make_payment($data);
       return view('subscription.razorpay',compact('Info'));
    }

    public static function make_payment($array)
    {
        // dd($array);

        $phone=$array['phone'];
        $email=$array['email'];
        $name=$array['name'];
        $amount=$array['amount'];
        $ref_id=$array['ref_id'];
        $gst_claim=$array['gst_claim'];
        $gst_address=$array['gst_address'];
        $gst_business_name=$array['gst_business_name'];
        $gst_state=$array['gst_state'];
        $gst_city=$array['gst_city'];
        $gst_pincode=$array['gst_pincode'];
        $gst_number=$array['gst_number'];
        $getway_id=$array['getway_id'];
        $transaction_type=$array['transaction_type'];
        $billName=$array['billName'];
        // $plan_group_id=$array['plan_group_id'] ?? '';
        $currency=$array['currency'];
        // $amount = 1;

        $info=Category::where('type','payment_gateway')->with('credentials')->findorFail($getway_id);
        
        $credentials=json_decode($info->credentials->content ?? '');
         
        $razorpay_credentials['key_id']=$credentials->key_id;
        $razorpay_credentials['key_secret']=$credentials->key_secret;
        $razorpay_credentials['currency']=$credentials->currency;
        Session::put('razorpay_credentials_for_admin',$razorpay_credentials);

        $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
        $referance_id=$ref_id;
        $order = $api->order->create(array(
            'receipt' => $referance_id,
            'amount' => $amount*100,
            'currency' => $razorpay_credentials['currency']
        )
        );

         // Return response on payment page
        $response = [
            'orderId' => $order['id'],
            'razorpayId' =>  $razorpay_credentials['key_id'],
            'amount' => $amount*100,
            'name' => $name,
            'currency' => $razorpay_credentials['currency'],
            'email' => $email,
            'contactNumber' => $phone,
            'address' => "",
            'description' => $billName,
            // 'plan_group_id' => $plan_group_id
        ];


        $allOrderData = Session::all();
// dd($allOrderData);
        unset($allOrderData['_token']);
        unset($allOrderData['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d']);
        unset($allOrderData['password_hash_web']);
        unset($allOrderData['_previous']);
        unset($allOrderData['_flash']);

        $newPayment = BeforePayment::where('order_id',$order['id'])->orderBy('id','desc')->first();

        if($newPayment == null){
            $newPayment = new BeforePayment;
            $newPayment->order_id = $order['id'];
            $newPayment->session_data = json_encode($allOrderData);
            $newPayment->save();
        }

        return $response;
    }


    public function status(Request $request)
    {

        if(Session::has('razorpay_credentials_for_admin')){
            $signatureStatus = Razorpay::SignatureVerify(
                $request->all()['rzp_signature'],
                $request->all()['rzp_paymentid'],
                $request->all()['rzp_orderid']
            );

            if($signatureStatus == true)
            {
                $previousURL = url()->previous();
                
                //for success
                $data['payment_id'] = Razorpay::$payment_id;
                $data['payment_method'] = "razorpay";

                $order_info= Session::get('order_info');
                // $data['ref_id'] =$order_info['ref_id'];
                // $data['plan_group_id'] =$order_info['plan_group_id'] ?? '';
                $data['billName'] =$order_info['billName'];
                // $data['billing_type'] =$order_info['billing_type'];
                $data['getway_id']=$order_info['getway_id'];
                $data['amount'] =$order_info['amount']; 
                $data['name'] =$order_info['name']; 
                $data['email'] =$order_info['email']; 
                $data['phone'] =$order_info['phone'];
                $data['gst_claim'] =$order_info['gst_claim'];
                $data['gst_business_name'] =$order_info['gst_business_name'];
                $data['gst_address']=$order_info['gst_address'];
                $data['gst_state']=$order_info['gst_state'];
                $data['gst_city']=$order_info['gst_city'];
                $data['gst_pincode']=$order_info['gst_pincode'];
                $data['gst_number']=$order_info['gst_number'];
                $data['transaction_type'] =$order_info['transaction_type'];
                $data['payment_from']= $order_info['payment_from'];
                $data['previousURL'] =$previousURL;

                // $data['amount'] = 1;

                Session::forget('order_info');
                Session::put('payment_info', $data);
                Session::forget('razorpay_credentials_for_admin');
                
                return redirect(Razorpay::redirect_if_payment_success());
            }
            else{
                Session::forget('razorpay_credentials_for_admin');
                return redirect(Razorpay::redirect_if_payment_faild());
            }

        }

       
    }

    // In this function we return boolean if signature is correct
    private static function SignatureVerify($_signature,$_paymentId,$_orderId)
    {
        $razorpay_credentials=Session::get('razorpay_credentials_for_admin');
        try
        {
        // Create an object of razorpay class
            $api = new Api($razorpay_credentials['key_id'], $razorpay_credentials['key_secret']);
            $attributes  = array(
                'razorpay_signature'  => $_signature,
                'razorpay_payment_id'  => $_paymentId,
                'razorpay_order_id' => $_orderId
            );
            $order  = $api->utility->verifyPaymentSignature($attributes);
            Razorpay::$payment_id=$_paymentId;
            return true;
        }
        catch(\Exception $e)
        {
        // If Signature is not correct its give a excetption so we use try catch
            return false;
        }
    }	

}