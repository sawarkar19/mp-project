<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstantTask extends Model
{
    use HasFactory;

    public function task(){
        return $this->belongsTo('App\Models\Task', 'task_id', 'id')->where('status', 1);
    }

    // public function freeUserTasks(){
    //     return $this->belongsTo('App\Models\Task', 'task_id', 'id')->where('status', 1)->where('visible_to_free_user', 1);
    // }

    public function activeTask(){
        return $this->belongsTo('App\Models\Task', 'task_id', 'id')->where('coming_soon', 0);
    }

    // public function freeUserActiveTasks(){
    //     return $this->belongsTo('App\Models\Task', 'task_id', 'id')->where('coming_soon', 0)->where('visible_to_free_user', 1);
    // }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->where('status', 1);
    }

    public function getDeletingOfferDetail(){
        $todayDate = \Carbon\Carbon::now();
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id')->whereDate('end_date', '<', $todayDate);
    }
}
