<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;
    protected $table = 'wishes';

    public function template_message(){
        return $this->hasOne('App\Models\MessageTemplate', 'id', 'template_id');
    }
}
