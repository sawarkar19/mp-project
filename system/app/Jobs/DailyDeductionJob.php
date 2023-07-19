<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\UserChannel;
use DeductionHelper;


class DailyDeductionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        //
        $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $deductionSmsDetail = DeductionHelper::getActiveDeductionDetail('slug', 'messaging_api_cost');
        $checkWallet = DeductionHelper::getUserWalletBalance($this->user_id);
        if($checkWallet['status']==true && ($checkWallet['wallet_balance'] > $deductionSmsDetail->amount)){
            $channel_id = 4;
            $channelActive=UserChannel::where('user_id',$this->user_id)->where('channel_id',$channel_id)->first();
            if($channelActive != null && $channelActive->status==1){
                DeductionHelper::deductWalletBalance($this->user_id, $deductionSmsDetail->id ?? 0, $channel_id,0,0,0);
            }
        }
    }
}
