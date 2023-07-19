<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Customer;
use App\Models\UserChannel;
use App\Models\MessageRoute;
use App\Models\MessageWallet;
use App\Jobs\AutoShareLinkJob;
use App\Models\BusinessDetail;
use App\Models\MessageHistory;
use App\Models\WhatsappSession;
use Illuminate\Console\Command;
use App\Jobs\ShareNewOfferLinkJob;
use App\Jobs\WhatsappConnectionStatus;

class SendOfferLinkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:offerlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Share offer link and check whatsapp connection';

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
        $today = date('Y-m-d');

        /* Check Whatspp Connection */
        $usersIds = User::where('role_id', 2)->where('status', 1)->pluck('id')->toArray();
        $wa_sessions = WhatsappSession::whereIn('user_id', $usersIds)
                                        ->where('instance_id', '!=', '')
                                        ->get();

        foreach($wa_sessions as $wa_session){
            if ($wa_session != null && $wa_session->instance_id != null) {
                $user = User::find($wa_session->user_id);
                dispatch(new WhatsappConnectionStatus($user));
            }
        }
        
        /* Send Offer */
        $activeUsers = MessageWallet::with('userDetail')
                                        ->has('userDetail')
                                        ->get();
        $activeUsersCount=count($activeUsers);
        if ($activeUsersCount > 0) {
            foreach ($activeUsers as $message) {
                if ($message->wallet_balance <= 0) {
                    MessageRoute::where('user_id', $message->userDetail->id)->update(['sms' => 0]);
                }

                $businessDetail = BusinessDetail::with('autoSharingTime')
                                                ->where('user_id', $message->userDetail->id)
                                                ->first();

                $isChannelActive = UserChannel::whereChannelId(3)->whereUserId($businessDetail->user_id)->first('status');

                /* Share Auto Offer */
                if ($businessDetail->autoSharingTime != null && $businessDetail->share_to_subscribed_customers == 1) {
                    $current_datetime = date('Y-m-d H:i:s');
                    $minhours = $businessDetail->autoSharingTime->time_period;
                    $maxhours = $minhours + 2;

                    $max_datetime = date('Y-m-d H:i:s', strtotime('-' . $maxhours . ' hours', strtotime($current_datetime)));

                    $min_datetime = date('Y-m-d H:i:s', strtotime('-' . $minhours . ' hours', strtotime($current_datetime)));

                    $msgHistories = MessageHistory::whereIn('channel_id', [2, 4])
                                                    ->whereIn('related_to', ['Send Link', 'WhatsApp API'])
                                                    ->where(function ($query) use ($max_datetime, $min_datetime) {
                                                        $query->where('created_at', '>', $max_datetime)->where('created_at', '<', $min_datetime);
                                                    })
                                                    ->where('user_id', $businessDetail->user_id)
                                                    ->where('is_sent_auto_msg', 0)
                                                    ->orderBy('id', 'desc')
                                                    ->get();
                    // dd($msgHistories, $min_datetime, $max_datetime, $businessDetail->user_id);
                    // get Business today running offers
                    $offer = Offer::where('user_id', $businessDetail->user_id)
                        ->where('start_date', '<=', date('Y-m-d'))
                        ->where('end_date', '>=', date('Y-m-d'))
                        ->first();
                    $msgHistoriesCount=count($msgHistories);
                    if (($msgHistoriesCount > 0) && $offer != null) {
                        if($isChannelActive->status == 1){
                            foreach ($msgHistories as $historyKey => $msgHistory) {
                                dispatch(new AutoShareLinkJob($msgHistory));
                            }
                        }
                    }
                }
            }
        }
    }
}
