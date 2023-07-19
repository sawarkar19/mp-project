<?php

namespace App\Console\Commands;

use App\Jobs\ClockworkCleanJob;
use Illuminate\Console\Command;

class ClockworkCleanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clockwork:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans the app/storage/clockwork directory';

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
        $files = scandir(storage_path().'/clockwork/');

        if(!empty($files)){
            foreach($files as $file)
            {
                dispatch(new ClockworkCleanJob($file));
            }
        }

    }
}
