<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redeem extends Model
{
    use HasFactory;

    public function subscription(){
    	return $this->belongsTo('App\Models\OfferSubscription', 'offer_subscription_id', 'id')->with(['customer', 'offer_details']);
    }

    public function redeem_details(){
        return $this->hasOne('App\Models\RedeemDetail', 'redeem_id','id');
    }

}
