<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MessageWallet;
use App\Models\EmailJob;
use App\Models\User;
use App\Models\Transaction;
use App\Jobs\BelowMinimumBalanceJob;
use App\Jobs\LowWalletZeroEmailJob;
use Carbon\Carbon;

class NotifyLowAccountBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:lowbalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all users if there account balance goes below limit.';

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
        /* When Balance is low for the first time and User is paid */
        $low_balance_users = MessageWallet::with('user')->has('user')->whereColumn([['wallet_balance', '<', 'minimum_balance']])->where('wallet_balance', '>', 0)->pluck('user_id')->toArray();
       
        foreach ($low_balance_users as $key => $low_balance_user) {
            if(!EmailJob::whereEmailId(11)->whereUserId($low_balance_user)->exists()){
                $user = User::whereId($low_balance_user)->whereIsPaid(1)->first();
                if($user != NULL){
                    $data = [
                        'day' => 'today',
                        'user' => $user,
                    ];
                    dispatch(new BelowMinimumBalanceJob($data));
                }
            }
        }
        
        /* When Balace is low but not for the first time */
        $emailJobs = EmailJob::with('userDetail')
                                ->has('userDetail')
                                ->where('email_id', 11)
                                ->whereIn('user_id', $low_balance_users)
                                ->orderBy('created_at', 'DESC')
                                ->get()
                                ->unique('user_id');
        
                                
        if (!empty($emailJobs)) {
            foreach ($emailJobs as $emailJob) {
                if($emailJob->userDetail->is_paid == 1){
                    $data = [];
                    $diff = now()->diffInDays(Carbon::parse($emailJob->created_at));

                    $date_created_at =  $emailJob->created_at;
                    $created_at = Carbon::parse($date_created_at)->format('Y-m-d');
                    $today = Carbon::now()->format('Y-m-d');

                    if($diff == 0 && $emailJob->notification_day == 'today' && $created_at != $today){
                        $data = [
                            'day' => 'one',
                            'user' => $emailJob->userDetail,
                        ];
                    }

                    if($diff == 2 && $emailJob->notification_day == 'one'){
                        $data = [
                            'day' => 'three',
                            'user' => $emailJob->userDetail,
                        ];
                    }
                    if($diff == 4 && $emailJob->notification_day == 'three'){
                        $data = [
                            'day' => 'seven',
                            'user' => $emailJob->userDetail,
                        ];
                    }

                    if(!empty($data)){
                        dispatch(new BelowMinimumBalanceJob($data));
                    }
                }
            }
        }


        /* Send Email If Balance Zero Only For Paid User and First Time Sending Mail */
        $zero_balance_users = MessageWallet::with('user')->has('user')->where('wallet_balance', '=<', 0)->pluck('user_id')->toArray();

        foreach ($zero_balance_users as $key => $zero_balance_user) {
            if(!EmailJob::whereEmailId(31)->whereUserId($zero_balance_user)->exists()){
                $user = User::whereId($zero_balance_user)->whereIsPaid(1)->first();
                if($user != NULL){
                    dispatch(new LowWalletZeroEmailJob($user));
                }
            }
        }

        /* Send Email If Balance Zero Only For Paid User and Made Payment and Again Low Balance */
        $emailJobs = EmailJob::with('userDetail')
                            ->has('userDetail')
                            ->where('email_id', 31)
                            ->whereIn('user_id', $zero_balance_users)
                            ->orderBy('created_at', 'DESC')
                            ->get()
                            ->unique('user_id');

        foreach ($emailJobs as $key => $emailJob) {
            if($emailJob->userDetail->is_paid == 1){
                $transaction = Transaction::whereUserId($emailJob->user_id)
                                            ->orderBy('id', 'DESC')
                                            ->first();

                $wallet_balance = MessageWallet::whereUserId($emailJob->user_id)
                                                ->where('wallet_balance', '<=', 0)
                                                ->first();

                if($transaction != null && $wallet_balance != null && Carbon::parse($emailJob->created_at)->format("Y-m-d") < Carbon::parse($transaction->created_at)->format("Y-m-d")){
                        $user = $emailJob->userDetail;
                        dispatch(new LowWalletZeroEmailJob($user));
                    
                }
            }
        }
        

    }
}
