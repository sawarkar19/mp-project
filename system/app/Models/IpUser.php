<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_ip',
        'mobile',
        'date',
        'is_sent'
    ];
}
