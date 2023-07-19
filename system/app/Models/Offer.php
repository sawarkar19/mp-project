<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;

class Offer extends Model
{
    use HasFactory;

    protected $dates = ['start_date', 'end_date', 'redeem_date'];

    public function future_offer()
    {
        return $this->hasOne('App\Models\OfferFuture','offer_id','id')->with(['offer_target']);
    }

    public function business(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->with(['bussiness_detail']);
    }

    public function instant_offer()
    {
        return $this->hasOne('App\Models\OfferInstant','offer_id','id');
    }
    
    public function offer_complete()
    {
        return $this->hasMany('App\Models\OfferFuture','offer_id','id')->where('status','1');
    }
   

    public function scopeSearch($query, $src)
    {
        if ($src!='') {
            $query->where(function ($query) use ($src) {
                $query->where('offers.uuid', 'LIKE','%'.$src.'%')
                    ->orwhere('offers.title', 'LIKE','%'.$src.'%')
                    ->orwhere('offers.type', 'LIKE','%'.$src.'%')
                    ->orwhere('offers.start_date', 'LIKE','%'.$src.'%')
                    ->orwhere('offers.end_date', 'LIKE','%'.$src.'%');
            });
        }
        return $query;
    }

    public function users(){
        return $this->hasMany('App\Models\OfferSubscription', 'offer_id', 'id');
    }

    public function subscriptions(){
        return $this->hasMany('App\Models\OfferSubscription', 'offer_id', 'id');
    }
	
	public function user(){
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
	
    public function subscription(){
        return $this->hasMany('App\Models\OfferSubscription', 'offer_id', 'id')->with('achived_target');
    }

    public function offer_target($type)
    {
        if($type == 'future'){
            // return App\Models\OfferFuture::
            return $this->belongsTo('App\Models\OfferFuture','offer_id','id')->with(['share_target']);
        }elseif($type == 'instant'){
            return $this->belongsTo('App\Models\OfferInstant','offer_id','id')->with(['share_target']);
        }
    }

    public function instant_tasks(){
        return $this->hasMany('App\Models\InstantTask','offer_id','id')->orderBy('id','desc')->distinct('task_key');
    }

    public function offer_template(){
        return $this->hasOne('App\Models\OfferTemplate','offer_id','id')->with(['offer_gallery','content']);
    }

    public function unique_clicks(){
        return $this->hasMany('App\Models\Target','offer_id','id')->where('repeated',0);
    }

    public function extra_clicks(){
        return $this->hasMany('App\Models\Target','offer_id','id')->where('repeated',1);
    }

    public function socialPost()
    {
        return $this->hasOne('App\Models\SocialPost','offer_id','id')->where('user_id', Auth::id());
    }

    public function getInstantTasks(){
        return $this->hasMany('App\Models\InstantTask','offer_id','id')->where('user_id', Auth::id())->whereNotNull('offer_id');
    }

    public function getCronInstantTasks(){
        return $this->hasMany('App\Models\InstantTask','offer_id','id')->whereNull('offer_id');
    }

    public function getTwitterClicks()
    {
        return $this->hasManyThrough(
            SocialPost::class,
            SocialPostCount::class,
            'social_post_id',
            'offer_id',
            'id',
            'id'
        )->whereMedia('twitter');
    }

    public function getFacebookClicks()
    {
        return $this->hasManyThrough(
            SocialPost::class,
            SocialPostCount::class,
            'social_post_id',
            'offer_id',
            'id',
            'id'
        )->whereMedia('facebook');
    }
}
