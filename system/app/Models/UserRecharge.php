<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecharge extends Model
{
    use HasFactory;

    public function recharge_info()
    {
        return $this->belongsTo('App\Models\Recharge','recharge_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function recharge_payment_method()
    {
        return $this->belongsTo('App\Models\Transaction','transaction_id')->with('method');
    }
}
