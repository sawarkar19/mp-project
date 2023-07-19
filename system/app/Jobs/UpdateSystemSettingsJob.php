<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\MessageWallet;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateSystemSettingsJob implements ShouldQueue
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
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

    }
}
