<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferFuture extends Model
{
    use HasFactory;

    public function offer()
    {
        return $this->belongsTo('App\Models\Offer');
    }    

    public function offer_target()
    {
        return $this->hasOne('App\Models\OfferFuture','offer_id','id');
    }

    public function state(){
    	return $this->hasOne('App\Models\State', 'id', 'state_id');
    }

    public function city(){
    	return $this->hasOne('App\Models\City', 'id', 'city_id');
    }
}
