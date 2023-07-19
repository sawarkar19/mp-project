<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTemplate extends Model
{
    use HasFactory;

    public function offer_gallery(){
        return $this->hasMany('App\Models\OfferGalleryImage','offer_template_id','id');
    }

    public function gallery(){
        return $this->hasMany('App\Models\OfferGalleryImage','offer_template_id','id');
    }

    public function content(){
        return $this->hasMany('App\Models\OfferTemplateContent','offer_template_id','id');
    }

    public function button(){
        return $this->hasMany('App\Models\OfferTemplateButton','offer_template_id','id');
    }
}
