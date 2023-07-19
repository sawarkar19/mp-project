<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckWalletBallanceCommand extends Command
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
    protected $description = 'Perform all wallet related checks to notify business.';

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
        return 0;
    }
}
