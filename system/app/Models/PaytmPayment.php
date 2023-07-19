<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaytmPayment extends Model
{
    use HasFactory;

    protected $table = 'paytm_payments';
    protected $guarded = [];
}
