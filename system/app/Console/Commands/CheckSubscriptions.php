<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Models\EmailJob;
use App\Models\Userplan;
use App\Models\User;
use App\Models\ExpiredUser;
use App\Models\Channel;
use Carbon\Carbon;
use DB;

class CheckSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:subscriptions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will check the users subscriptions plan expiry date, and send email according to remaining days.';

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
        /* Modify Code */
    }
}
