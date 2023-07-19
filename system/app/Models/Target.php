<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offer_Subscription(){
        return $this->hasMany('App\Models\Target', 'offer_subscribe_id', 'id')->where('repeated', 1);
    }

    public function achived_target(){
        return $this->hasMany('App\Models\Target', 'offer_subscribe_id', 'id');
    }

}
