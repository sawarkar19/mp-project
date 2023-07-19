<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCustomer extends Model
{
    use HasFactory;

    protected $table = 'business_customers';

    protected $guarded = [];

    public function getCustomerInfo(){
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }

    public function buCustomerInfo(){
        return $this->hasOne('App\Models\Customer','id','customer_id');
    }

    public function wishBuCustomerInfo(){
        return $this->hasMany('App\Models\Wish','business_customer_id','id');
    }
}
