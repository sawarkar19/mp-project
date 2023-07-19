<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Offer;
use Illuminate\Console\Command;

class ManageMediaPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:managemedia';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post offer [one day befor == startDate ] to Manage Media domain';

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

        $todays_date = date('Y-m-d');
        $tomorrowyDate = Carbon::tomorrow();

        $offers = Offer::where('status', 1)
                        ->whereDate('start_date', $tomorrowyDate)
                        ->where(function ($query) {
                            $query->where('is_social_post_created', 0)
                                ->orWhereNull('social_post__db_id');
                        })
                        ->get();
        
        if(!empty($offers)){
            foreach ($offers as $key => $offer){
                dispatch(new \App\Jobs\ManageMediaPost($offer));
            }
        }
        
    }
}
