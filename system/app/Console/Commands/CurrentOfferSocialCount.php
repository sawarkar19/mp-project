<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

use App\Models\User;

class CurrentOfferSocialCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:currentoffersocialcount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates social impact.';

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
        // Offer Social Posts Count
        dispatch(new \App\Jobs\SendCurrentOfferSocialCountJob());

        // Social Account Count
        $userIds = User::where('social_post_api_token', "!=", "")->pluck('id')->toArray();
        foreach ($userIds as $key => $user_id) {
            dispatch(new \App\Jobs\SocialAccountCountJob($user_id));
        }
    }
}
