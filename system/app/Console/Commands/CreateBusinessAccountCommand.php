<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateBusinessAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:businessaccount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run this command to create test business account.';

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
        $data = [
            "name" => "Openchallenge Demo",
            "email" => "openchallengedemo@openchallenge.in",
            "mobile" => "9529215275",
            "password" => "demo@123",
        ];

        dispatch(new \App\Jobs\CreateBusinessAccount($data));
    }
}
