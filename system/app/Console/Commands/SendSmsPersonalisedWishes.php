<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wish;
use App\Jobs\SendSms;
use DateTimeImmutable;
use App\Models\TimeSlot;
use App\Jobs\SendWishSms;
use App\Models\UserChannel;
use App\Models\MessageRoute;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use Illuminate\Console\Command;

use App\Models\BusinessCustomer;
use App\Models\MessageTemplateSchedule;
use App\Helper\Deductions\DeductionHelper;

class SendSmsPersonalisedWishes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:smspersonalisedwishes';

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
        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

        /* Users with balance */
        $activeUserIdsWithBalance = MessageWallet::with('user')->has('user')->where('wallet_balance', '>', $deductionDetail->amount)->pluck('user_id')->toArray();

        /* Master Switch Check */
        $activeSwitchUserIds = UserChannel::whereIn('user_id', $activeUserIdsWithBalance)->where('channel_id', 5)->where('status', 1)->pluck('user_id')->toArray();

        /* Check SMS routes on for Personalised Message */
        $userIdsWithActiveRoutes = MessageRoute::whereIn('user_id', $activeSwitchUserIds)->where('channel_id', 5)->where('sms', 1)->pluck('user_id')->toArray();
        
        /* Check if wishes are already sent */
        $wishSendTodayIds = Wish::whereDate('created_at', date("Y-m-d"))->where('sent_via', 'sms')->groupBy('user_id')->pluck('user_id')->toArray();
        
        /* Get Business for who CRON not executed */
        $userIds = array_diff($userIdsWithActiveRoutes,$wishSendTodayIds);
        
        /* Get Birthday and Anniversary Message Records */
        $messageSchedules = MessageTemplateSchedule::whereIn('user_id', $userIds)->where('related_to', 'Personal')->whereNull('scheduled')->where('is_scheduled', 1)->get();
        // dd($messageSchedules);
        if(!empty($messageSchedules)){

            foreach($messageSchedules as $scheduleMsg){
                
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
                
                // DOB
                if ($scheduleMsg->message_template_category_id == 7) {
                    $userSmsParams = [];
   
                    $type = 'dob';
                    $dob_date = date('j F');
                    $businessCustomer = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                        ->where('dob', $dob_date)
                        ->get();
                    
                    $businessCustomerIds = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                        ->where('dob', $dob_date)
                        ->pluck('customer_id')
                        ->toArray();

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
                            }
                        }
                        
                        dispatch(new SendWishSms($dataArr));
                    }
                }
                
                if ($scheduleMsg->message_template_category_id == 8) {
                    $userSmsParams = [];
                    
                    $type = 'aniversary';
                    $anni_date = date('j F');
                    
                    $businessCustomer = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                        ->where('anniversary_date', $anni_date)
                        ->get();

                    $businessCustomerIds = BusinessCustomer::where('user_id', $scheduleMsg->user_id)
                        ->where('dob', $anni_date)
                        ->pluck('customer_id')
                        ->toArray();

                    $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');
                    $checkWalletBalance = DeductionHelper::checkWalletBalanceWithNoOfPer($scheduleMsg->user_id, $deductionDetail->id ?? 0, count($businessCustomerIds));

                    if ($checkWalletBalance['status']==true) {
                        if ($businessCustomer) {
                            foreach (@$businessCustomer as $cusKey => $busCustomer) {
                                if ($busCustomer != null) {
                                    $userSmsParams[] = $this->_setCustomerDetailsForSms($busCustomer, $message, $scheduleMsg, $type);
                                }
                            }
                        }
                    }
                    
                    
                    if ($userSmsParams != null) {
                        $dataArr = [];
                        foreach ($userSmsParams as $key => $params) {
                            $data = $this->validateParams($params);
                            if ($data['status'] == true) {
                                $dataArr[] = $data;
                            }
                        }
                        
                        dispatch(new SendWishSms($dataArr));
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
