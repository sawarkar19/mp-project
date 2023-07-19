<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;
use Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
    }


    public function user_plan()
    {
        return $this->hasOne('App\Models\Userplan','user_id','id')->orderBy('id','DESC')->where('status',1)->with('plan_info', 'feature');
    }

    public function user_plan_metas()
    {
        return $this->hasOne('App\Models\Userplanmeta','user_id','id')->orderBy('id','DESC');
    }

    public function role(){
        return $this->belongsTo('App\Models\Role','role_id','id');
    }

    public function bussiness_details(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function bussiness_detail(){
        return $this->hasOne('App\Models\BusinessDetail', 'user_id', 'id');
    }

    public function employee_details(){
        return $this->hasOne('App\Models\EmployeeDetail', 'user_id', 'id');
    }

    public function user_apps()
    {
        return $this->hasMany('App\Models\Userplan','user_id','id')->orderBy('id','DESC');
    }

    public function expierd()
    {
        return $this->hasMany('App\Models\Userplan','user_id','id')->orderBy('id','DESC')->where('status', 1)->groupBy('user_id');
    }


    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    
    public function getCustomers()
    {
        return $this->hasMany('App\Models\Customer','user_id','id')->where('status', 1);
    }

    public function getBusCustomers()
    {
        return $this->hasMany('App\Models\BusinessCustomer','user_id','id');
    }

    public function getInstantSubscriptions()
    {
        return $this->hasMany('App\Models\OfferSubscription','user_id','id')->where('channel_id', 2);
    }

    public function getShareSubscriptions()
    {
        return $this->hasMany('App\Models\OfferSubscription','user_id','id')->where('channel_id', 3);
    }

    public function getRedeemedCustomers()
    {
        return $this->hasMany('App\Models\Redeem','user_id','id')->where('is_redeemed', 1);
    }

    public function getUniqueClicks()
    {
        return $this->hasMany('App\Models\Target','user_id','id')->where('repeated', 0);
    }

    public function getExtraClicks()
    {
        return $this->hasMany('App\Models\Target','user_id','id')->where('repeated', 1);
    }

    public function getCompletedTasks()
    {
        return $this->hasMany('App\Models\CompleteTask','user_id','id');
    }

    public function zeroMessageWallet()
    {
        return $this->hasOne('App\Models\MessageWallet', 'user_id', 'id')->where('total_messages', 0);
    }

    public function wallet()
    {
        return $this->hasOne('App\Models\MessageWallet', 'user_id', 'id');
    }

    public function birthdayMessage()
    {
        return $this->hasOne('App\Models\MessageTemplateSchedule', 'user_id', 'id')->where('message_template_category_id', 7)->where('is_scheduled', 1);
    }

    public function anniversaryMessage()
    {
        return $this->hasOne('App\Models\MessageTemplateSchedule', 'user_id', 'id')->where('message_template_category_id', 8)->where('is_scheduled', 1);
    }

    public function whatsappSession()
    {
        return $this->hasOne('App\Models\WhatsappSession', 'user_id', 'id')->whereNull('instance_id')->whereDate('updated_at', Carbon::now()->subDays(1));
    }

    public function whatsappSessionKeysNull()
    {
        return $this->hasOne('App\Models\WhatsappSession', 'user_id', 'id')->whereNull('key_id')->whereNull('key_secret');
    }

    public function autoShareOnBusiness()
    {
        return $this->hasOne('App\Models\BusinessDetail', 'user_id', 'id')->where('send_when_start', 1)->orWhere('share_to_subscribed_customers', 1);
    }

    public function paidTransaction()
    {
        return $this->hasOne('App\Models\Transaction', 'user_id', 'id');
    }

    public function getOffersList()
    {
        return $this->hasMany('App\Models\Offer', 'user_id', 'id')->whereStatus(1);
    }

    public function getRedeemedCodeSent()
    {
        return $this->hasMany('App\Models\Redeem','user_id','id');
    }

    public function employees(){
        return $this->hasMany('App\Models\User', 'created_by', 'id');
    }

    public function low_wallet(){
        return $this->hasOne('App\Models\MessageWallet', 'user_id', 'id')->where('wallet_balance', '<=', 0);
    }

    public function last_transaction(){
        return $this->hasOne('App\Models\Transaction', 'user_id', 'id')->where('transaction_amount', '>', 0)->orderBy('id', 'DESC');
    }
}
