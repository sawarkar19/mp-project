<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareChallengeContact extends Model
{
    use HasFactory;
    protected $table = 'share_challenge_contacts';
    protected $fillable = [
        'user_id',
        'customer_id',
        'offer_id',
        'status',
    ];
}
