<?php 

namespace App\Helper\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BeforePayment;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
class Cashfree 
{
    
     public static function redirect_if_payment_success()
     {
        $payment_info = Session::get('payment_info');
        $previousURL = $payment_info['previousURL'];
        
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

    public static function returnUrl()
    {
        return route('cashfree.fallback');
    }

    public static function make_payment($array)
    {
        $url='https://www.cashfree.com/checkout/post/submit';

        extract($_POST);
        $phone=$array['phone'];
        $email=$array['email'];
        $name=$array['name'];
        $amount=$array['amount'];
        $ref_id=$array['ref_id'];
        $gst_claim=$array['gst_claim'];
        $gst_business_name=$array['gst_business_name'];
        $gst_address=$array['gst_address'];
        $gst_state=$array['gst_state'];
        $gst_city=$array['gst_city'];
        $gst_pincode=$array['gst_pincode'];
        $gst_number=$array['gst_number'];
        $getway_id=$array['getway_id'];
        $transaction_type=$array['transaction_type'];
        $billName=$array['billName'];
        // $billing_type = $array['billing_type'];
        $currency=$array['currency'];
        $previousURL=$array['previousURL'] ?? '';
        // $amount = 1;

        $info=Category::where('type','payment_gateway')->with('credentials')->findorFail($getway_id);
        $credentials=json_decode($info->credentials->content ?? '');

        $secretKey = $credentials->key_secret;
        $key_id = $credentials->key_id;

        $orderId = uniqid();
        $date = Carbon::today()->format('dmy');
        $order_id = 'cashfree_'.$orderId.$date;

        $postData = [
            "appId" => $key_id,
            "orderId" => $order_id,
            "orderAmount" => $amount,
            "orderCurrency" => $currency,
            "orderNote" => 'MouthPublicity.io recharge',
            "customerName" => $name,
            "customerPhone" => $phone,
            "customerEmail" => $email,
            "returnUrl" => Cashfree::returnUrl(),
            "notifyUrl" => Cashfree::returnUrl()
        ];
        ksort($postData);
        $signatureData = "";
        foreach ($postData as $key => $value) {
            $signatureData .= $key . $value;
        }

        $signature = hash_hmac('sha256', $signatureData, $secretKey, true);
        $signature = base64_encode($signature);

        DB::table('cashfree_payments')
        ->insert([
            'order_id' => $order_id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'amount' => $amount,
            'currency' => $currency,
            'ref_id' => $ref_id,
            'note' => 'MouthPublicity.io recharge',
            'status' => 'pending',
            'gst_claim' => $gst_claim,
            'gst_business_name' => $gst_business_name,
            'gst_address' => $gst_address,
            'gst_state' => $gst_state,
            'gst_city' => $gst_city,
            'gst_pincode' => $gst_pincode,
            'gst_number' => $gst_number,
            'signature' => $signature,
            'transaction_type' => $transaction_type,
            'previousURL' => $previousURL,
            'billName' => $billName,
            // 'billing_type' => $billing_type,
            'payment_path' => Session::get('previous_url'),
            'payment_from' => $array['payment_from'],
        ]);

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

        echo $form = '<form class="redirectForm" id="cashfreeForm" method="POST" action="'.$url.'">
        <input type="hidden" name="appId" value="'.$key_id.'"/>
        <input type="hidden" name="orderId" value="'.$order_id.'"/>
        <input type="hidden" name="orderAmount" value="'.$amount.'"/>
        <input type="hidden" name="orderCurrency" value="'.$currency.'"/>
        <input type="hidden" name="orderNote" value="MouthPublicity.io recharge"/>
        <input type="hidden" name="customerName" value="'.$name.'"/>
        <input type="hidden" name="customerEmail" value="'.$email.'"/>
        <input type="hidden" name="customerPhone" value="'.$phone.'"/>
        <input type="hidden" name="returnUrl" value="'.Cashfree::returnUrl().'"/>
        <input type="hidden" name="notifyUrl" value="'.Cashfree::returnUrl().'"/>
        <input type="hidden" name="signature" value="'.$signature.'"/>
        <button type="submit" id="paymentbutton" class="btn btn-block btn-lg bg-ore continue-payment">Continue to Payment</button>

        </form>
        <script>            
            document.addEventListener("DOMContentLoaded", function(event) {
            document.createElement("form").submit.call(document.getElementById("cashfreeForm"));
        });        
        </script>';

    }


    public function status()
    {
        $response=Request()->all();
        // dd($response);
        $txStatus=$response['txStatus'];

        if ($txStatus=='SUCCESS') {
            $payInfo = DB::table('cashfree_payments')
            ->where('order_id', $response['orderId'])
            ->orderBy('id', 'desc')->first();

            $data['payment_id'] = $response['orderId'];
            $data['payment_method'] = "cashfree";
            $data['ref_id'] =$payInfo->ref_id;
            $data['getway_id']='12';
            $data['amount'] =$response['orderAmount'];
            $data['name'] =$payInfo->name;
            $data['email'] =$payInfo->email;
            $data['phone'] =$payInfo->phone;
            $data['gst_claim'] =$payInfo->gst_claim;
            $data['gst_business_name'] =$payInfo->gst_business_name;
            $data['gst_address'] =$payInfo->gst_address;
            $data['gst_state'] =$payInfo->gst_state;
            $data['gst_city'] =$payInfo->gst_city;
            $data['gst_pincode'] =$payInfo->gst_pincode;
            $data['gst_number'] =$payInfo->gst_number;
            $data['transaction_type'] =$payInfo->transaction_type;
            $data['previousURL'] =$payInfo->previousURL;
            $data['billName'] =$payInfo->billName;
            // $data['billing_type'] =$payInfo->billing_type;
            $data['payment_from'] =$payInfo->payment_from;
            Session::put('payment_info', $data);

            Session::put('previous_url', $payInfo->payment_path);
            
            return redirect($this->redirect_if_payment_success());
        }      
        else{
            return redirect($this->redirect_if_payment_faild());
        }
    }
}