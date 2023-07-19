<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\GroupCustomer;
use App\Models\BusinessCustomer;

class MessageTemplateSchedule extends Model
{
    use HasFactory;
    protected $table = 'message_template_schedules';


    // get Persolized Cahnnel Routes using channel=5
    public function getMessageRoute()
    {
        return $this->hasOne('App\Models\MessageRoute', 'user_id', 'user_id')->where('channel_id', 5);
    }

    public function getUserDetails()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id')->where('status', 1);
    }

    public function template(){
        return $this->hasOne('App\Models\MessageTemplate', 'id', 'template_id');
    }

    public function scopeWishingTemplates($query, $type_id)
    {
        if ($type_id!='') {
            $query->where(function ($query) use ($type_id) {
                if($type_id == '5'){
                    $query->where('message_template_schedules.type_id', $type_id );
                }else if($type_id == '6'){
                    $query->where('message_template_schedules.type_id', $type_id );
                }else if($type_id != '2' || $type_id != '5' || $type_id != '6' ){
                    $query->where('message_template_schedules.type_id', $type_id );
                }                
            });
        }
        return $query;
    }

    public function scopePersonalisedTemplates($query)
    {    
        $query->where('message_template_schedules.type_id', '<>', '6' )
        ->where('message_template_schedules.type_id', '<>', '5' )
        ->where('message_template_schedules.type_id', '<>', '2' )
        ->orderBy('scheduled', 'asc');
        return $query;
    }

    public function userDetail()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getCustomerIdsByGroup($contact_group_id)
    {
        $groups = explode(',', $contact_group_id);
        $grpCustomers = GroupCustomer::whereIn('contact_group_id', $groups)
        ->groupBy('customer_id')
        ->pluck('customer_id')
        ->toArray();

        return BusinessCustomer::whereIN('customer_id', $grpCustomers)
                        ->groupBy('customer_id')
                        ->pluck('customer_id')
                        ->toArray();
    }

    public function getTimeSlot()
    {
        return $this->belongsTo('App\Models\TimeSlot', 'time_slot_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\MessageScheduleContact', 'message_template_schedule_id', 'id');
    }
}
