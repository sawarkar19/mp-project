<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\InstantTask;
use App\Models\UserChannel;
use App\Models\MessageWallet;
use App\Jobs\ClockworkCleanJob;
use Illuminate\Console\Command;
use App\Jobs\AutoEmployeesLogout;
use Illuminate\Support\Facades\Log;

use App\Models\OfferSubscription;
use App\Models\InstantTaskStat;

use App\Jobs\DeleteHqOfferImagesJob;
use App\Jobs\MonthlyWalletBalCredit;
use App\Models\UserSocialConnection;
use App\Jobs\MarkSubscriptionExpiredJob;
use App\Jobs\AddSocialMediaConnectedTasksJob;

use App\Jobs\DeleteExpiredOfferInstantTaskJob;
use App\Jobs\DuplicateOfferDataForSalesPerson;
use App\Jobs\UpdateSalesPersonWalletBalanceJob;
use App\Jobs\DeductActiveEmployeeCostJob;
use App\Jobs\DailyDeductionJob;

class UpdateSystemSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:systemsettings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Here we update all the necessary system settings.';

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
        $today = date("Y-m-d");

        /* Update Sales Person Wallet Balance */
        $sales_person_ids = User::where('is_sales_person', 1)->where('is_demo', 0)->where('status', 1)->pluck('id')->toArray();
        $wallets = MessageWallet::whereIn('user_id', $sales_person_ids)->where('total_messages', '<', 50)->get();
        
        if(!empty($wallets)){
            foreach($wallets as $wallet){
                dispatch(new UpdateSalesPersonWalletBalanceJob($wallet));
            }
        }

        /* Clockwork clean files */
        $files = scandir(storage_path().'/clockwork/');
        if(!empty($files)){
            foreach($files as $file)
            {
                dispatch(new ClockworkCleanJob($file));
            }
        }

        /* Update Offer Data For Sales Person */
        $salesAdmin = User::where('is_sales_person', 1)->where('is_sales_admin', 1)->where('status', 1)->first();
        if($salesAdmin != ''){
            $current_offer = Offer::where('user_id', $salesAdmin->id)->where('start_date', '=', date("Y-m-d"))->first();

            if($current_offer != ''){

                $salesPersonIds = User::where('is_sales_person', 1)->where('is_sales_admin', 0)->where('is_demo', 0)->where('status', 1)->pluck('id')->toArray();

                if(!empty($salesPersonIds)){
                    foreach($salesPersonIds as $sp_id){

                        $current_offer = Offer::where('user_id', $sp_id)->where('start_date', '=', date("Y-m-d"))->first();
                        if($current_offer == null){
                            dispatch(new DuplicateOfferDataForSalesPerson($sp_id));
                        }
                        
                    }
                }
            }
        }

        // Auto logout All Employees
        dispatch(new AutoEmployeesLogout());

        // Check Business Person Monthly Wallet
        // dispatch(new MonthlyWalletBalCredit());

        /* Delete Yesterday Offer High Quality images of Social Media Thumbnails. */
        $deleteImagesOfferIds = Offer::whereDate('created_at', date("Y-m-d", strtotime("-1 days")))->pluck('id')->toArray();
        foreach ($deleteImagesOfferIds as $key => $offerId) {
            dispatch(new DeleteHqOfferImagesJob($offerId));
        }

        // Set Manually-Social Post Instant Task like Youtube URL
        $todayOffers = Offer::with("offer_template")->whereDate('start_date', date("Y-m-d"))->get();
        // dd($todayOffers);

        if(count($todayOffers) > 0){
            foreach ($todayOffers as $key => $offer) {
                if(isset($offer->offer_template) && $offer->offer_template->video_url != NULL){
                    $task_value = $offer->offer_template->video_url;
                    $task_key="youtube";
                    $this->addMannualInstantTask($task_value, $task_key, $offer->user_id);
                }
            }
        }

        // Delete Expired Offer Instant Task
        dispatch(new DeleteExpiredOfferInstantTaskJob());

        // Add Social Media Connected Tasks
        $socialConnectedUser = UserSocialConnection::get();
        if($socialConnectedUser!=NULL){
            foreach ($socialConnectedUser as $key => $socialUser) {
                dispatch(new AddSocialMediaConnectedTasksJob($socialUser->user_id));
            }
        }

        // Deduct Active Employees Cost
        $users = User::with('employees')->has('employees')->pluck('id')->toArray();
        if(count($users) > 0){
            foreach ($users as $key => $user_id){
                dispatch(new DeductActiveEmployeeCostJob($user_id));
            }
        }

        //Daily rental deduction
        $paidUsers=User::where('current_account_status','=','paid')->where('role_id',2)->get();
        if($paidUsers!=NULL){
            foreach ($paidUsers as $key => $paiduser) {
                dispatch(new DailyDeductionJob($paiduser->id));
            }
        }

        // Delete Redeemed OfferSubscription Instant Task Statistics.
        $reddemedOfferSubIds = OfferSubscription::with('getInstantTaskStatistics')->has('getInstantTaskStatistics')->where('status', '2')->pluck('id')->toArray();
        InstantTaskStat::whereIn('offer_subscription_id', $reddemedOfferSubIds)->delete();
    }

    public function addMannualInstantTask($task_value, $task_key, $user_id){
        $tasks = [];
        // if($task_key == "facebook"){
        //     $tasks = [2, 3, 15];
        // }
        if($task_key == "youtube"){
            $tasks = [11, 12];
        }

        $inTasks=[];
        foreach ($tasks as $key => $task){
            $instanceTask = InstantTask::whereUserId($user_id)->whereNull('deleted_at')->whereTaskId($task)->orderBy('id', 'DESC')->first();

            $add=1;
            if($instanceTask!=NULL){
                if($instanceTask->task_value != $task_value){
                    $iTask = InstantTask::find($instanceTask->id);
                    $iTask->deleted_at = Carbon::now();
                    $iTask->save();
                }
                else{
                    $add=0;
                }
            }

            if($add==1){
                $newInstantTasks['user_id'] = $user_id;
                $newInstantTasks['task_value'] = $task_value;
                $newInstantTasks['task_id'] = $task;
                $inTasks[]=$newInstantTasks;
            }
        }
        InstantTask::insert($inTasks);
    }

}
