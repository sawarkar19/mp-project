<?php 

namespace App\Helper\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Illuminate\Support\Facades\Http;
use App\Models\Category;
use App\Models\BeforePayment;

class Instamojo 
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

    public static function fallback()
    {
        if (url('/') == env('APP_URL')) {
            return url('/business/instamojo');
        }
        else{
            return route('instamojo.fallback');
        }
    }

    public static function make_payment($array)
    {
        if (env('APP_DEBUG') == true) {
            $url='https://test.instamojo.com/api/1.1/payment-requests/';
        }
        else{
            $url='https://www.instamojo.com/api/1.1/payment-requests/';
        }
       

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

        $info=Category::where('type','payment_gateway')->with('credentials')->findorFail($getway_id);
        $credentials=json_decode($info->credentials->content ?? '');

        $params=[
            'purpose' => $billName,
            'amount' => $amount,
            'phone' => $phone,
            'buyer_name' => $name,
            'redirect_url' => Instamojo::fallback(),
            'send_email' => true,
            'send_sms' => true,
            'email' => $email,
            'allow_repeated_payments' => false
        ];
        $response=Http::asForm()->withHeaders([
            'X-Api-Key' => $credentials->x_api_Key,
            'X-Auth-Token' => $credentials->x_api_token
        ])->post($url,$params);

       
        $url= $response['payment_request']['longurl'];
        return redirect($url);
    }


    public function status()
    {
        $response=Request()->all();
        $payment_id=$response['payment_id'];
        
        if ($response['payment_status']=='Credit') {
            $data['payment_id'] = $payment_id;
            $data['payment_method'] = "instamojo";
            $order_info= Session::get('order_info');
            $data['ref_id'] =$order_info['ref_id'];
            $data['getway_id']=$order_info['getway_id'];
            $data['amount'] =$order_info['amount']; 
            $data['name'] =$order_info['name']; 
            $data['email'] =$order_info['email']; 
            $data['phone'] =$order_info['phone']; 
            $data['gst_claim'] =$order_info['gst_claim'];
            $data['gst_business_name'] =$order_info['gst_business_name'];
            $data['gst_state'] =$order_info['gst_state'];
            $data['gst_number'] =$order_info['gst_number'];

            Session::forget('order_info');
            Session::put('payment_info', $data);
            return redirect(Instamojo::redirect_if_payment_success());
        }      
        else{
            return redirect(Instamojo::redirect_if_payment_faild());
        }
    }
}