<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WhatsappSession;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Option;

use Auth;

class WhatsAppMsgController extends Controller
{
    //
    public static function sendTextMessageWP($num, $msg, $user_id = null){

        if($user_id == null){
            $user_id = Auth::id();
        }

        $user = WhatsappSession::where('user_id', $user_id)->orderBy('id', 'desc')->first();

        $userData = User::where('id', $user_id)->orderBy('id', 'desc')->first();

        if($userData != null && $userData->wa_access_token == null){
            return response()->json(["success" => false, "message" => "WhatsApp Access Token not found."]);
        }

        if($user != null && isset($user->instance_id) && $user->instance_id != ''){
            //API call to check whatsapp status                       
            $postData = array(
                'instance_id' => $user->instance_id
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
#dd($user->instance_id);
            if($output->status == "1"){
                $postDataArray = [
                    'number' => $num,
                    'type' => 'text',
                    'message' => $msg,
                    'instance_id' => $user->instance_id,
                    'access_token' => $userData->wa_access_token
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
                    return $response; 
                }
            }else{
                $whatsapp_session = WhatsappSession::findorFail($user->id);
                $whatsapp_session->instance_id = '';
                $whatsapp_session->status = 'lost';
                $whatsapp_session->save();
                
                return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
            }

        }else{
            return response()->json(["success" => false, "message" => "Your business account is not linked to Whatsapp."]);
        }

    }


    public static function cashPerClickSubscription($code){

        $msg = "*Hey! Here comes your link* 🥳\n\nHere for your *cash per click offer* benefit and share in it your network to enjoy the offer benefit on your next purchase. 👇\n\nhttps://opnl.in/".$code."\n\n*Note:*\n_Kindly reply to this message with *Hi*_\nor\n_*Add to Contact* to make the above link clickable._\n\nIgnore if already done.\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $msg;

    }

    static function fixedAmountSubscription($code){

        $payload = "*Hey! Here comes your link* 🥳\n\nHere for your *fixed amount offer* benefit and share in it your network to enjoy the offer benefit on your next purchase.\n\nClick here to share 👇\n\n\nhttps://opnl.in/".$code."\n\n*Note:*\n_Kindly reply to this message with *Hi*_\nor\n_*Add to Contact* to make the above link clickable._\n\nIgnore if already done.\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $payload;
    }

    static function percentageDiscountSubscription($code){

        $payload = "*Hey! Here comes your link* 🥳\n\nHere for your *percentage discount offer* benefit and share in it your network to enjoy the offer benefit on your next purchase.\n\nClick here to share 👇\n\n\nhttps://opnl.in/".$code."\n\n*Note:*\n_Kindly reply to this message with *Hi*_\nor\n_*Add to Contact* to make the above link clickable._\n\nIgnore if already done.\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $payload;
    }

    static function MadeShareSubscription($code){

        $payload = "*Hey! Here comes your link* 🥳\n\nThis is your make & share post. 😀\nOpen this link and easily share it with your network. You can track all unique clicks & extra clicks from your personal dashboard.\nSo what you are waiting for! 🙂\n\n*Click on this link* 👇\nhttps://opnl.in/".$code."\n\n*Note:*\n_Kindly reply to this message with *Hi*_\nor\n_*Add to Contact* to make the above link clickable._\n\nIgnore if already done.\n\n\n_*OpenLink* Powered By Logic Innovates_";

        return $payload;
    }

    static function futureFirstClickMsg($code){

        $payload = "*It's all almost done, you are doing great share!.* 😀\n\n\nClick here to quickly have a look at your shared link.\n\n\nComplete your target and come soon to claim your offer.\n\nTrack your shared link on your own, know how many clicks you got form where you share. 👇\n\n\nhttps://opnl.in/".$code;

        return $payload;
    }

    static function cashPerClickCompleteMsg($var1, $var2, $var3, $var4, $code){


        $payload = "*Hey, it's time to celebrate and take a walk for your next purchase.* 🥳\n\n\nYou have completed *".$var1."* clicks.\nPer click amount is *".$var2."* ₹.\n\n\nYour redeem amount is *".$var1."* x *".$var2."* = *".$var3."* ₹.\n\n\nWhat else are you waiting for?\n\nCome and claim your offer with your secret coupon code *".$var4."*.\n\nClick here to track your clicks 👇\n\nhttps://opnl.in/".$code;


        return $payload;
    }

    static function fixedAmountCompleteMsg($var1, $var2, $code){


        $payload = "*Hey, it's time to celebrate and take a walk for your next purchase.* 🥳\n\n\nYou have completed your target of *".$var1."* clicks.\n\n\nWhat else are you waiting for?\n\nCome and claim your offer with your secret coupon code *".$var2."*\n\n\nhttps://opnl.in/".$code;

        return $payload;
    }

    static function percentageDiscountCompleteMsg($var1, $var2, $code){


        $payload = "*Hey, it's time to celebrate and take a walk for your next purchase.* 🥳\n\n\nYou have completed your target of *".$var1."* clicks.\n\n\nWhat else are you waiting for?\n\nCome and claim your offer with your secret coupon code *".$var2."*\n\n\nhttps://opnl.in/".$code;

        return $payload;
    }

    static function instantSubscriptionTemplate($code){


        $payload = "*Hey! We are happy you instantly decided to avail the offer benefit!* 😀\n\n\n😀 Click here, complete your task, and claim your offer. ENJOY! 👇\n\n\n\nhttps://opnl.in/".$code;

        return $payload;

    }
    
    static function instantOfferCompleteTemplate($var1){

        $payload = "Wow, that was too instant!!* 🥳\n\n\nCongratulation you have completed your task. \n\n\nShare the coupon code *".$var1."* & enjoy the offer benefit instantly on your recent purchase !! ENJOY 😀🥳";

        return $payload;
    }


    static function afterRedeemedMsg($type, $name, $msg, $var1, $var2, $var3, $var4){

        if($type == "Percentage"){
            $payload = "*Hey, Offer redeemed successfully.* 🥳\n\n\nPayment Summary\n===============\n\nInvoice total amount = *".$var1." ₹.*\nDiscount Percentage (".$var2."%) = *".number_format((float)$var3, 2, '.', '')." ₹.*\nYour payable amount = *".$var4." ₹.*\n\n\n*".$name."*\n".$msg;
        }else if($type == "Fixed"){
            $payload = "*Hey, Offer redeemed successfully.* 🥳\n\n\nPayment Summary\n===============\n\nInvoice total amount = *".$var1." ₹.*\nDiscount Amount (".$var2." ₹) = *".number_format((float)$var3, 2, '.', '')." ₹.*\nYour payable amount = *".$var4." ₹.*\n\n\n*".$name."*\n".$msg;
        }else if($type == "Perclick" || $type == "PerClick"){
            $payload = "*Hey, Offer redeemed successfully.* 🥳\n\n\nPayment Summary\n===============\n\nInvoice total amount = *".$var1." ₹.*\nPer Click Discount (".$var2." ₹) = *".number_format((float)$var3, 2, '.', '')." ₹.*\nYour payable amount = *".$var4." ₹.*\n\n\n*".$name."*\n".$msg;
        }

        return $payload;
    }
}