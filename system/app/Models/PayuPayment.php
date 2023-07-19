<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayuPayment extends Model
{
    use HasFactory;

    protected $table = 'payu_payments';
    protected $guarded = [];
}
