<?php

namespace App\Jobs;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Offer;
use App\Models\EmailJob;
use App\Models\AdminMessage;
use Illuminate\Bus\Queueable;
use App\Mail\OfferToExpiredEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class OfferToExpiredEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug("run check:offertoexpired => Job file => OfferToExpiredEmailJob => handle datetime: ".date('d-m-Y H:s:i'));

        $today = Carbon::now();
        $from = Carbon::now()->subDay(1);
        $to = Carbon::now()->addDay(2);
        $runningOfferUserIds = Offer::whereBetween('end_date', [$from, $to])
                        ->pluck('user_id')
                        ->toArray();
                         
        
        /* Dont have scheduled offers */                
        $userIds = Offer::where('start_date', '>', $today)->pluck('user_id')
        ->toArray();
        
        $userIdsWithoutOffer = array_diff($runningOfferUserIds, $userIds);
        
        $users = User::whereIn('id', $userIdsWithoutOffer)
                ->where('status', 1)->get();  
                
        // Log::debug("run check:offertoexpired => Job file => OfferToExpiredEmailJob => handle => check users who offer to be expired datetime: ".date('d-m-Y H:s:i'));

        if (!empty($users)) {
            // Log::debug("run check:offertoexpired => Job file => OfferToExpiredEmailJob => handle => get users who offer to be expired datetime: ".date('d-m-Y H:s:i'));

            foreach ($users as $key => $user) {
                
                
            }
        }
    }

}
