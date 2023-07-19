<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table = 'user_notifications';

    public function notificationTitle()
    {
        return $this->belongsTo('App\Models\Notification','notification_id','id');
        
    }
}
