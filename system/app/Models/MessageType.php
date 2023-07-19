<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{
    use HasFactory;

    public function messageTemplate(){
        return $this->hasMany('App\Models\MessageTemplate', 'id', 'type_id');
    }
}
