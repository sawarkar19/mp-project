<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    public function customer()
    {
        return $this->hasOne('App\Models\Customer','id','customer_id')->with('getCustomerDetails');
    }

    public function offer(){
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->with('offer_template','future_offer');
    }

    public function future_offer(){
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->with('future_offer');
    }

    public function instant_offer(){
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->with('instant_offer');
    }

    public function offer_details(){
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->with(['business','offer_template']);
    }

    public function is_redeemed(){
        return $this->hasOne('App\Models\Redeem', 'offer_subscription_id', 'id')->where('is_redeemed', 1);
    }

    public function targets(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'id')->where('repeated', 0);
    }

    public function targets_parent(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'parent_id')->where('repeated', 0);
    }

    public function extra_targets(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'id')->where('repeated', 1);
    }

    public function extra_targets_parent(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'parent_id')->where('repeated', 1);
    }

    public function achived_target(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'id');
    }

    public function achived_target_parent(){
        return $this->hasMany('App\Models\Target', 'offer_subscription_id', 'parent_id');
    }

    public function completed_task(){
        return $this->hasMany('App\Models\CompleteTask', 'offer_subscription_id', 'id');
    }

    public function offer_data(){
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id');
    }

    public function redeem_data(){
        return $this->hasMany('App\Models\Redeem', 'offer_subscription_id', 'id')->with('redeem_details');
    }

    public function reward(){
        return $this->hasOne('App\Models\OfferSubscriptionReward', 'offer_subscription_id', 'id');
    }

    public function getDeletingOfferDetail(){
        $todayDate = \Carbon\Carbon::now();
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->whereDate('end_date', '<', $todayDate);
    }

    public function getInstantTaskStatistics(){
        return $this->hasOne('App\Models\InstantTaskStat', 'offer_subscription_id', 'id');
    }
}
