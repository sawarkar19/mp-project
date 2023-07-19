<?php 

namespace App\Helper\Subscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\PayuPayment;
use App\Models\BeforePayment;

use Carbon\Carbon;
use Session;
use Auth;
use DB;
class PayU 
{
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

    public static function returnUrl()
    {
        return route('payu.fallback');
    }

    public static function make_payment($array)
    {
        if (env('APP_DEBUG') == false) {
            $url='https://test.payu.in/_payment';
        }
        else{
            $url='https://secure.payu.in/_payment';
        }
       
       // dd($array);
        extract($_POST);
        $phone=$array['phone'];
        $email=$array['email'];
        $amount=$array['amount'];
        $ref_id=$array['ref_id'];
        $gst_claim=$array['gst_claim'];
        $gst_business_name=$array['gst_business_name'];
        $gst_state=$array['gst_state'];
        $gst_number=$array['gst_number'];
        $getway_id=$array['getway_id'];
        $name=$array['name'];
        $billName=$array['billName'];
        $currency=$array['currency'];
        $productInfo = 'subscription';
        $first_name = explode(" ", $name);
        $amount = 1;

        $info=Category::where('type','payment_gateway')->with('credentials')->findorFail($getway_id);
        $credentials=json_decode($info->credentials->content ?? '');

        $salt = $credentials->salt;
        $key = $credentials->key;

        $orderId = uniqid();
        $date = Carbon::today()->format('dmy');
        $txnid = 'payu_'.$orderId.$date;

        //save details before payment
        DB::table('payu_payments')
        ->insert([
            'order_id' => $txnid,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'amount' => $amount,
            'currency' => $currency,
            'note' => 'Openlink subscription',
            'status' => 'pending',
            'gst_claim' => $gst_claim,
            'gst_business_name' => $gst_business_name,
            'gst_state' => $gst_state,
            'gst_number' => $gst_number,
            'ref_id' => $ref_id
        ]);



        $allOrderData = Session::all();

        unset($allOrderData['_token']);
        unset($allOrderData['login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d']);
        unset($allOrderData['password_hash_web']);
        unset($allOrderData['_previous']);
        unset($allOrderData['_flash']);

        $newPayment = BeforePayment::where('order_id',$txnid)->orderBy('id','desc')->first();

        if($newPayment == null){
            $newPayment = new BeforePayment;
            $newPayment->order_id = $txnid;
            $newPayment->session_data = json_encode($allOrderData);
            $newPayment->save();
        }


        $paymentData['key']=$key;
        $paymentData['txnid']=$txnid;
        $paymentData['amount']=$amount;
        $paymentData['firstname']=$first_name[0];
        $paymentData['email']=$email;
        $paymentData['phone']=$phone;
        $paymentData['productinfo']=$productInfo;
        $paymentData['surl']=PayU::returnUrl();
        $paymentData['furl']=route('payment.fail');
        $paymentData['service_provider']='payu_paisa';
        $paymentData['lastname']='';
        $paymentData['curl']='';
        $paymentData['address1']='';
        $paymentData['address2']='';
        $paymentData['city']='';
        $paymentData['state']='';
        $paymentData['country']='';
        $paymentData['zipcode']='';
        $paymentData['udf1']='';
        $paymentData['udf2']='';
        $paymentData['udf3']='';
        $paymentData['udf4']='';
        $paymentData['udf5']='';
        $paymentData['udf6']='';
        $paymentData['udf7']='';
        $paymentData['udf8']='';
        $paymentData['udf9']='';
        $paymentData['udf10']='';
        

        // $paymentData['pg']='';
        $hashSequence = 'key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10';

        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';  
        foreach($hashVarsSeq as $hash_var) {
            $hash_string .= isset($paymentData[$hash_var]) ? $paymentData[$hash_var] : '';
            $hash_string .= '|';
        }

        $hash_string .= $salt;

        $hash = strtolower(hash('sha512', $hash_string));
#dd($hash);

        $code = '<script>
                    var hash = "'.$hash.'";
                    function submitPayuForm() {
                        if(hash == "") {
                            return;
                        }
                        var payuForm = document.forms.payuForm;
                        payuForm.submit();
                    }
                </script>
                <form action="'.$url.'" method="post" name="payuForm"  >
                <input type="hidden" name="key" value="'.$paymentData['key'].'" />
                <input type="hidden" name="hash" value="'.$hash.'"/>
                <input type="hidden" name="txnid" value="'.$paymentData['txnid'].'" />
                <input type="hidden" name="amount" value="'.$paymentData['amount'].'" />
                <input type="hidden" name="firstname" value="'.$paymentData['firstname'].'" />
                <input type="hidden" name="email" value="'.$paymentData['email'].'" />
                <input type="hidden" name="phone" value="'.$paymentData['phone'].'" />
                <input type="hidden" name="surl" value="'.$paymentData['surl'].'" />
                <input type="hidden" name="furl" value="'.$paymentData['furl'].'" />
                <input type="hidden" name="service_provider" value="'.$paymentData['service_provider'].'" />
                <input type="hidden" name="productinfo" value="'. htmlspecialchars($paymentData['productinfo'], ENT_QUOTES, 'UTF-8').'" />

                </form>';
        echo $code;
        echo "<script>submitPayuForm();</script>";

    }


    public function status()
    {
        $response=Request()->all();
        // dd($response);

        $txStatus=$response['status'];
        // dd($txStatus);

        if ($response['status']==='success') {
            $payInfo = PayuPayment::where('order_id', $response['txnid'])->orderBy('id', 'desc')->first();
            // dd($payInfo);

            $payInfo->hash = $response['hash'];
            $payInfo->payment_mode = "payu";
            $payInfo->payment_id = $response['txnid'];
            $payInfo->status = $response['unmappedstatus'];
            $payInfo->payment_method = $response['field8'];
            $payInfo->customer_info = $response['field4'].'!'.$response['field6'];
            $payInfo->payment_method_id = $response['field3'];
            $payInfo->save();

            $data['payment_mode'] = "payu";
            $data['payment_id'] = $response['txnid'];
            // $data['payment_status'] = 1;
            // $data['payment_method'] = $response['field8'];
            // $data['customer_info'] = $response['field4'].'!'.$response['field6'];
            // $data['payment_method_id'] = $response['field3'];
            $data['ref_id'] =$payInfo->ref_id;
            $data['getway_id']='13';
            $data['amount'] =$response['amount'];
            $data['name'] =$payInfo->name;
            $data['email'] =$payInfo->email;
            $data['phone'] =$payInfo->phone;
            $data['gst_claim'] =$payInfo->gst_claim;
            $data['gst_business_name'] =$payInfo->gst_business_name;
            $data['gst_state'] =$payInfo->gst_state;
            $data['gst_number'] =$payInfo->gst_number;

            Session::put('payment_info', $data);

            return redirect($this->redirect_if_payment_success());
        }      
        else{
            $payInfo = PayuPayment::where('order_id', $response['txnid'])->orderBy('id', 'desc')->first();
            $payInfo->status = 'Failed';
            $payInfo->save();
            return redirect($this->redirect_if_payment_faild());
        }
    }

}