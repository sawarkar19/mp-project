<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\UserLogin;

class UpdateUserLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;      
        $getLoginStatus = UserLogin::where('user_id',$user->id)
                ->where('is_login', '1')
                ->orderBy('id','desc')
                ->first();
        if($getLoginStatus != null)
        { 
            $getLoginStatus['is_login'] = '0';
            $getLoginStatus->save();
        }
    }
}
