<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetArchive extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'offer_subscribe_id', 'target', 'status'];
}
