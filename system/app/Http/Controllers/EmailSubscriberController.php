<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailSubscriber;

class EmailSubscriberController extends Controller
{
    //

    public function subscribe(Request $request){
        
        $email = $request->subscriber;
        if($email != ''){

            $check = EmailSubscriber::where('email', $email)->first();
            if($check){
                echo json_encode(array("type"=>"success", "message"=>"Email Id Is Already Subscribed."));
            }else{

                $subsciber = new EmailSubscriber;
                $subsciber->email = $email;
                $subsciber->save();

                echo json_encode(array("type"=>"success", "message"=>"Email Id Has Been Subscibe."));
            }
                
        }else{
            echo json_encode(array("type"=>"error", "message"=>"Please Enter Email Id."));
        }

    }

    public function requestDemo(Request $request){
        
        $email = $request->subscriber;
        if($email != ''){

            $check = EmailSubscriber::where('email', $email)->first();
            if($check){
                echo json_encode(array("type"=>"success", "message"=>"Email Id Is Already Subscribed."));
            }else{

                $subsciber = new EmailSubscriber;
                $subsciber->email = $email;
                $subsciber->save();

                echo json_encode(array("type"=>"success", "message"=>"Email Id Has Been Subscibe."));
            }
                
        }else{
            echo json_encode(array("type"=>"error", "message"=>"Please Enter Email Id."));
        }

    }
}
