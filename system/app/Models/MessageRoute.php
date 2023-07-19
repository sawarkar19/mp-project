<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRoute extends Model
{
    use HasFactory;

    public function channel()
    {
        return $this->belongsTo('App\Models\Channel');
    } 

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
