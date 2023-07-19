<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Offer;
use App\Models\EmailJob;
use App\Models\InstantTask;
use App\Models\UserChannel;
use App\Models\MessageWallet;
use App\Jobs\OfferNotPostedJob;
use Illuminate\Console\Command;
use App\Jobs\OfferNotCreatedJob;
use App\Jobs\DoNotHaveOfferRunningJob;
use App\Jobs\DoNotHaveUpcomingOfferJob;

class CheckOffersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:offers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform all offer related checks to notify business.';

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
        /* Offer is going to expire and dont have upcoming offers */
        $currentDay = Carbon::now()->format('Y-m-d');
        $goingToExpireOfferUsers = Offer::whereDate('end_date', $currentDay)
            ->pluck('user_id')
            ->toArray();

        $upcomingOfferUsers = Offer::with('user')
            ->has('user')
            ->whereIn('user_id', $goingToExpireOfferUsers)
            ->where('start_date', '>', $currentDay)
            ->pluck('user_id')
            ->toArray();

        $userDontHaveOffers = array_diff($goingToExpireOfferUsers, $upcomingOfferUsers);
        $userDontHaveOffersData = User::whereIn('id', $userDontHaveOffers)
            ->where('status', 1)
            ->get();

        if (!empty($userDontHaveOffersData)) {
            foreach ($userDontHaveOffersData as $user) {
                dispatch(new DoNotHaveUpcomingOfferJob($user));
            }
        }

        /* Notification if don't have any created offer */

        $noOffers = Offer::where('start_date', '<', $currentDay)
                         ->where('start_date', '!=', $currentDay)
                         ->where('start_date', '!>', $currentDay)
                         ->where('end_date', '<', $currentDay)
                         ->where('end_date', '!=', $currentDay)
                         ->where('end_date', '!>', $currentDay)
                         ->orWhere('start_date', NULL )
                         ->orWhere('end_date', NULL )
                         ->pluck('user_id')
                         ->toArray();
        $noOffers = array_unique($noOffers);
        $noOffers = array_values($noOffers);

        $emailJobs = EmailJob::with('userDetail')
                                ->where('email_id', 9)
                                ->where('notification_day', '!=', 'today')
                                ->whereIn('user_id', $noOffers)
                                ->orderBy('created_at', 'DESC')
                                ->get()
                                ->unique('user_id');

        if (!empty($emailJobs)) {
            foreach ($emailJobs as $emailJob) {
                
                $data = [];
                $diff = now()->diffInDays(Carbon::parse($emailJob->created_at));

                if($diff == 2 && $emailJob->notification_day == 'one'){
                    $data = [
                        'day' => 'three',
                        'user' => $emailJob->userDetail,
                    ];
                }

                if($diff == 4 && $emailJob->notification_day == 'three'){
                    $data = [
                        'day' => 'seven',
                        'user' => $emailJob->userDetail,
                    ];
                }

                if(!empty($data)){
                    dispatch(new OfferNotCreatedJob($data['user']));
                }
            }
        }

    }
}
