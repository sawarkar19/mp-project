<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    use HasFactory;

    public function facebook(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','facebook')->where('is_repeated', '0');
    }

    public function facebook_extra(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','facebook')->where('is_repeated', '1');
    }

    public function twitter(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','twitter')->where('is_repeated', '0');
    }

    public function twitter_extra(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','twitter')->where('is_repeated', '1');
    }

    public function linkedin(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','linkedin')->where('is_repeated', '0');
    }

    public function linkedin_extra(){
        return $this->hasMany('App\Models\SocialPostCount','social_post_id','id')->where('media','linkedin')->where('is_repeated', '1');
    }

    // public function scheduleOffers()
    // {
    //     $todays = date("Y-m-d");
    //     return $this->belongsTo('App\Models\Offer','offer_id','id')->where('end_date', '>=', $todays)->orderBy('start_date', 'asc');
    // }

    public function social_platforms(){
        return $this->hasMany('App\Models\SocialPlatform','social_post_id','id');
    }

}
