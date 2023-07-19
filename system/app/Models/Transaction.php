<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function method()
    {
        return $this->belongsTo('App\Models\Category','category_id','id')->select('id','name');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id')->select('id','name','email','mobile', 'status', 'created_at');
    }

    public function userplans()
    {
        return $this->hasMany('App\Models\Userplan','transaction_id','id')->with('channel','plan_info')
        ;
    }

    public function employee()
    {
        return $this->hasMany('App\Models\Employee','transaction_id','id');
    }

    public function direct_post()
    {
        return $this->hasMany('App\Models\DirectPost','transaction_id','id');
    }

    public function state()
    {
        return $this->hasOne('App\Models\State', 'id', 'gst_state');
    }
}
