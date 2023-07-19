<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Models\EmailJob;
use Auth;

class NotificationController extends Controller
{
    //

    static function getNotification(){
        $notifications = EmailJob::where('user_id',Auth::id())->where('mark_deleted','0')->orderBy('created_at','desc')->limit(3)->get();

        return $notifications;
    }
}
