<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userrechargemeta extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function activeorder(){
        return $this->hasOne('App\Models\UserRecharge','user_id','user_id')->where('status',1);
    }
}
