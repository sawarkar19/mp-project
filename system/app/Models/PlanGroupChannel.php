<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanGroupChannel extends Model
{
    use HasFactory;

    public function channel_info(){
        return $this->belongsTo('App\Models\Channel', 'channel_id', 'id');
    }
}
