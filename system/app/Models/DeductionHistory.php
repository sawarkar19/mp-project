<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionHistory extends Model
{
    use HasFactory;

    public function getUserDeductionReport(){
        return $this->hasOne('App\Models\Deduction','id','deduction_id')->select('id','name');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id','id')->select('id','name','email','mobile', 'status', 'created_at');
    }

    public function getEmployees()
    {
        return $this->belongsTo('App\Models\User','employee_id','id');
    }

    public function businessCustomer(){
        return $this->belongsTo('App\Models\BusinessCustomer','customer_id','customer_id')->with('buCustomerInfo');
    }

    public function deduction(){
        return $this->belongsTo('App\Models\Deduction')->select('id','name');
    }
}
