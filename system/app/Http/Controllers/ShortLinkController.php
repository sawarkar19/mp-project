<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShortLink;
use Illuminate\Http\Request;

use App\Models\Option;
use App\Models\FailedShortLink;

class ShortLinkController extends Controller
{
    //


    static function numCharacterUniqueToken($n){

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = ''; 
          
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
          
        return $randomString; 
    }

    static function findUniqueToken($string){

        $check = ShortLink::where('uuid', $string)->first();

        switch ($check) {
        case true:
            $res = $this->recallFunction();
            break;
        case false:
            $res = ['status'=>false, 'token'=>$string];
            break;
        }
        
        return $res;
         
    }

    public function recallFunction(){

        $randomString = $this->numCharacterUniqueToken(6);
        
        $check = ShortLink::where('uuid', $randomString)->first();
        if($check){
            $res = $this->recallagainFunction();
        }else{
            $res = ['status'=>false, 'token'=>$randomString];
        }
        return $res;
    }

    public function recallagainFunction(){

        $randomString = $this->numCharacterUniqueToken(6);
        
        $check = ShortLink::where('uuid', $randomString)->first();
        if($check){
            $res = $this->recallFunction();
        }else{
            $res = ['status'=>false, 'token'=>$randomString];
        }
        return $res;
    }

    static function callShortLinkApi($long_link, $user_id=0, $related_to=""){
        /* $postData = array(
            'opnlkey' => env('SHORTNER_API_KEY'),
            'secret' => env('SHORTNER_SECRET_KEY'),
            'long_link' => $long_link
        ); */

        $postData = array(
            'opnlkey' => 'ol-PFAb3O0wGo2hHnQY',
            'secret' => 'mEFgF1niz9L6PGuOgaeCet3CgjJ6X4DrpT4T6U3v',
            'long_link' => $long_link
        );

        //API URL
        $url="https://opnl.in/api/v1/opnl-short-link";

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);
        // dd($output);
        if(isset($output->status) && $output->status == true){
            $uriSegments = explode("/", parse_url($output->link, PHP_URL_PATH));
            $link_uuid = array_pop($uriSegments);

            $shortLink = new ShortLink;
            $shortLink->uuid = $link_uuid;
            $shortLink->link = $long_link;
            $shortLink->save();

            return response()->json(["success" => true, "message" => "Link generated!", 'code' => $link_uuid, 'id' => $shortLink->id]);
            
        }else{
            // If Failed Shorter link
            $shorterLink = Option::where('key', 'shortner_redirect_url')->first();

            $length = 10;
            $str = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $failed_uuid = substr(str_shuffle($str), 0, $length);

            $shortLink = new ShortLink;
            $shortLink->uuid = $failed_uuid;
            $shortLink->link = $long_link;
            $shortLink->link_status = 0;
            if($shortLink->save()){

                $failedShortLink = new FailedShortLink;
                $failedShortLink->user_id = $user_id;
                $failedShortLink->uuid = $failed_uuid;
                $failedShortLink->long_link = $long_link;
                $failedShortLink->related_to = $related_to;
                $failedShortLink->save();

                $link_uuid = $shorterLink->value ?? "MOUTHPUBLICITY";
                $link_uuid = $link_uuid."?failed_link=".$failed_uuid;

                return response()->json(["success" => true, "message" => "Link generated!", 'code' => $link_uuid, 'id' => $shortLink->id]);
            }else{
                return response()->json(["success" => false, "message" => "Link not generated!"]);
            }
        }
    }
}
