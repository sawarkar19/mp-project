<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDemoAccountData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:demoaccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Here we update demo account data.';

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
        dispatch(new \App\Jobs\UpdateDemoAccountData());
    }
}
