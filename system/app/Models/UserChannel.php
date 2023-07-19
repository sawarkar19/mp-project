<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;

class UserChannel extends Model
{
    use HasFactory;

    public function userplan()
    {
        return $this->belongsTo('App\Models\Userplan','userplan_id','id');
    }

    public function freeEmployee()
    {
        return $this->hasMany('App\Models\UserEmployee', 'free_with_channel', 'channel_id')->whereIsFree(1)->whereUserId(Auth::id());
    }

    public function admin_freeEmployee($user_id=0)
    {
        return $this->hasMany('App\Models\UserEmployee', 'free_with_channel', 'channel_id')->whereIsFree(1)->whereUserId($user_id)->count();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function userDetail()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->where('is_sales_person', 0);
    }

    public function channel()
    {
        return $this->belongsTo('App\Models\Channel','channel_id','id');
    }

}
