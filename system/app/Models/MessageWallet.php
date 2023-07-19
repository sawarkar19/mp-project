<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageWallet extends Model
{
    use HasFactory;

    protected $table = 'message_wallet';

        public function users()
        {
            return $this->belongsTo('App\Models\User', 'user_id', 'id');
        }

        public function user()
        {
            return $this->belongsTo('App\Models\User', 'user_id', 'id')->where('is_sales_person', 0)->where('status', 1);
        }

        public function userDetail()
        {
            return $this->belongsTo('App\Models\User','user_id','id')->where('is_sales_person', 0)->where('status', 1);
        }
}
