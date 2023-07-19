<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BizSmsReport extends Model
{
    use HasFactory;
    protected $table = 'biz_sms_reports';
    protected $fillable = [
        'message',
        'number',
        'stage',
        'shoot_date',
        'send_date',
        'status',
    ];
}
