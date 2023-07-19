<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Auth;

class Task extends Model
{
    use HasFactory;


    public function instant_task(){
        return $this->hasOne('App\Models\InstantTask')->where('user_id', Auth::id())->whereNull('deleted_at')->orderBy('id', 'desc');
    }
}
