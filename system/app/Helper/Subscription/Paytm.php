<?php 

namespace App\Helper\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\PaytmPayment;
use App\Models\Category;
use App\Models\BeforePayment;

use Carbon\Carbon;
use PaytmWallet;
use Session;
use Auth;


class Paytm
{
   
    protected static $payment_id;

    public static function redirect_if_payment_success()
    {
        if (url('/') == env('APP_URL')) {
            return url('/business/payment-success');
        }
        else{
           return route('payment.success');
        }

    }

    public static function redirect_if_payment_faild()
    {
        return route('payment.fail');
    }

    // public function paytm_view()
    // {
    //    $data=Session::get('order_info');
    //    $Info=Paytm::make_payment($data);
    //    return view('subscription.razorpay',compact('Info'));
    // }

    public static function make_payment($array)
    {
        // dd($array['getway_id']);
        $phone=$array['phone'];
        $email=$array['email'];
        $amount=$array['amount'];
        $ref_id=$array['ref_id'];
        $gst_claim=$array['gst_claim'];
        $gst_business_name =$array['gst_business_name'];
        $gst_state=$array['gst_state'];
        $gst_number=$array['gst_number'];
        $getway_id=$array['getway_id'];
        $name=$array['name'];
        $billName=$array['billName'];
        // $website=$array['website'];
        $amount = '1';


        $info=Category::where('type','payment_gateway')->with('credentials')->findorFail($getway_id);
        $credentials=json_decode($info->credentials->content ?? '');
         
        $paytm_credentials['merchant_key']=$credentials->merchant_key;
        $paytm_credentials['merchant_id']=$credentials->merchant_id;
        $paytm_credentials['merchant_website']=$credentials->website;
        $paytm_credentials['channel']=$credentials->channel_id_web;
        $paytm_credentials['industry_type']=$credentials->industry_type;
        Session::put('paytm_credentials_for_admin',$paytm_credentials);


        // dd($paytm_credentials);

        $orderId = uniqid();
        $date = Carbon::today()->format('dmy');
        $order_id = 'paytm_'.$orderId.$date;


        $allOrderData = Session::all();

        unset($allOrderData['_token']);
        unset($allOrderData['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d']);
        unset($allOrderData['password_hash_web']);
        unset($allOrderData['_previous']);
        unset($allOrderData['_flash']);

        $newPayment = BeforePayment::where('order_id',$order_id)->orderBy('id','desc')->first();

        if($newPayment == null){
            $newPayment = new BeforePayment;
            $newPayment->order_id = $order_id;
            $newPayment->session_data = json_encode($allOrderData);
            $newPayment->save();
        }
        

        $paytm= new PaytmPayment;
        $paytm->user = $name;
        // $paytm->name = $name;
        $paytm->email = $email;
        $paytm->phone = $phone;
        $paytm->order_id = $order_id;
        $paytm->ref_id = $ref_id;
        $paytm->txn_amount = $amount;
        $paytm->gst_claim = $gst_claim;
        $paytm->gst_business_name = $gst_business_name;
        $paytm->gst_state = $gst_state;
        $paytm->gst_number = $gst_number;
        $paytm->status = 'isPending';
        $paytm->save();

        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $order_id,
          'user' => $phone,
          'mobile_number' => $phone,
          'email' => $email,
          'amount' => $amount,
          'callback_url' => Route('paytm.fallback'),
        ]);


        return $payment->receive();

    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        
        $response = $transaction->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm

        $transaction->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $transaction->getOrderId(); // Get order id
        $transaction->getTransactionId(); // Get transaction id

        $paytm = PaytmPayment::where('order_id', $response['ORDERID'])->first();
        
        if($transaction->isSuccessful()){

            $paytm->mid = $response['MID'];
            $paytm->txnid = $response['TXNID'];
            $paytm->txn_amount = $response['TXNAMOUNT'];
            $paytm->payment_mode = $response['PAYMENTMODE'];
            $paytm->status = 'Success';
            $paytm->txn_date = $response['TXNDATE'];
            $paytm->resp_code = $response['RESPCODE'];
            $paytm->currency = $response['CURRENCY'];
            $paytm->resp_msg = $response['RESPMSG'];
            $paytm->gateway_name = $response['GATEWAYNAME'];
            $paytm->bank_txnid = $response['BANKTXNID'];
            $paytm->checksumhash = $response['CHECKSUMHASH'];

            $paytm->save();

            $data['payment_id'] = $paytm->order_id;
            $data['payment_method'] = "paytm";
            $data['ref_id'] = $paytm->ref_id;
            $data['getway_id']='14';
            $data['amount'] =$paytm->txn_amount;
            $data['name'] =$paytm->user;
            $data['email'] =$paytm->email;
            $data['phone'] =$paytm->phone;
            $data['gst_claim'] =$paytm->gst_claim;
            $data['gst_business_name'] =$paytm->gst_business_name;
            $data['gst_state'] =$paytm->gst_state;
            $data['gst_number'] =$paytm->gst_number;
            Session::put('payment_info', $data);

            return redirect($this->redirect_if_payment_success());

        }else if($transaction->isFailed()){

            $paytm->mid = $response['MID'];
            $paytm->txnid = $response['TXNID'];
            $paytm->txn_amount = $response['TXNAMOUNT'];
            $paytm->status = 'Failed';
            $paytm->resp_code = $response['RESPCODE'];
            $paytm->currency = $response['CURRENCY'];
            $paytm->resp_msg = $response['RESPMSG'];
            $paytm->bank_txnid = $response['BANKTXNID'];
            $paytm->checksumhash = $response['CHECKSUMHASH'];

            $paytm->save();

            return redirect($this->redirect_if_payment_faild());

        }else if($transaction->isOpen()){

            dd('in process');
        
        }
    }

    public function statusCheck(){
        $status = PaytmWallet::with('status');
        $status->prepare(['order' => $order->id]);
        $status->check();
        
        $response = $status->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=txn-status-api-description
        
        if($status->isSuccessful()){
          //Transaction Successful
        }else if($status->isFailed()){
          //Transaction Failed
        }else if($status->isOpen()){
          //Transaction Open/Processing
        }
        $status->getResponseMessage(); //Get Response Message If Available
        //get important parameters via public methods
        $status->getOrderId(); // Get order id
        $status->getTransactionId(); // Get transaction id
    }

    public function refund(){
        $refund = PaytmWallet::with('refund');
        $refund->prepare([
            'order' => $order->id,
            'reference' => "refund-order-4", // provide refund reference for your future reference (should be unique for each order)
            'amount' => 300, // refund amount 
            'transaction' => $order->transaction_id // provide paytm transaction id referring to this order 
        ]);
        $refund->initiate();
        $response = $refund->response(); // To get raw response as array
        
        if($refund->isSuccessful()){
          //Refund Successful
        }else if($refund->isFailed()){
          //Refund Failed
        }else if($refund->isOpen()){
          //Refund Open/Processing
        }else if($refund->isPending()){
          //Refund Pending
        }
    }


    public function status(Request $request)
    {
         if(Session::has('paytm_credentials_for_admin')){
    // Now verify the signature is correct . We create the private function for verify the signature
        $signatureStatus = Paytm::SignatureVerify(
            $request->all()['rzp_signature'],
            $request->all()['rzp_paymentid'],
            $request->all()['rzp_orderid']
        );

      // If Signature status is true We will save the payment response in our database
      // In this tutorial we send the response to Success page if payment successfully made
        if($signatureStatus == true)
        {
            
            //for success
            $data['payment_id'] = Paytm::$payment_id;
            $data['payment_method'] = "paytm";

            $order_info= Session::get('order_info');
            $data['ref_id'] =$order_info['ref_id'];
            $data['getway_id']=$order_info['getway_id'];
            $data['amount'] =$order_info['amount']; 
            $data['name'] =$order_info['name']; 
            $data['email'] =$order_info['email']; 
            $data['phone'] =$order_info['phone'];
            $data['gst_claim'] =$order_info['gst_claim'];
            $data['gst_business_name'] =$order_info['gst_claim'];
            $data['gst_state'] =$order_info['gst_state'];
            $data['gst_number'] =$order_info['gst_number'];
            Session::forget('order_info');
            Session::put('payment_info', $data);
            Session::forget('paytm_credentials_for_admin');
            return redirect(Paytm::redirect_if_payment_success());
        }
        

       }

       else{
            Session::forget('paytm_credentials_for_admin');
            return redirect(Razorpay::redirect_if_payment_faild());
        }
    }

    // In this function we return boolean if signature is correct
    private static function SignatureVerify($_signature,$_paymentId,$_orderId)
    {
        $paytm_credentials=Session::get('paytm_credentials_for_admin');
        try
        {
        // Create an object of razorpay class
            $api = new Api($paytm_credentials['merchant_id'], $paytm_credentials['merchant_key']);
            $attributes  = array('razorpay_signature'  => $_signature,  'razorpay_payment_id'  => $_paymentId ,  'razorpay_order_id' => $_orderId);
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