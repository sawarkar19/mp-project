<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemDetail extends Model
{
    use HasFactory;

    protected $table = 'redeem_details';
    protected $guarded = [];

    public function subscription(){
        return $this->belongsTo('App\Models\offerSubscription','id','offer_subscribe_id');
    }

    public function subscription_details(){
        return $this->belongsTo('App\Models\OfferSubscription','offer_subscribe_id','id')->with('customer','offer');
    }

    public function redeem(){
        return $this->hasOne('App\Models\Redeem','id','redeem_id');
    }
}
