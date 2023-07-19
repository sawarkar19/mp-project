<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\EmailJob;
use App\Models\WhatsappSession;
use Illuminate\Console\Command;
use App\Jobs\WhatsappConnectionStatus;
use App\Jobs\NotifyWhatsappDisconnectedJob;

class WhatsappConnectionCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:whatsappdisconnected';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users that there whatsappp has been emailJobed with OpenChallenge';

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
        $today = Carbon::now();
        $one_day_before = Carbon::now()->addDay(1);
        $three_day_before = Carbon::now()->addDay(2);
        $seven_day_before = Carbon::now()->addDay(6);

        $emailJobedUsers = WhatsappSession::where('status', 'lost')->pluck('id')->toArray();

        $emailJobs = EmailJob::with('userDetail')
                                ->where('email_id', 16)
                                ->whereIn('user_id', $emailJobedUsers)
                                ->orderBy('created_at', 'DESC')
                                ->get()
                                ->unique('user_id');
        
        if (!empty($emailJobs)) {
            foreach ($emailJobs as $emailJob) {
                
                $data = [];
                $diff = now()->diffInDays(Carbon::parse($emailJob->created_at));

                if($diff == 0 && $emailJob->notification_day == 'today'){
                    $data = [
                        'day' => 'one',
                        'user' => $emailJob->userDetail,
                    ];
                }

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
                    dispatch(new NotifyWhatsappDisconnectedJob($data));
                }
            }
        }
    }
}
