<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DummyCredential;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;

class UuidTokenController extends Controller
{
    //


    static function eightCharacterUniqueToken($n){

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = ''; 
          
        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
          
        return $randomString; 
    }

    static function addCharacter($type, $randomString){

        if($type == 'future'){
            $string = 'F-'.$randomString;
        }elseif($type == 'instant'){
            $string = 'I-'.$randomString;
        } 
          
        return $string; 
    }

    static function findUniqueToken($type, $string){

        $check = OfferSubscription::where('uuid', $string)->first();

        switch ($check) {
        case true:
            $res = $this->recallFunction($type);
            break;
        case false:
            $res = ['status'=>false, 'token'=>$string];
            break;
        }
        
        return $res;
         
    }

    public function recallFunction($type){

        $randomString = $this->eightCharacterUniqueToken(8);
        $addedCharacter = $this->addCharacter($type, $randomString);
        
        $check = OfferSubscription::where('uuid', $addedCharacter)->first();
        if($check){
            $res = $this->recallagainFunction($type);
        }else{
            $res = ['status'=>false, 'token'=>$addedCharacter];
        }
        return $res;
    }

    public function recallagainFunction($type){

        $randomString = $this->eightCharacterUniqueToken(8);
        $addedCharacter = $this->addCharacter($type, $randomString);
        
        $check = OfferSubscription::where('uuid', $addedCharacter)->first();
        if($check){
            $res = $this->recallFunction($type);
        }else{
            $res = ['status'=>false, 'token'=>$addedCharacter];
        }
        return $res;
    }

    public function getDummyMobileNo(){
        $mobile = '1'.rand(111111111,999999999);

        $exist = DummyCredential::where('mobile', $mobile)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->mobile = $mobile;
            $dummy->save();

            return $mobile;
        }else{
            $this->getNewDummyMobileNo();
        }
    }

    public function getNewDummyMobileNo(){
        $mobile = '1'.rand(111111111,999999999);

        $exist = DummyCredential::where('mobile', $mobile)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->mobile = $mobile;
            $dummy->save();

            return $mobile;
        }else{
            $this->getDummyMobileNo();
        }
    }

    public function getDummyEmail(){
        $email = 'user'.rand(11,99999).'mouthpublicity.io';

        $exist = DummyCredential::where('email', $email)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->email = $email;
            $dummy->save();

            return $email;
        }else{
            $this->getNewDummyEmail();
        }
    }

    public function getNewDummyEmail(){
        $email = 'user'.rand(11,99999).'@mouthpublicity.io';

        $exist = DummyCredential::where('email', $email)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->email = $email;
            $dummy->save();

            return $email;
        }else{
            $this->getDummyEmail();
        }
    }

    public function getDummyName(){
        $name = 'User '.rand(11,99999);

        $exist = DummyCredential::where('name', $name)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->name = $name;
            $dummy->save();

            return $name;
        }else{
            $this->getNewDummyName();
        }
    }

    public function getNewDummyName(){
        $name = 'User '.rand(11,99999);

        $exist = DummyCredential::where('name', $name)->first();
        if($exist == null){
            $dummy = New DummyCredential;
            $dummy->name = $name;
            $dummy->save();
            
            return $name;
        }else{
            $this->getDummyName();
        }
    }
}
