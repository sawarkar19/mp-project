<?php

namespace App\Jobs;

use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\DemoAccountRechargeHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateSalesPersonWalletBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $wallet;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $messages = 500;

        /* Update sales person wallet */
        $wallet = MessageWallet::find($this->wallet->id);
        if($wallet->total_messages < 50){
            $wallet->total_messages = $wallet->total_messages + $messages;
            $wallet->save();

            /* Recharge History */
            $history = new DemoAccountRechargeHistory;
            $history->user_id = $this->wallet->user_id;
            $history->message_count = $messages;
            $history->save();
        }
    }
}
