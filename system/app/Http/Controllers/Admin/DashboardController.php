<?php

namespace App\Http\Controllers\Admin;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Offer;
use App\Models\Target;
use App\Mail\TestEmail;
use App\Models\Userplan;
use App\Models\DeductionHistory;
use App\Mail\WaLogoutEmail;
use App\Models\Transaction;
use App\Mail\LowWalletEmail;
use Illuminate\Http\Request;
use App\Mail\AdminByAdminMail;
use App\Mail\ContactToUserMail;
use App\Mail\LowWalletDOBEmail;
use App\Mail\OfferNotPostEmail;
use App\Mail\ContactToAdminMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\LowWalletAnniEmail;
use App\Mail\LowWalletZeroEmail;
use App\Mail\OfferNotShareEmail;
use App\Mail\OfferToCreateEmail;
use App\Mail\BusinessByAdminMail;
use App\Mail\BusinessWelcomeMail;
use App\Mail\EventCancelledEmail;

//add code start//
use App\Mail\OfferToExpiredEmail;
use App\Models\OfferSubscription;
use App\Mail\PlanExpireTodayEmail;
use App\Mail\EmailSubscriptionMail;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Mail\BusinessPlanUpdateMail;
use App\Mail\BusinessPlanExpiredMail;
use App\Mail\AutoSettingLowWalletEmail;
use App\Mail\BusinessWalletExpiredMail;
use App\Mail\BusinessPlanExpireInOneDay;
use App\Mail\BusinessPlanExpireInFiveDay;
use App\Mail\BusinessPlanExpireInSevenDay;
use App\Mail\BusinessPlanExpireInThreeDay;
use App\Mail\DailyReportsToBussinessEmail;
use App\Mail\PlanExpireTodayYesterdayEmail;
use App\Http\Controllers\ShortLinkController;

//add code end//

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function settings()
    {
        return view('seller.settings');
    }

    public function dashboard()
    {
        $request_users = User::where('role_id', 3)->get();

        $date = Carbon::today();

        /* count data  start*/
        $total_user = User::where('role_id', 2)->count();

        $paid_user = User::where('current_account_status', 'paid')
            ->where('is_paid', 1)
            ->where('role_id', 2)
            ->count();

        $expired_user = User::where('created_at', '<=', $date)
            ->where('is_paid', 1)
            ->where('current_account_status', 'free')
            ->where('role_id', 2)
            ->count();

        $free_user = User::where('current_account_status', 'free')
            ->where('is_paid', 0)
            ->where('role_id', 2)
            ->count();

        $total_instant_challenge = OfferSubscription::where('channel_id', 2)
            ->where('status', '1')
            ->count();
        $total_share_challenge = OfferSubscription::where('channel_id', 3)
            ->where('status', '2')
            ->count();

        $total_challenge = 0;
        if ($total_instant_challenge != null || $total_share_challenge != null) {
            $total_challenge = $total_instant_challenge + $total_share_challenge;
        }
        /* count data  end*/

        /* Subscription Plans graph data  start*/
        $data = [$total_instant_challenge, $total_share_challenge];
        $labels = ['Total Instant Challenge', 'Total Share Challenge'];

        /* today date  and offer active data*/
        $today = date('Y-m-d');
        $total_unique_clicks = Target::where('repeated', 0)->count();
        $total_clicks = Target::count();

        /*graph unique click ans total click data start*/
        $chartData = $this->last7days();
        $clickChartDates = $chartData['labels'];
        $chartUniqueClicks = $chartData['data'][0];
        $chartTotalClicks = $chartData['data'][1];

        /* transaction data get */
        $transactions = Transaction::latest()
            ->take(10)
            ->get();

        /* mutiple array */
        $records = [];
        $records = [
            'total_user' => $total_user,
            'paid_user' => $paid_user,
            'expired_user' => $expired_user,
            'free_user' => $free_user,
        ];

        /* transaction data and deduction data */
        /* transaction*/
        $transactionAmount = Transaction::where('status', 1)
            ->select('transaction_amount')
            ->get();
        $total = 0;

        foreach ($transactionAmount as $key => $amount) {
            $total = $amount['transaction_amount'] + $total;
        }

        /*deduction*/
        $deductionAmount = DeductionHistory::select('deduction_amount')->get();

        $totalDeduction = 0;
        foreach ($deductionAmount as $deduct) {
            $totalDeduction = $deduct['deduction_amount'] + $totalDeduction;
        }

        /*graph transaction and deduction data start*/
        $currentchartData = $this->currentLast7days();
        $currentchartDates = $currentchartData['labels'];
        $totalTransaction = $currentchartData['data'][0];
        $totalDeduction = $currentchartData['data'][1];

        return view('admin.dashboard', compact('request_users', 'transactions', 'records', 'data', 'labels', 'clickChartDates', 'chartUniqueClicks', 'chartTotalClicks', 'currentchartDates', 'totalTransaction', 'totalDeduction', 'total_challenge'));
    }

    public function currentLast7days()
    {
        $labels = $this->getSevenDaysLb();
        $data = $this->getCurrent7DayTransactionRecords();

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function last7days()
    {
        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function getSevenDaysLb()
    {
        $w7 = Carbon::now()
            ->subDays(6)
            ->format('d M');
        $w6 = Carbon::now()
            ->subDays(5)
            ->format('d M');
        $w5 = Carbon::now()
            ->subDays(4)
            ->format('d M');
        $w4 = Carbon::now()
            ->subDays(3)
            ->format('d M');
        $w3 = Carbon::now()
            ->subDays(2)
            ->format('d M');
        $w2 = Carbon::now()
            ->subDays(1)
            ->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7, $w6, $w5, $w4, $w3, $w2, $w1];

        return $labels;
    }

    public function get7DayRecords()
    {
        // $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7, $w6, $w5, $w4, $w3, $w2, $w1];
        $datas = [];

        /* Unique clicks */
        $uniqueClicks = [];
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $dailyClicks = Target::where('repeated', 0)
                ->where('created_at', 'LIKE', Carbon::parse($day)->format('Y-m-d') . '%')
                ->count();
            $updatedClicks = $updatedClicks + $dailyClicks;
            $uniqueClicks[] = $updatedClicks;
        }
        $datas[] = $uniqueClicks;

        /* total Clicks */
        $totalClicks = [];
        $updatedClicks = 0;
        foreach ($labels as $day) {
            $DailyTotalClicks = Target::where('created_at', 'LIKE', Carbon::parse($day)->format('Y-m-d') . '%')->count();
            $updatedClicks = $updatedClicks + $DailyTotalClicks;
            $totalClicks[] = $updatedClicks;
        }
        $datas[] = $totalClicks;

        return $datas;
    }

    public function getCurrent7DayTransactionRecords()
    {
        // $user = Auth::user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7, $w6, $w5, $w4, $w3, $w2, $w1];
        $datas = [];

        /* daily transaction data start */
        $dailyTotalTransactions = [];
        foreach ($labels as $day) {
            $dailyTransactions = Transaction::where('transaction_amount', '>', 0)
                ->where('created_at', 'LIKE', Carbon::parse($day)->format('Y-m-d') . '%')
                ->where('status', 1)
                ->get();
            $todayTransaction = 0;

            foreach ($dailyTransactions as $amount) {
                $todayTransaction = $amount['transaction_amount'] + $todayTransaction;
            }
            $dailyTotalTransactions[] = $todayTransaction;
        }
        $datas[] = $dailyTotalTransactions;

        /* daily deduction amount data start */
        $totalDeductions = [];
        foreach ($labels as $day) {
            $dailytotalDeductions = DeductionHistory::where('deduction_amount', '>=', '0')
                ->where('created_at', 'LIKE', Carbon::parse($day)->format('Y-m-d') . '%')
                ->get();
            $updatedDeductions = 0;

            foreach ($dailytotalDeductions as $deduct) {
                $updatedDeductions = $updatedDeductions + $deduct['deduction_amount'];
            }
            $totalDeductions[] = $updatedDeductions;
        }
        $datas[] = $totalDeductions;
        return $datas;
    }

    public function SendEmails()
    {
        //
    }
}
