<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userplan extends Model
{
    use HasFactory;


    public function plan_info()
    {
        return $this->belongsTo('App\Models\Plan','plan_id','id');
    }

    public function recharge_info()
    {
        return $this->belongsTo('App\Models\Recharge','recharge_plan_id','id')->select('id','messages','price');
    }
    
    //---get a feature code add start dinesh---//
    public function feature()
    {
        return $this->belongsTo('App\Models\Feature','feature_id','id');
    }
    //---get a feature code add end dinesh---//
    public function channel()
    {
        return $this->belongsTo('App\Models\Channel','channel_id','id');
    }
    
    public function channels()
    {
        return $this->hasMany('App\Models\Channel','id','channel_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id')->with('method');
    }

    public function employees()
    {
        return $this->hasMany('App\Models\Employee','userplan_id','id')->where('status','1')->orderBy('expiry_date','desc')->with('user');
    }

    public function direct_posts()
    {
        return $this->hasMany('App\Models\DirectPost','userplan_id','id')->where('status','1')->orderBy('expiry_date','desc');
    }

}
