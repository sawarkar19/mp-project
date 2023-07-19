<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Models\User;
use App\Models\MessageWallet;
use App\Models\Option;
use App\Models\FreeTransaction;


class MonthlyWalletBalCredit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $getMonthNo = Carbon::now()->subMonth(7)->format('m');
        $lastMonthDays = Carbon::now()->month($getMonthNo)->daysInMonth;
        $checkDays = now()->subDays($lastMonthDays)->endOfDay();
        $userIds = User::where('role_id', 2)->where('created_at', '<=', $checkDays)->where('status', 1)->pluck('id')->toArray();

        $usersWallets = MessageWallet::whereIn('user_id', $userIds)->get();

        if($usersWallets!=NULL){
            $monthlyLimit = Option::where('key', 'monthly_balance_addon')->first();

            foreach ($usersWallets as $key => $wallet) {
                $userBalance = MessageWallet::find($wallet->id);
                if($wallet->wallet_balance < $monthlyLimit->value ?? 20){
                    $userBalance->wallet_balance = $monthlyLimit->value ?? 20;

                    $transaction = new FreeTransaction;
                    $transaction->user_id = $wallet->user_id;
                    $transaction->amount = $monthlyLimit->value ?? 20;
                    $transaction->save();
                }
                else if($wallet->wallet_balance < 0){
                    $userBalance->wallet_balance = 0;
                }
                $userBalance->save();
            }
        }
    }
}
