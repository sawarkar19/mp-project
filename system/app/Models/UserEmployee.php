<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmployee extends Model
{
    use HasFactory;

    public function employee(){
        return $this->belongsTo('App\Models\User', 'employee_id', 'id');
    }
}
