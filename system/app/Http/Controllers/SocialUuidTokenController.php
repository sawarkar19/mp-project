<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialPost;
use Illuminate\Http\Request;

class SocialUuidTokenController extends Controller
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

        $check = SocialPost::where('uuid', $string)->first();

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
        
        $check = SocialPost::where('uuid', $randomString)->first();
        if($check){
            $res = $this->recallagainFunction();
        }else{
            $res = ['status'=>false, 'token'=>$randomString];
        }
        return $res;
    }

    public function recallagainFunction(){

        $randomString = $this->numCharacterUniqueToken(6);
        
        $check = SocialPost::where('uuid', $randomString)->first();
        if($check){
            $res = $this->recallFunction();
        }else{
            $res = ['status'=>false, 'token'=>$randomString];
        }
        return $res;
    }
}
