<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailJob extends Model
{
    use HasFactory;
    protected $table = 'email_jobs';

    public function userDetail()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id')->where('is_sales_person', 0)->where('status', 1);
        
    }
}
