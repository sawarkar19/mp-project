<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteTask extends Model
{
    use HasFactory;

    public function instant_task(){
    	return $this->belongsTo('App\Models\InstantTask','instant_task_id','id');
    }
}
