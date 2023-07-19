<?php

namespace App\Http\Controllers\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function dashboard()
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-04-01 00:00:00');
        $end_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-03-31 23:59:59');
        if (now() < $start_date) {
            $start_date = date('Y', strtotime('-1 year', strtotime($start_date)));
            $end_date = date('Y', strtotime($end_date));
        } else {
            $start_date = date('Y', strtotime($start_date));
            $end_date = date('Y', strtotime('+1 year', strtotime($end_date)));
        }
         
        /* all transaction count and user count start */
        $transactionCount = Transaction::where('transaction_amount', '>', 0)
            ->where('status', 1)
            ->count();
        $userCount = User::where('role_id', 2)
            ->where('status', 1)
            ->count();
        /* all transaction count and user count end */    
        $transactionAmount = Transaction::where('status', 1)
            ->select('transaction_amount')
            ->get();
        $total = 0;

        foreach ($transactionAmount as $key => $amount) {
            $total = $amount['transaction_amount'] + $total;
        }

        /*graph transaction data start*/
        $chartData = $this->last7days();
        $chartDates = $chartData['labels'];
        $totalTransaction = $chartData['data'];
        /*graph transaction  data end*/

        return view('account.dashboard', compact('start_date', 'end_date', 'transactionCount', 'userCount', 'transactionAmount', 'total', 'chartDates', 'totalTransaction'));
    }

    public function currentLast7days()
    {
        $labels = $this->getSevenDaysLb();
        $data = $this->getCurrent7DayRecords();

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
        $user = Auth::user();
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

        $datas = $dailyTotalTransactions;
        return $datas;
        /* daily transaction data end */
    }

    public function getCurrent7DayRecords()
    {
        $user = Auth::user();
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
            $dailyTransactions = Transaction::where('created_at', 'LIKE', Carbon::parse($day)->format('Y-m-d') . '%')
                ->where('status', 1)
                ->select('transaction_amount')
                ->get();
            $updatedTotalTransactions = 0;

            foreach ($dailyTransactions as $key => $amount) {
                $updatedTotalTransactions = $amount['transaction_amount'] + $updatedTotalTransactions;
            }

            $dailyTotalTransactions[] = $updatedTotalTransactions;
        }

        $datas[] = $dailyTotalTransactions;

        return $datas;
        /* daily transaction data end */
    }
}
