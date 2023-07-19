<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendSms;
use DateTimeImmutable;
use App\Models\Customer;
use App\Models\TimeSlot;
use App\Jobs\SendCustomSms;
use App\Models\UserChannel;
use App\Models\MessageRoute;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use Illuminate\Console\Command;

use App\Models\BusinessCustomer;
use App\Jobs\PersonaliseWalletLowJob;
use App\Models\MessageTemplateSchedule;
use App\Helper\Deductions\DeductionHelper;

class SendSmsPersonalisedCustomWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:smspersonalisedcustomwishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send personalised wishes through SMS and also check whatsapp message progress.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todays_date = date('Y-m-d');
        $todays_datetime = Carbon::now();
        $todays_datetime = $todays_datetime->addMinutes(15)->format('Y-m-d H:i:s');

        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

        /* Users with balance */
        $activeUserIdsWithBalance = MessageWallet::with('user')->has('user')->where('wallet_balance', '>', $deductionDetail->amount)->pluck('user_id')->toArray();

        /* Master Switch Check */
        $activeSwitchUserIds = UserChannel::whereIn('user_id', $activeUserIdsWithBalance)->where('channel_id', 5)->where('status', 1)->pluck('user_id')->toArray();

        /* Check SMS routes on for Personalised Message */
        $userIdsWithActiveRoutes = MessageRoute::whereIn('user_id', $activeSwitchUserIds)->where('channel_id', 5)->where('sms', 1)->pluck('user_id')->toArray();
        
        $conditions = [];
        $conditions[] = ['related_to', '=', 'Festival'];
        $conditions[] = ['is_scheduled', '=', 1];
        
        /* Get Message Records */
        $messageSchedules = MessageTemplateSchedule::whereIn('user_id', $userIdsWithActiveRoutes)
                                                    ->where('is_sms_cron_schedule', 0)
                                                    ->where('scheduled', $todays_date)
                                                    ->where(function($query) use ($conditions) {
                                                        $query->where('related_to', 'Custom')
                                                              ->orWhere($conditions);
                                                    })
                                                    ->where('sms_status', 'queued')
                                                    ->get();
                                                    
        $messageSchedulesCount=count($messageSchedules);

        // dd($messageSchedules);
        if($messageSchedulesCount > 0){

            foreach($messageSchedules as $scheduleMsg){

                /* Message Time */
                $s_time = '12:00:00';
                $time_slot = TimeSlot::find($scheduleMsg->time_slot_id);
                if($time_slot != null){
                    $s_time = $time_slot->value;
                }
                $time_arr = explode(':', $time_slot->value);

                $new_datetime = new DateTimeImmutable($scheduleMsg->scheduled);
                $scheduled_datetime = $new_datetime->setTime($time_arr[0], $time_arr[1], $time_arr[2]);
                $scheduled_datetime = $scheduled_datetime->format("Y-m-d H:i:s");

                if ($scheduleMsg->scheduled == $todays_date && $scheduled_datetime < $todays_datetime) {
                    /* Business Name */
                    $busniess_name = 'business owner';
                    if(isset($scheduleMsg->getUserDetails->bussiness_detail->business_name)){
                        $busniess_name = $scheduleMsg->getUserDetails->bussiness_detail->business_name;
                        $busniess_name = $busniess_name ?? 'business owner';
                        if (strlen($busniess_name) > 28) {
                            $busniess_name = substr($busniess_name, 0, 28) . '..';
                        }
                    }

                    /* Message */
                    $message = '';
                    if(isset($scheduleMsg->template->message)){
                        $message = $scheduleMsg->template->message;
                        $message = str_replace('[business_name]', $busniess_name, $message);
                        $message = str_replace('{#var#}', $busniess_name, $message);
                    }

                    $userSmsParams = [];

                    //Message
                    $type = 'custom';
                    $groups = explode(',', $scheduleMsg->groups_id);
                    $grpCustomers = GroupCustomer::whereIn('contact_group_id', $groups)
                                                    ->groupBy('customer_id')
                                                    ->pluck('customer_id')
                                                    ->toArray();
                    
                    $businessCustomerIds = BusinessCustomer::with('getCustomerInfo')
                                                            ->whereIN('customer_id', $grpCustomers)
                                                            ->groupBy('customer_id')
                                                            ->pluck('customer_id')
                                                            ->toArray();

                    
                    $businessCustomer = BusinessCustomer::with('getCustomerInfo')
                                                                ->whereIN('customer_id', $grpCustomers)
                                                                ->groupBy('customer_id')
                                                                ->get();

                    $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    $checkWalletBalance = DeductionHelper::checkWalletBalanceWithNoOfPer($scheduleMsg->user_id, $deductionDetail->id ?? 0, count($businessCustomerIds));

                    if ($checkWalletBalance['status']==true) {
                        foreach (@$businessCustomer as $cusKey => $busCustomer) {
                            if ($busCustomer != null) {
                                $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type);
                            }
                        }
                    }
                    
                    if ($userSmsParams != null) {
                        $dataArr = [];
                        foreach ($userSmsParams as $key => $params) {
                            $data = $this->validateParams($params);
                            if ($data['status'] == true) {
                                $dataArr[] = $data;

                                $schedule = MessageTemplateSchedule::find($data['schedule_id']);
                                $schedule->is_sms_cron_schedule = 1;
                                $schedule->save();
                            }
                        }
                        
                        dispatch(new SendCustomSms($dataArr));
                    }
                }
            }   
        }
    }

    public function _setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type = '')
    {
        $message = str_replace('[customer_name]', @$busCustomer->name, $message);
        $user['customer_id'] = @$busCustomer->getCustomerInfo->id;
        $user['mobile'] = '91' . @$busCustomer->getCustomerInfo->mobile;
        $user['message'] = $message;
        $user['channel_id'] = @$scheduleMsg->channel_id;
        $user['schedule_id'] = @$scheduleMsg->id;
        $user['user_id'] = $scheduleMsg->user_id;
        $user['type'] = @$type;
        return $user;
    }

    public function validateParams($params)
    {
        $dataArr = [];

        $userData = User::where('id', $params['user_id'])
                            ->where('status', 1)
                            ->orderBy('id', 'desc')
                            ->first();

        $dataArr = [
            'user_id' => $userData != null ? $userData->id : $params['user_id'],
            'customer_id' => $params['customer_id'],
            'mobile' => $params['mobile'],
            'message' => $params['message'],
            'channel_id' => $params['channel_id'],
            'schedule_id' => $params['schedule_id'],
            'type' => $params['type'],
            'status' => true,
        ];

        return $dataArr;
    }
}