<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\MessageRoute;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use Illuminate\Console\Command;
use App\Jobs\WalletBalanceLowJob;
use App\Jobs\WalletBalanceZeroJob;
use App\Models\MessageTemplateSchedule;
use App\Jobs\AutoshareStoppedDueToLowBalanceJob;

class WalletBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:walletbalance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform all low wallet balance checks.';

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
        $today = date('Y-m-d');

        /* Wallets of Active Plan */
        $wallets = MessageWallet::with('user')
                                ->has('user')
                                ->where('wallet_balance', '<=', 0)
                                ->get();

        if(!empty($wallets)){

            foreach($wallets as $wallet){

                /* Zero balance (Same for Birthday and Anniversary) */
                if($wallet->wallet_balance <= 0){

                    $transaction = Transaction::where('user_id', $wallet->user_id)->first();
                    if($transaction != null){
                        dispatch(new WalletBalanceZeroJob($wallet->user));
                    }
                    
                }

            }
        }


    }
}
