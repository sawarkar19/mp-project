<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanGroup extends Model
{
    use HasFactory;

    public function channels(){
        return $this->hasMany('App\Models\PlanGroupChannel', 'plan_group_id', 'id')->with('channel_info');
    }

    public function channel_ids(){
        return $this->hasMany('App\Models\PlanGroupChannel', 'plan_group_id', 'id');
    }
}
