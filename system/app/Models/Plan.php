<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public function active_users()
    {
    	return $this->hasMany('App\Models\Userplan')->where('status',1);
    }
}
