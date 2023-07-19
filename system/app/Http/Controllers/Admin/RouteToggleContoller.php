<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\User;

use App\Models\Channel;
use App\Models\MessageRoute;
use App\Models\Notification;
use Illuminate\Http\Request;

use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;


class RouteToggleContoller extends Controller
{
    //

    static function routeDetail($channel_id, $user_id){

        $route = MessageRoute::where('user_id', $user_id)
        ->where('channel_id', $channel_id)
        ->orderBy('id', 'desc')->first();
        

        if(!$route){
            $route = new MessageRoute;
            $route->user_id = $user_id;
            $route->channel_id = $channel_id;
            $route->save();
        }

        return $route;
    }

    static function notificationDetail($notification_id, $user_id)
    {
        $user_notification = UserNotification::where('user_id', $user_id)
        ->where('notification_id', $notification_id)
        ->orderBy('id', 'desc')
        ->first();

        if (isset($user_notification)) {
            $notification_id = $user_notification->notification_id;
        }
        
        if (!$user_notification) {
            $user_notification = new UserNotification;
            $user_notification->user_id = $user_id;
            $user_notification->notification_id = $notification_id;
            $user_notification->save();
        }
        return $user_notification;

    }

    static function routeDetails(){

        $route = MessageRoute::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        $channels = Channel::where('status', 1)->where('is_use_msg', 1)->orderBy('ordering', 'asc')->get();

        if(!$route){
            foreach ($channels as $channel) {
                $route = new MessageRoute;
                $route->user_id = Auth::id();
                $route->channel_id = $channel->id;
                $route->save();
            }
        }

        $routes = MessageRoute::where('user_id', Auth::id())->orderBy('id', 'asc')->get();

        return $routes;
    }

    public function msgToggle(Request $request){

        $parentId = explode("_",$request->channel);
        $message = $parentId[0];
        $channelId = $parentId[1];

        $messager = 0;
        $changeChannel = '';

        $user_id = Auth::id();
        $route = MessageRoute::where('user_id', $user_id)
        ->where('channel_id', $channelId)
        ->orderBy('id', 'desc')
        ->first();

        $channel = Channel::where('id', $channelId)->first();

        if($route != null){
            if($message == 'wa'){ 
                $route->wa = $request->value; 
                $changeChannel = 'wa_'.$channelId;
            }else{ 
                $route->sms = $request->value; 
                $changeChannel = 'sms_'.$channelId;
            }

        }else{
            $route = new MessageRoute;
            $route->user_id = $user_id;
            $route->channel_id = $channelId;
            
            if($message == 'wa'){ 
                $route->wa = $request->value;
                $changeChannel = 'wa_'.$channelId;
            }else{ 
                $route->sms = $request->value;
                $changeChannel = 'sms_'.$channelId; 
            }
        }

        /* if($route != null){
            if($message == 'wa'){ 
                $route->wa = $request->value; 
            }else{ 
                $route->sms = $request->value; 
            }
            
            if($request->value == 0){
                if($message == 'wa' && $route->sms == 0){
                    $route->sms = 1;
                    $messager = 1;
                    $changeChannel = 'sms_'.$channelId;
                }else if($message == 'sms' && $route->wa == 0){
                    $route->wa = 1;
                    $messager = 1;
                    $changeChannel = 'wa_'.$channelId;
                }
            }
        }else{
            $route = new MessageRoute;
            $route->user_id = $user_id;
            $route->channel_id = $channelId;
            
            if($message == 'wa'){ 
                $route->wa = $request->value;
            }else{ 
                $route->sms = $request->value; 
            }

            if($request->value == 0){
                if($message == 'sms' && $route->wa == 0){
                    $route->wa = 1;
                    $messager = 1;
                    $changeChannel = 'wa_'.$channelId;
                }
            }
        } */

        $messageWallet = MessageWallet::where('user_id', Auth::id())->first();
        // dd();
        if($messageWallet->wallet_balance <= 0 && $message == 'sms' && $request->value == 1){
            return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
        }

        if($route->save()){
            return response()->json(['status' => true, 'message' => $channel->name.' Route Updated Successfully', 'messager' => $messager, 'channel'=>$changeChannel]);
        }else{
            return response()->json(['status' => false, 'message' => 'Can not update message route. Please try later.']);
        }
    }

    public function emailToggle(Request $request){

        $parentId = explode("_",$request->notification);
        $message = $parentId[0];
        $notificationId = $parentId[1];

        $messager = 0;
        $changeNotification = '';

        $user_id = Auth::id();

        /* UserNotification check data*/
        $user_notification = UserNotification::where('user_id', $user_id)
        ->where('notification_id', $notificationId)
        ->orderBy('id', 'desc')
        ->first();
        
        /*Notification get data*/
        $notification = Notification::where('id', $notificationId)->first();

        if($user_notification != null){
            if($message == 'wa'){ 
                $user_notification->wa = $request->value;
                $changeNotification = 'wa_'.$notificationId;
            }else{ 
                $user_notification->email = $request->value; 
                $changeNotification = 'email_'.$notificationId;
            }

        }else{
            /* UserNotification new create*/
            $user_notification = new UserNotification;
            $user_notification->user_id = $user_id;
            $user_notification->notification_id = $notificationId;
            
            if($message == 'wa'){ 
                $user_notification->wa = $request->value;
                $changeNotification = 'wa_'.$notificationId;
            }else{ 
                $user_notification->email = $request->value;
                $changeNotification = 'email_'.$notificationId; 
            }
        }

        // $messageWallet = MessageWallet::where('user_id', Auth::id())->first();

        // if($messageWallet->wallet_balance <= 0 && $message == 'sms' && $request->value == 1){
        //     return response()->json(['status' => false, 'message' => config('constants.payment_alert')]);
        // }

        if($user_notification->save()){
            return response()->json(['status' => true, 'message' => 'Notification status Update Successfully', 'messager' => $messager, 'notification'=>$changeNotification]);
        }else{
            return response()->json(['status' => false, 'message' => 'Can not update email notification. Please try later.']);
        }
    }

}
