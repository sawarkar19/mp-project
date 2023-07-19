<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    public function gallery(){
        return $this->hasMany('App\Models\GalleryImage','template_id','id');
    }
    
    public function content(){
        return $this->hasMany('App\Models\TemplateContent','template_id','id');
    }

    public function button(){
        return $this->hasMany('App\Models\TemplateButton','template_id','id');
    }
}
