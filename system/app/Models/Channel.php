<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    public function msg_route(){
        return $this->hasOne('App\Models\MessageRoute', 'channel_id', 'id');
    }

    public function user_channel(){
        return $this->hasOne('App\Models\UserChannel', 'channel_id', 'id')->where('user_id',Auth::id());
    }

    public function admin_user_channel(){
        return $this->hasOne('App\Models\UserChannel', 'channel_id', 'id');
    }
}
