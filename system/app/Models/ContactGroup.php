<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactGroup extends Model
{
    use HasFactory;

    protected $table = 'contact_groups';

    public function customers(){
        return $this->hasMany('App\Models\GroupCustomer','contact_group_id','id');
    }
}
