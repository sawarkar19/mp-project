<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageHistory extends Model
{
    use HasFactory;

    public function userBusinessDetail()
    {
    	return $this->belongsTo('App\Models\BusinessDetail','user_id','user_id');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','mobile','mobile');
    }

    public function business()
    {
    	return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function channel(){
        return $this->belongsTo('App\Models\Channel','channel_id','id');
    }

    public function customerDetails()
    {
    	return $this->hasOne('App\Models\Customer','id','customer_id')->with('info');
    }
}
