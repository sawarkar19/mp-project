<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessDetail extends Model
{
    use HasFactory;

    public function owner(){
    	return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function autoSharingTime()
    {
    	return $this->belongsTo('App\Models\AutoShareTiming','auto_share_timing_id','id');
    }

    public function stateDetail()
    {
        return $this->hasOne('App\Models\State', 'id', 'billing_state');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User','user_id','id')->select('id', 'name', 'status')->where('status', 1);
    }
}
