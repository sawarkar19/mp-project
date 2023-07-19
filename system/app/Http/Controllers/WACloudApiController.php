<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappLog;

class WACloudApiController extends Controller
{
    //

    public function headers()
    {
        $headers = ['Content-Type: application/json', 'D360-Api-Key: yxkhOkK4eWTnkDobgPBuc7xdAK'];

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
    static function callWhatsAppApi($url, $method, $payload)
    {
        $headers = ['Content-Type: application/json', 'D360-Api-Key: yxkhOkK4eWTnkDobgPBuc7xdAK'];

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
            $log = new WhatsappLog();
            $log->api_url = $url;
            $log->method = $method;
            $log->is_error = '1';
            $log->response = $err;
            $log->save();

            return $log;
        } else {
            $res = json_decode($response);
            $is_error = '0';
            if (isset($res->meta->success)) {
                if ($res->meta->success === false) {
                    $is_error = '1';
                }
            }
            if (isset($res->errors)) {
                $is_error = '1';
            }

            $log = new WhatsappLog();
            $log->api_url = $url;
            $log->method = $method;
            $log->is_error = $is_error;
            $log->response = $response;
            $log->save();

            return $log;
        }
    }

    static function induadualReply($num, $message)
    {
        $replyArray = [
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'text',
            'text' => [
                'body' => $message,
            ],
        ];

        $payload = json_encode($replyArray);

        return $payload;
    }

    static function futureSubscriptionTemplate($img, $code, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'future_subscription_opnl';
        $language = ['code' => 'en', 'policy' => 'deterministic'];

        $typeImage = ['type' => 'image', 'image' => ['link' => $img]];
        $headerParm = [$typeImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempHeader, $tempButton],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function futureFirstClickTemplate($code, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'future_first_click_opnl';
        $language = ['code' => 'en', 'policy' => 'deterministic'];
        $imageLink = asset('assets/whatsapp/first-click.jpg');

        $typeImage = ['type' => 'image', 'image' => ['link' => $imageLink]];
        $headerParm = [$typeImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempHeader, $tempButton],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function futureOfferCompleteTemplate($var1, $var2, $code, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'future_offer_complete_opnl';
        $language = ['code' => 'en', 'policy' => 'deterministic'];

        $imageLink = asset('assets/whatsapp/target-achieved.jpg');

        $bodyParm = [['type' => 'text', 'text' => '*' . $var1 . '*'], ['type' => 'text', 'text' => '*' . $var2 . '*']];
        #$bodyParm = [ $bodyText ];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $headerImage = ['type' => 'image', 'image' => ['link' => $imageLink]];
        $headerParm = [$headerImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempBody, $tempHeader, $tempButton],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function futureCashPerClickOfferCompleteTemplate($var1, $var2, $var3, $var4, $code, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'future_cash_per_click_complete';
        $language = ['code' => 'en', 'policy' => 'deterministic'];

        $imageLink = asset('assets/whatsapp/target-achieved.jpg');

        $bodyParm = [['type' => 'text', 'text' => '*' . $var1 . '*'], ['type' => 'text', 'text' => '*' . $var2 . '*'], ['type' => 'text', 'text' => '*' . $var3 . '*'], ['type' => 'text', 'text' => '*' . $var4 . '*']];
        #$bodyParm = [ $bodyText ];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $headerImage = ['type' => 'image', 'image' => ['link' => $imageLink]];
        $headerParm = [$headerImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempBody, $tempHeader, $tempButton],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function instantSubscriptionTemplate($imageLink, $code, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'instant_subscription_opnl';
        $language = ['code' => 'en', 'policy' => 'deterministic'];
        #$imageLink = asset("assets/front/images/Mobile-dashboard.png");

        $typeImage = ['type' => 'image', 'image' => ['link' => $imageLink]];
        $headerParm = [$typeImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempHeader, $tempButton],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function instantOfferCompleteTemplate($var1, $num)
    {
        $namespace = 'a78bcf2a_552d_4a23_9f25_d84b270671a4';
        $name = 'instant_offer_complete_opnl';
        $language = ['code' => 'en', 'policy' => 'deterministic'];

        $imageLink = asset('assets/whatsapp/task-completed.jpg');

        $bodyText = ['type' => 'text', 'text' => '*' . $var1 . '*'];
        $bodyParm = [$bodyText];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $headerImage = ['type' => 'image', 'image' => ['link' => $imageLink]];
        $headerParm = [$headerImage];
        $tempHeader = ['type' => 'header', 'parameters' => $headerParm];

        $template = [
            'namespace' => $namespace,
            'name' => $name,
            'language' => $language,
            'components' => [$tempBody, $tempHeader],
        ];
        $templateArray = [
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }

    static function sendMsg($payload)
    {
        $url = 'https://graph.facebook.com/v15.0/116968637992567/messages';
        $headers = ['Authorization: Bearer EABJxPZAmTeKYBAHYKK6sAtJe7CgP1WnZACK7IHDQMNbXrtgjIci7GLYgv2nkx7BApaTsoJZAzn1pdAVW1WaWUBfSS2Srl0AVteb01CVKlA6PB7EZAWpDk1hwKJaSTB3gywM92BNRLn8cRZBXHT0BjwSmjAolSi2T8ToPzCO6x7he0DZATONwJy', 'Content-Type: application/json'];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return $err;
        } else {
            return $response;
        }
    }

    static function welcomeMsg($num, $customer)
    {
        $language = ['code' => 'en_US'];
        $bodyParm = ['type' => 'text', 'text' => $customer];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];
        $template = [
            'name' => 'welcome',
            'language' => $language,
            'components' => [$tempBody],
        ];
        $templateArray = [
            'messaging_product' => 'whatsapp',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];
        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }

    static function mp_fr_welcome_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_fr_welcome_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }

    static function subscriptionMsg($num, $customer, $v1, $v2, $v3, $v4, $v5, $v6)
    {
        $language = ['code' => 'en_US'];
        $bodyParm = [['type' => 'text', 'text' => $customer], ['type' => 'text', 'text' => $v1], ['type' => 'text', 'text' => $v2], ['type' => 'text', 'text' => $v3], ['type' => 'text', 'text' => $v4], ['type' => 'text', 'text' => $v5], ['type' => 'text', 'text' => $v6]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $template = [
            'name' => 'subscrption',
            'language' => $language,
            'components' => [/*$tempHeader,*/ $tempBody],
        ];
        $templateArray = [
            'messaging_product' => 'whatsapp',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];
        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }

    static function mp_sendotp($num, $otp)
    {
        $language = ['code' => 'en_Us'];
        $bodyParm = ['type' => 'text', 'text' => $otp];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];
        $template = [
            'name' => 'mp_sendotp',
            'language' => $language,
            'components' => [$tempBody],
        ];
        $templateArray = [
            'messaging_product' => 'whatsapp',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];
        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }

    static function forgotPasswordMsg($num, $customer, $v1)
    {
        $language = ['code' => 'en_US'];
        $bodyParm = [['type' => 'text', 'text' => $customer], ['type' => 'text', 'text' => $v1]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];
        $template = [
            'name' => 'forgotpassword',
            'language' => $language,
            'components' => [$tempBody],
        ];
        $templateArray = [
            'messaging_product' => 'whatsapp',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];
        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }

    //-----openchallenge new payment alert start-----//
    static function mp_new_registration($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_new_registration',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge new payment alert end-----//

    //-----openchallenge payment alert start-----//
    static function mp_payment_alert1($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_payment_alert1',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge payment alert end-----//

    //-----openchallenge contact us alert start-----//
    static function mp_contact_us_alert($num, $name)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $name]];

        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $template = [
            'name' => 'mp_contact_us_alert',
            'language' => $language,
            'components' => [$tempBody],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  contact us  alert end-----//

    //-----openchallenge sub payment alert start-----//
    static function mp_sub_payment_alert2($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $headerText = [ "type"=> "text", "text"=> $var4 ];
        $headerParm = [ $headerText ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];


        $template = [
            'name' => 'mp_sub_payment_alert2',
            'language' => $language,
            'components' => [$tempHeader, $tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment alert end-----//

    //-----openchallenge sub upgrade user alert start-----//
    static function mp_sub_upgrade_usr($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_upgrade_usr',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub upgrade user alert end-----//

    //-----openchallenge sub upgrade channel user alert start-----//
    static function mp_sub_upgrade_ch_usr($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7], ['type' => 'text', 'text' => $var8]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_upgrade_ch_usr',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub upgrade channel user alert end-----//

    //-----openchallenge sub payment recharge alert start-----//
    static function mp_sub_payment_rch($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_payment_rch',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment recharge alert end-----//

    //-----openchallenge sub payment user alert start-----//
    static function mp_sub_payment_usr($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_payment_usr',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment user alert end-----//

    //-----openchallenge sub payment user recharege alert start-----//
    static function mp_sub_payment_usr_rch($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_payment_usr_rch',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment user recharege alert end-----//

    //-----openchallenge sub payment channel user alert start-----//
    static function mp_sub_payment_ch_usr($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7], ['type' => 'text', 'text' => $var8]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_payment_ch_usr',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment alert end-----//

    //-----openchallenge sub payment channel user recharge alert start-----//
    static function mp_sub_payment_ch_usr_rch($num, $var1, $var2, $var3, $var4, $var5, $var6, $var7, $var8, $var9, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6], ['type' => 'text', 'text' => $var7], ['type' => 'text', 'text' => $var8], ['type' => 'text', 'text' => $var9]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_payment_ch_usr_rch',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //-----openchallenge sub payment channel user recharge alert end-----//

    //-----openchallenge today expire alert start-----//
    static function mp_today_expire_alert($num, $name, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $name]];

        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_today_expire_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  today expire  alert end-----//

    //-----openchallenge will 753 expire alert start-----//
    static function mp_will_753_expire_alert($num, $name, $day, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $name]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $headerText = [ "type"=> "text", "text"=> $day ];
        $headerParm = [ $headerText ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $template = [
            'name' => 'mp_will_753_expire_alert',
            'language' => $language,
            'components' => [$tempHeader, $tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  will 753 expire  alert end-----//

    //*openchallenge offer expire soon start*//
    static function mp_offer_expire_soon($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_offer_expire_soon',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge offer expire soon end*//

    //*openchallenge will canceled alert start*//
    static function mp_pm_will_canceled_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_pm_will_canceled_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge will canceled alert end*//

    //*openchallenge message credit 0 start*//
    static function mp_no_account_credits($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_no_account_credits',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge message credit 0 end*//

    //*openchallenge dont created offer start*//
    static function mp_dont_created_offer($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_dont_created_offer',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge dont created offer end*//

    //*openchallenge scheduled canceled*//
    static function mp_scheduled_canceled($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_scheduled_canceled',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge scheduled canceled end*//

    //*openchallenge dont posted offer start*//
    static function mp_dont_posted_offer($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_dont_posted_offer',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge dont posted offer end*//

    //*openchallenge dont posted offer start*//
    static function mp_offer_not_shared($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_offer_not_shared',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge dont posted offer end*//

    //*openchallenge low message start*//
    static function mp_low_messages($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_low_messages',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge low message end*//

    //*openchallenge low message start*//
    static function mp_you_have_consumed_credits($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_you_have_consumed_credits',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge low message end*//


    //*openchallenge low message start*//
    static function mp_your_scheduled_event_cancelled($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_your_scheduled_event_cancelled',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge low message end*//

    //*openchallenge low message start*//
    static function mp_account_credits_are_low1($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_account_credits_are_low1',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge low message end*//

    //*openchallenge offer expired alert start*//
    static function mp_sub_expired_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_sub_expired_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge offer expired alert end*//

    //*openchallenge paid welcome start*//
    static function mp_paidwelcome_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_paidwelcome_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge paid welcome alert end*//

    //*openchallenge forget password start*//
    static function mp_forgot_password($num, $name, $code)
    {

        $language = ['code' => 'en_Us'];

        $headerText = [ "type"=> "text", "text"=> $name ];
        $headerParm = [ $headerText ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_forgot_password',
            'language' => $language,
            'components' => [$tempHeader, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //*openchallenge forget password end*//


    //*openchallenge generate password start*//
    static function mp_genrate_password($num, $name, $code)
    {
        $language = ['code' => 'en_Us'];

        $headerText = [ "type"=> "text", "text"=> $name ];
        $headerParm = [ $headerText ];
        $tempHeader = [ "type"=> "header", "parameters"=> $headerParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_genrate_password',
            'language' => $language,
            'components' => [$tempHeader, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //*openchallenge generate password end*//

    //-----openchallenge contact us alert start-----//
    static function mp_makeshare($num, $name, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $name]];

        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $template = [
            'name' => 'mp_makeshare',
            'language' => $language,
            'components' => [$tempBody],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  contact us  alert end-----//

    //-----openchallenge whatsapp disconnected start-----//
    static function mp_wa_disconnected($num, $code)
    {
        $language = ['code' => 'en_Us'];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_wa_disconnected',
            'language' => $language,
            'components' => [$tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  whatsapp disconnected end-----//

    //*openchallenge offer not shared start*//
    static function mp_offer_notshared_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_offer_notshared_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge offer not shared end*//

    //*openchallenge auto share offer not sent start*//
    static function mp_auto_sr_offer_notsent($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_auto_sr_offer_notsent',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge  auto share offer not sent  end*//

        //*openchallenge auto share offer not sent start*//
        static function mp_personalised_message_alert($num, $name, $code)
        {
            $language = ['code' => 'en_US'];
    
            $bodyParm = ['type' => 'text', 'text' => $name];
            $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];
    
            $typeText = ['type' => 'text', 'text' => $code];
            $buttonParm = [$typeText];
            $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];
    
            $template = [
                'name' => 'mp_personalised_message_alert',
                'language' => $language,
                'components' => [$tempBody, $tempButton],
            ];
    
            $templateArray = [
                'messaging_product' => 'whatsapp',
                'recipient_type' => 'individual',
                'to' => $num,
                'type' => 'template',
                'template' => $template,
            ];
    
            $payload = json_encode($templateArray);
            // dd($payload);
            return $payload;
        }
        //*openchallenge  auto share offer not sent  end*//

    //*openchallenge daily reports alert start*//
    static function mp_daily_reports_alert($num, $var1, $var2, $var3, $var4, $var5, $var6, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $var1], ['type' => 'text', 'text' => $var2], ['type' => 'text', 'text' => $var3], ['type' => 'text', 'text' => $var4], ['type' => 'text', 'text' => $var5], ['type' => 'text', 'text' => $var6]];
        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_daily_reports_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    //*openchallenge daily reports alert end*//

    //-----openchallenge will 1 expire alert start-----//
    static function mp_will_1_expire_alert($num, $name, $code)
    {
        $language = ['code' => 'en_Us'];

        $bodyParm = [['type' => 'text', 'text' => $name]];

        $tempBody = ['type' => 'body', 'parameters' => $bodyParm];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_will_1_expire_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    //-----openchallenge  will 1 expire alert end-----//

    /*openchallenge DOB will canceled alert start*/
    static function mp_dob_will_canceled_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_dob_will_canceled_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);

        return $payload;
    }
    /*openchallenge DOB will canceled alert end*/

    /*openchallenge anny will canceled alert start*/
    static function mp_anny_will_canceled_alert($num, $name, $code)
    {
        $language = ['code' => 'en_US'];

        $bodyParm = ['type' => 'text', 'text' => $name];
        $tempBody = ['type' => 'body', 'parameters' => [$bodyParm]];

        $typeText = ['type' => 'text', 'text' => $code];
        $buttonParm = [$typeText];
        $tempButton = ['type' => 'button', 'sub_type' => 'url', 'index' => '0', 'parameters' => $buttonParm];

        $template = [
            'name' => 'mp_anny_will_canceled_alert',
            'language' => $language,
            'components' => [$tempBody, $tempButton],
        ];

        $templateArray = [
            'messaging_product' => 'whatsapp',
            'recipient_type' => 'individual',
            'to' => $num,
            'type' => 'template',
            'template' => $template,
        ];

        $payload = json_encode($templateArray);
        // dd($payload);
        return $payload;
    }
    /*openchallenge anny will canceled alert end*/
}










