<?php

namespace App\Http\Controllers;

use App\Models\WhatsappSession;
use Illuminate\Http\Request;
use App\Models\WpMessage;
use App\Models\User;
use App\Models\Option;

use Carbon\Carbon;

class CommonMessageController extends Controller
{
    //

    public function __construct()
    {
           // 
    }

    static function openLink(){

        $openLink = User::where('id', config('constants.ol_id'))->first();

        $access_token = $openLink->wa_access_token;
        $instance = WhatsappSession::where('user_id', config('constants.ol_id'))->orderBy('id', 'desc')->first();
        // dd($instance);

        $instance_id = $instance->instance_id;

        $array = [
            'access_token' => $access_token,
            'instance_id' => $instance_id
        ];
        return $array;
    }

    static function sendOtpMsg($wa_num, $otp){

        $openLink = User::where('id', config('constants.ol_id'))->first();
        $instance = WhatsappSession::where('user_id', config('constants.ol_id'))->orderBy('id', 'desc')->first();

        $wa_msg = "*Dear Sir/Madam*,\n\n*".$otp."* is your OpenLink account verification code.\n\n_If you did not perform this request,_\n_you can safely ignore this message._\n\n_*OpenLink* Powered By Logic Innovates_";

        $postDataArray = [
            'number' => $wa_num,
            'type' => 'text',
            'message' => $wa_msg,
            'instance_id' => $instance->instance_id,
            'access_token' => $openLink->wa_access_token
        ];
     
        $data = http_build_query($postDataArray);
        $ch = curl_init();

        $wa_url=Option::where('key','oddek_url')->first();
        $url=$wa_url->value."/api/send.php";
      
        $getUrl = $url."?".$data;
      
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
           
        $response = curl_exec($ch);
        $err = curl_error($ch);

        if ($err) {

            return $err;

        } else {

            $wp_message = new WpMessage;
            $wp_message->user_id = config('constants.ol_id');
            $wp_message->status = 1;
            $wp_message->save();

            return $response; 
        }
    }

    static function sendMessage($num, $msg){

        $openLink = User::where('id', config('constants.ol_id'))->first();

        // dd($openLink);
        $access_token = $openLink->wa_access_token;
        $instance = WhatsappSession::where('user_id', config('constants.ol_id'))->orderBy('id', 'desc')->first();
        $instance_id = $instance->instance_id;

        $openlink = [
            'access_token' => $access_token,
            'instance' => $instance,
            'instance_id' => $instance_id
        ];
        // return $array;

        // $openlink = $this->openLink();
        if($openlink['access_token'] == null){
            return response()->json(["success" => false, "message" => "WhatsApp Access Token not found."]);
        }

        if($openlink['instance'] != null && isset($openlink['instance_id'])){
            //API call to check whatsapp status                       
            $postData = array(
                'instance_id' => $openlink['instance_id']
            );
            $data = json_encode($postData);
            
            //API URL
            $wa_url=Option::where('key','oddek_url')->first();
            $url=$wa_url->value."/api/checkAccountStatus.php";

            //init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $data
                //,CURLOPT_FOLLOWLOCATION => true
            ));

            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            //Get response
            $responseData = curl_exec($ch);
            $output = json_decode($responseData);
            curl_close($ch);

            if($output->status == "1"){
                $postDataArray = [
                    'number' => $num,
                    'type' => 'text',
                    'message' => $msg,
                    'instance_id' => $openlink['instance_id'],
                    'access_token' => $openlink['access_token']
                ];
             
                $data = http_build_query($postDataArray);
                $ch = curl_init();
          
                $wa_url=Option::where('key','oddek_url')->first();
                $url=$wa_url->value."/api/send.php";
              
                $getUrl = $url."?".$data;
              
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_TIMEOUT, 80);
                   
                $response = curl_exec($ch);
                $err = curl_error($ch);

                if ($err) {

                    return $err;

                } else {

                    $wp_message = new WpMessage;
                    $wp_message->user_id = config('constants.ol_id');
                    $wp_message->status = 1;
                    $wp_message->save();

                    return $response; 
                }
            }else{
                WhatsappSession::destroy($openLink->id);
                return response()->json(["success" => false, "message" => "WhatsApp Login Required."]);
            }

        }else{
            return response()->json(["success" => false, "message" => "WhatsApp Login Required."]);
        }
    }

    static function welcomeWpMessage($name){

        $login = route('login');
        $features = route('features');

        $msg = "*Hello, ".$name."!*\n*Welcome to OpenLink & Thanks for signing up!.*\n\nWe are very happy to have you with us. 🥳\n\nGo To Your Account\n".$login."\n\nOpenLink has been developed as the premier application to boost your brand reach by your existing customers and provide them with structured benefits for growing your social media presence and referring your business to their network. Here is a little more information about who we are, and a few links about our story and success cases. 😊\n\n*Features link*\n".$features."\n\nWe hope you find in our business what you are looking for.🙂\n\n_If you did not perform this request,_\n_you can safely ignore this message._\n\n_*OpenLink* Powered By Logic Innovates_";

        $msg = "*Hello, ".$name."!*\n*Welcome to OpenLink & Thanks for signing up!.*\n\nWe are very happy to have you with us. 🥳\n\nGo To Your Account\n".$login."\n\nOpenLink has been developed as the premier application to boost your brand reach by your existing customers and provide them with structured benefits for growing your social media presence and referring your business to their network. Here is a little more information about who we are, and a few links about our story and success cases. 😊\n\n*Features link*\n".$features."\n\nWe hope you find in our business what you are looking for.🙂\n\n_*OpenLink* Powered By Logic Innovates_";

        return $msg;

    }

    static function firstSubscriptionWpMessage($data){

        $date = Carbon::parse($data['plan_date'])->format('d M, Y g:i A');
        $price = round($data['plan_without_gst'],2);
        $gst = round($data['plan_gst'],2);
        $total = round($data['plan_price'],2);

        $msg = "*Subscription Successful!* 🥳\nCongratulations 😊 *".$data['name']."*,\n\nYou have successfully purchased the ".$data['plan_name']." Subscription plan.\n_Below is your payment detail._\n\n*Date*: ".$date."\n*Plan*: ".$data['plan_name']." Plan\n*Price*: ₹ ".$price."\n*Gst*: ₹ ".$gst."\n___________________________________\n*Total*: ₹ ".$total."\n\n\n\n😕 _If you have any query! Feel free to connect us. We are available from Monday to Friday between 10 AM to 7 PM._\n📞 _Call us on_ *07887882244*\n✉️ _Or you can mail us at_ *care@openlink.co.in*\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $msg;
    }

    static function updateSubscriptionWpMessage($data){

        $date = Carbon::parse($data['plan_date'])->format('d M, Y g:i A');
        $price = round($data['plan_without_gst'],2);
        $gst = round($data['plan_gst'],2);
        $total = round($data['plan_price'],2);

        $msg = "*Subscription Successful!* 🥳\nCongratulations 😊 *".$data['name']."*,\n\nYou have successfully purchased the ".$data['plan_name']." Subscription plan.\n_Below is your payment detail._\n\n*Date*: ".$date."\n*Plan*: ".$data['plan_name']." Plan\n*Price*: ₹ ".$price."\n*Gst*: ₹ ".$gst."\n___________________________________\n*Total*: ₹ ".$total."\n\n\n\n😕 _If you have any query! Feel free to connect us. We are available from Monday to Friday between 10 AM to 7 PM._\n📞 _Call us on_ *07887882244*\n✉️ _Or you can mail us at_ *care@openlink.co.in*\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $msg;
    }

    static function forgetPasswordWpMessage($name, $code){

        $link = 'https://opnl.in/'.$code;
        $msg = "*Hello, ".$name."!*\nYou are receiving this message because we received a password reset request for your account.\n\nClick the link below to complete the process.\n\n*Reset Password Link*\n".$link."\n\n_If you did not perform this request,_\n_you can safely ignore this message._\n\n_*OpenLink* Powered By Logic Innovates_";

        return $msg;
    }

    // static function welcomeWpMessage(){
        
    // }


    static function offersExpiredMessage($days,$name){
        
        if($days==0){
            $msg = "Hey $name,\n\nThe offer you have created has expired today. Make your next offer now since your customer must be waiting for a good deal and keep growing your brand reach every day.\n\nWhat are you waiting for, create your next offer now!\n\nThank you.";
            
        }else if($days==10){
            $msg = "Hey $name,\n\nWhat are you waiting for? Your customers are waiting for your next offer. Your previous offer has expired just days before days.\n\nStart creating your next offer now and boost your brand growth.\n\nThank you.";
            
        }else if($days==20){
            $msg = "Hey $name,\n\nWhy no offers? It's a good time to offer your customers some surprising benefits and make them your brand ambassador. It's been long 20 days since your offer have been expired. Create the new offer now.\n\nThank you.";
            
        }else if($days==30){
            $msg = "Hey $name,\n\nIt's been a long time, you haven't created any offer. Your previous offer has expired 30 days before. It's a very long time. Your customer must be missing your brad's amazing offers. Make them happy by creating a new offer now.\n\nThank you.";
            
        }
        return $msg;
    }
    
    static function subscriptionExpiredMessage($days,$name,$planTitle){

        $msg = "Hey $name,\n\nIt's time to renew your subscription! Your OPENLINK ";
        
        $i=0;
        foreach($planTitle as $plan){

            $days = $plan['expireDays'];
            $title = $plan['title'];
            
            if( strpos($title, 'OpenLink') !== false ) {
                $title = str_replace('OpenLink','',$title);
            }
            
            if((count($planTitle) == ($i+1)) && ($i>0)){
                $msg .= " and ";
            }else if(count($planTitle)==2 && ($i>0)){
                $msg .= " and ";
            }else if($i>0){
                $msg .= ", ";
            }
            
            if($plan['expireDays']==0){
                $msg .= " $title plan has been expired today";
            }else if($days==15 || $days==30){
                $msg .= " $title plan has been expired $days days before";
            }else if($days==1){
                $msg .= " $title plan will be expired tomorrow";
            }else if($days==3 || $days==5){
                $msg .= " $title plan ends in $days days";
            }
            $i++;
        }
        
        $msg .= ". Please update your payment information now. Click to renew your service.\n\nHave a good day\nWe want to be with you again!\n\nClick here now to renew your plan and boost your business growth with your own customer.\n";
        return $msg;
    }
}
