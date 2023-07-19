<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonSmsTempContoller extends Controller
{
    
    private $username;
    private $password;
    private $sendername;
    private $routetype;
    private $url;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->username = 'openlink';
        $this->password = 'KHdZFvJrMQDT';
        $this->sendername = 'OPNLNK';

        // $this->username = 'dukandary';
        // $this->password = 's7i9haY';
        // $this->sendername = 'LOGLRT';

        $this->routetype = "1";
        $this->url="http://logic.bizsms.in/SMS_API/sendsms.php";

    }

    public function otp(){

        $otp = rand(100000, 999999);
        return $otp;

    }

    public function fCodeTemplate($code){

        $message = "Yay!!\nCongrats you have achieved your target.\nVisit us to redeem, your coupon code is ".$code;
        return $message;

    }

    public function nCodeTemplate($code){

        $text = "discount";
        $message = "Hooray!!\nYou have completed your task.\nGet the ".$text." by sharing coupon code ".$code;
        return $message;

    }

    public function otpTemplate(){

        $message = $this->otp()." is your OpenLink account verification code.";
        return $message;

    }

    public function welcomeTemplate($name, $code){

        $message = "Welcome aboard ".$name."!\nThanks for creating an account.\nYou can access it here any time.\nhttps://opnl.in/".$code;
        return $message;

    }

    public function subscribeTemplate($code){

        $message = "Hi there!\nYour subscription has been activated for OPENLINK.\nGet started now https://opnl.in/".$code;
        return $message;

    }

    public function SocialPostTemplate($name, $code){

        $message = "Hi ".$name."!\nPlease create your new social post now before the trend ends.\nhttps://opnl.in/".$code;
        return $message;

    }

    public function offerStartTemplate($code){

        $message = "Yippee!! Your Offer is live now.\nLet's see how well it's doing now.\nhttps://opnl.in/".$code;
        return $message;

    }

    public function offerExpireTemplate($name, $code){

        $message = "Hi ".$name."!\nYour Offer is expiring today.\nTime to create new one now.\nhttps://opnl.in/".$code;
        return $message;

    }

    public function noOfferTemplate($name, $code){

        $message = "Hi ".$name."!\nYou have no Offer scheduled.\nPlease click here to create new offer.\nhttps://opnl.in/".$code;
        return $message;

    }

    public function subscribeExpireTemplate($name, $code){

        $message = "Hi ".$name."!\nYour channels subscription is expiring today.\nRenew your subscription now.\nhttps://opnl.in/".$code;
        return $message;


    }

    public function subscribe15ExpireTemplate($name, $code){

        $message = "Hi ".$name."!\nYour subscription has been expired before 15 days. RENEW IT NOW!\nhttps://opnl.in/".$code;
        return $message;

    }

    public function sendSMS($number, $message){

        $postData = array(
            'username' => $this->username,
            'password' => $this->password,
            'mobile' => $number,
            'sendername' => $this->sendername,
            'message' => $message,
            'routetype' => $this->routetype
        );

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $output = curl_exec($ch);

        //Print error if any
        if(curl_errno($ch)) {
            return ['status'=> false, "message"=> "Something went wrong!"];
        }else{
            $array = explode(';', $output);
            if($output == 'Status: Invalid DLT Template'){
                return ['status'=> false, "message"=> "Invalid DLT Template!"];
            }else{
                return ['status'=> true, "message"=> "SMS has been Sent!"];
            }
        }

        curl_close($ch);
    }

    public function test(){

        $message = $this->otpTemplate('ds','sdsds');

        $dd = $this->sendSMS('8600363127', $message);
        dd($dd);
    }
}
