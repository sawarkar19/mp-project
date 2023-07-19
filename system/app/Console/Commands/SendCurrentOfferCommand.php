<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Offer;
use App\Models\UserChannel;
use App\Models\ContactGroup;
use App\Models\MessageRoute;
use App\Models\GroupCustomer;
use App\Models\MessageWallet;
use App\Models\BusinessDetail;
use Illuminate\Console\Command;
use App\Jobs\ShareNewOfferLinkJob;
use App\Models\ShareChallengeContact;
use App\Helper\Deductions\DeductionHelper;


class SendCurrentOfferCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:currentoffer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Share Challenge Current Offer';

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
        /* Get paid users */
        $paidusers = User::where('current_account_status','=','paid')->where('role_id', 2)->where('status',1)->pluck('id')->toArray();

        /* Check Master Switch */
        $activeSwitchUserIds = UserChannel::whereIn('channel_id', [3,5])->whereIn('user_id',$paidusers)->where('status', 1)->pluck('user_id')->toArray();

        /* Check SMS routes on for Personalised Message */
        $userIdsWithActiveRoutes = MessageRoute::whereIn('user_id', $activeSwitchUserIds)->where('channel_id', 5)->where('sms', 1)->pluck('user_id')->toArray();

        /* Balance Check */
        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'send_sms');

        /* Users with balance */
        $activeUserIdsWithBalance = MessageWallet::with('user')->has('user')->whereIn('user_id', $userIdsWithActiveRoutes)->pluck('user_id')->toArray();

        $businessDetails = BusinessDetail::whereIn('user_id', $activeUserIdsWithBalance)->where('send_when_start',1)->where('selected_groups','!=','')->select('id','user_id','share_offer_scheduled_date')->get();
        
        foreach($businessDetails as $businessDet){
            if($businessDet->share_offer_scheduled_date < date('Y-m-d')){
                $offer = Offer::where('user_id', $businessDet->user_id)
                                ->where('start_date', '=', date('Y-m-d'))
                                ->first();
                if($offer!=NULL){
                    $bznzDetail = BusinessDetail::find($businessDet->id);
                    $bznzDetail->share_offer_scheduled_date = date('Y-m-d');
                    $bznzDetail->save();
                }
            }
        }

        $businessIds = BusinessDetail::whereIn('user_id', $activeUserIdsWithBalance)->where('send_when_start',1)->where('share_offer_scheduled_date','=',date('Y-m-d'))->where('selected_groups','!=','')->pluck('user_id')->toArray();

        if(!empty($businessIds)){
            foreach($businessIds as $businessId){
                $offer = Offer::where('user_id', $businessId)
                                ->where('start_date', '<=', date('Y-m-d'))
                                ->where('end_date', '>=', date('Y-m-d'))
                                ->first();
                dispatch(new ShareNewOfferLinkJob($offer));
            }
        }
    
    }
}
