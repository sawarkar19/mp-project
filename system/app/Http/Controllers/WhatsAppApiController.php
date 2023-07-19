<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappLog;

class WhatsAppApiController extends Controller
{
    //

    public function headers(){

        $headers = [
            "Content-Type: application/json",
            "D360-Api-Key: yxkhOkK4eWTnkDobgPBuc7xdAK"
        ];

        return $headers;
    }

    // static function setWebhook(){

    //     $url = "https://waba.360dialog.io/v1/configs/webhook";
    //     $array = [
    //         "url"=> URL::to('/')
    //     ];
    //     $payload = json_encode($array);
    //     $headers = $this->headers();

    //     return $this->callWhatsAppApi($url, 'POST', $payload, $headers);
    // }

    /*static function CheckValidNumber($wpa_num){

        $url = "https://waba.360dialog.io/v1/contacts";
        $array = [
            "blocking" => "wait",
            "contacts" => [ $wpa_num ],
            "force_check" => true
        ];
        $payload = json_encode($array);
        $headers = [
            "Content-Type: application/json",
            "D360-Api-Key: yxkhOkK4eWTnkDobgPBuc7xdAK"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) { return $err; } else { return $response; }
    }
*/
    static function callWhatsAppApi($url, $method, $payload){

        $headers = [
            "Content-Type: application/json",
            "D360-Api-Key: yxkhOkK4eWTnkDobgPBuc7xdAK"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $log = new WhatsappLog;
            $log->api_url = $url;
            $log->method = $method;
            $log->is_error = '1';
            $log->response = $err;
            $log->save();

            return $log;
        } else {
            $res = json_decode($response);
            $is_error = '0';
            if(isset($res->meta->success)){ if($res->meta->success === false){ $is_error = '1'; } }
            if(isset($res->errors)){ $is_error = '1'; }
                
            $log = new WhatsappLog;
            $log->api_url = $url;
            $log->method = $method;
            $log->is_error = $is_error;
            $log->response = $response;
            $log->save();

            return $log;
        }
    }

    static function induadualReply($num, $message){

        $replyArray = [
            "recipient_type" => "individual",
            "to" => $num,
            "type" => "text",
            "text"=> [
                "body"=> $message
            ]
        ];

        $payload =  json_encode($replyArray);

        return $payload;

    }

    static function futureSubscriptionTemplate($img, $code, $num){

        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "future_subscription_opnl";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];

        $typeImage = [ "type"=> "image", "image"=> ["link"=> $img] ];
        $headerParm = [ $typeImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = [ "type"=> "text", "text"=> $code ];
        $buttonParm = [ $typeText ];
        $tempButton = [ "type"=> "button", "sub_type" => "url", "index"=> "0", "parameters"=> $buttonParm ];
        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempHeader, $tempButton ]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

    static function futureFirstClickTemplate($code, $num){

        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "future_first_click_opnl";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];
        $imageLink = asset("assets/whatsapp/first-click.jpg");

        $typeImage = [ "type"=> "image", "image"=> ["link"=> $imageLink] ];
        $headerParm = [ $typeImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = [ "type"=> "text", "text"=> $code ];
        $buttonParm = [ $typeText ];
        $tempButton = [ "type"=> "button", "sub_type" => "url", "index"=> "0", "parameters"=> $buttonParm ];
        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempHeader, $tempButton ]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

    static function futureOfferCompleteTemplate($var1, $var2, $code, $num){


        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "future_offer_complete_opnl";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];

        $imageLink = asset("assets/whatsapp/target-achieved.jpg");

        $bodyParm = [ ["type"=> "text", "text"=> '*'.$var1.'*'], ["type"=> "text", "text"=> '*'.$var2.'*' ] ];
        #$bodyParm = [ $bodyText ];
        $tempBody = [ "type"=> "body", "parameters"=> $bodyParm];

        $headerImage = [ "type"=> "image", "image"=> ["link"=> $imageLink] ];
        $headerParm = [ $headerImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = [ "type"=> "text", "text"=> $code ];
        $buttonParm = [ $typeText ];
        $tempButton = [ "type"=> "button", "sub_type" => "url", "index"=> "0", "parameters"=> $buttonParm ];
        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempBody, $tempHeader, $tempButton]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

    static function futureCashPerClickOfferCompleteTemplate($var1, $var2, $var3, $var4, $code, $num){


        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "future_cash_per_click_complete";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];

        $imageLink = asset("assets/whatsapp/target-achieved.jpg");

        $bodyParm = [ ["type"=> "text", "text"=> '*'.$var1.'*'], ["type"=> "text", "text"=> '*'.$var2.'*' ], ["type"=> "text", "text"=> '*'.$var3.'*' ], ["type"=> "text", "text"=> '*'.$var4.'*' ] ];
        #$bodyParm = [ $bodyText ];
        $tempBody = [ "type"=> "body", "parameters"=> $bodyParm];

        $headerImage = [ "type"=> "image", "image"=> ["link"=> $imageLink] ];
        $headerParm = [ $headerImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = [ "type"=> "text", "text"=> $code ];
        $buttonParm = [ $typeText ];
        $tempButton = [ "type"=> "button", "sub_type" => "url", "index"=> "0", "parameters"=> $buttonParm ];
        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempBody, $tempHeader, $tempButton]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

    static function instantSubscriptionTemplate($imageLink,$code, $num){

        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "instant_subscription_opnl";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];
        #$imageLink = asset("assets/front/images/Mobile-dashboard.png");

        $typeImage = [ "type"=> "image", "image"=> ["link"=> $imageLink] ];
        $headerParm = [ $typeImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = [ "type"=> "text", "text"=> $code ];
        $buttonParm = [ $typeText ];
        $tempButton = [ "type"=> "button", "sub_type" => "url", "index"=> "0", "parameters"=> $buttonParm ];
        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempHeader, $tempButton]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

    static function instantOfferCompleteTemplate($var1, $num){

        $namespace = "a78bcf2a_552d_4a23_9f25_d84b270671a4";
        $name = "instant_offer_complete_opnl";
        $language = [ "code"=> "en", "policy"=> "deterministic" ];

        $imageLink = asset("assets/whatsapp/task-completed.jpg");

        $bodyText = [ "type"=> "text", "text"=> '*'.$var1.'*' ];
        $bodyParm = [ $bodyText ];
        $tempBody = [ "type"=> "body", "parameters"=> $bodyParm ];

        $headerImage = [ "type"=> "image", "image"=> ["link"=> $imageLink] ];
        $headerParm = [ $headerImage ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $template = [
            "namespace" => $namespace,
            "name" => $name,
            "language" => $language,
            "components" => [ $tempBody, $tempHeader]
        ];
        $templateArray = [
            "to" => $num,
            "type" => "template",
            "template" => $template,
        ];

        $payload =  json_encode($templateArray);

        return $payload;
    }

}