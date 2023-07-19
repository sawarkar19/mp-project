<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialOfferCount extends Model
{
    use HasFactory;

    public function offer()
    {
        return $this->hasOne('App\Models\Offer','id','offer_id')->where('status','1');
    }
}
