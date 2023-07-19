<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    public function offers()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('user_id',Auth::id());
    }
    
    public function subscription()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('user_id',Auth::id());
    }

    public function offers_active()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('status','1')->where('user_id',Auth::id());
    }

    public function offers_complete()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('status','2')->where('user_id',Auth::id());
    }

    public function offers_incomplete()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('status','!=','1')->where('status','!=','2')->where('user_id',Auth::id());
    }

    public function businesses(){
        return $this->hasMany('App\Models\BusinessCustomer', 'customer_id', 'id');
    }

    public function details(){
        return $this->hasMany('App\Models\BusinessCustomer', 'customer_id', 'id')->where('user_id',Auth::id());
    }
	
	public function detail(){
        return $this->hasOne('App\Models\BusinessCustomer', 'customer_id', 'id')->where('user_id',Auth::id());
    }


    //new
    public function info(){
        return $this->hasOne('App\Models\BusinessCustomer', 'customer_id', 'id')->where('user_id',Auth::id());
    }

    public function customer_info(){
        return $this->hasOne('App\Models\BusinessCustomer', 'customer_id', 'id')->where('user_id',Auth::user()->created_by);
    }

    // get Customer to match column date to send Personalize SMS
    public function getDobBusinessCustomer(){
        $todays_date = date('j F');
        return $this->hasOne('App\Models\BusinessCustomer','customer_id','id')->where('dob', $todays_date);
    }

    public function getAniversaryBusinessCustomer(){
        $todays_date = date('j F');
        return $this->hasOne('App\Models\BusinessCustomer','customer_id','id')->where('anniversary_date', $todays_date);
    }

    public function getBusinessCustomer(){
        return $this->hasOne('App\Models\BusinessCustomer','user_id','id');
    }

    public function getSingleBusinessesCustomerInfo(){
        return $this->hasOne('App\Models\BusinessCustomer', 'customer_id', 'id');
    }

    public function getSubscription()
    {
        return $this->hasMany('App\Models\OfferSubscription','customer_id','id')->where('user_id',Auth::id());
    }

    public function getCustomerDetails(){
        return $this->hasOne('App\Models\BusinessCustomer','customer_id','id')->where('user_id',Auth::id());
    }

    public function getCustScheduleContact(){
        return $this->hasMany('App\Models\MessageScheduleContact','customer_id','id')->where('user_id',Auth::id());
    }
    

}
