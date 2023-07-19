<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Plan;
use App\Models\Userplan;
use App\Models\Target;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

class GraphController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware('account');
    }

    public function user(){

        $user = Auth::user();
        return $user;

    }

    public function getSevenDaysLb()
    {
        $w7 = Carbon::now()->subDays(6)->format('d M');
        $w6 = Carbon::now()->subDays(5)->format('d M');
        $w5 = Carbon::now()->subDays(4)->format('d M');
        $w4 = Carbon::now()->subDays(3)->format('d M');
        $w3 = Carbon::now()->subDays(2)->format('d M');
        $w2 = Carbon::now()->subDays(1)->format('d M');
        $w1 = Carbon::now()->format('d M');

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }

    public function getLastMonthLb()
    {
        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
        for($i = 1; $i<=$count;$i++)
        { 
            $labels[] = $i.' '.$month; 
            // dd($month);
        }

        return $labels;
    }

    public function getThisMonthLb()
    {
        $currentMonth = Carbon::now();
        $count = $currentMonth->day;
        $month = Carbon::parse($currentMonth)->format("M");
        for($i = 1; $i<=$count;$i++)
        { 
            $labels[] = $i.' '.$month;
        }

        return $labels;
    }

    public function getLastTwelveMonthLb()
    {
        $w12 = Carbon::now()->subMonths(12)->format('M Y');
        $w11 = Carbon::now()->subMonths(11)->format('M Y');
        $w10 = Carbon::now()->subMonths(10)->format('M Y');
        $w9 = Carbon::now()->subMonths(9)->format('M Y');
        $w8 = Carbon::now()->subMonths(8)->format('M Y');
        $w7 = Carbon::now()->subMonths(7)->format('M Y');
        $w6 = Carbon::now()->subMonths(6)->format('M Y');
        $w5 = Carbon::now()->subMonths(5)->format('M Y');
        $w4 = Carbon::now()->subMonths(4)->format('M Y');
        $w3 = Carbon::now()->subMonths(3)->format('M Y');
        $w2 = Carbon::now()->subMonths(2)->format('M Y');
        $w1 = Carbon::now()->subMonths(1)->format('M Y');

        $labels = [$w12,$w11,$w10,$w9,$w8,$w7,$w6,$w5,$w4,$w3,$w2,$w1];

        return $labels;
    }

    public function get7DayRecords(){

        $user = $this->user();
        $now = Carbon::today();

        $w7 = Carbon::now()->subDays(6);
        $w6 = Carbon::now()->subDays(5);
        $w5 = Carbon::now()->subDays(4);
        $w4 = Carbon::now()->subDays(3);
        $w3 = Carbon::now()->subDays(2);
        $w2 = Carbon::now()->subDays(1);
        $w1 = Carbon::now();

        $labels = [$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        $datas = array();

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

    public function getThisMonthRecords(){

        $user = $this->user();
        $now = Carbon::today();

        $currentMonth = Carbon::now();
        $count = $currentMonth->day;
        $month = Carbon::parse($currentMonth)->format("M");
        for($i = 1; $i<=$count;$i++)
        { 
            $labels[] = $i.' '.$month; 
            // dd($month);
        }
        
        $datas = array();

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

    public function getMonthRecords(){

        $user = $this->user();
        $now = Carbon::today();

        $previousMonth = Carbon::now()->subMonths(1);
        $count = $previousMonth->daysInMonth;
        $month = Carbon::parse($previousMonth)->format("M");
        for($i = 1; $i<=$count;$i++)
        { 
            $labels[] = $i.' '.$month; 
            // dd($month);
        }
        
        $datas = array();

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

    public function get12MonthRecords(){

        $user = $this->user();
        $now = Carbon::today();

        $w12 = Carbon::now()->subMonths(12);
        $w11 = Carbon::now()->subMonths(11);
        $w10 = Carbon::now()->subMonths(10);
        $w9 = Carbon::now()->subMonths(9);
        $w8 = Carbon::now()->subMonths(8);
        $w7 = Carbon::now()->subMonths(7);
        $w6 = Carbon::now()->subMonths(6);
        $w5 = Carbon::now()->subMonths(5);
        $w4 = Carbon::now()->subMonths(4);
        $w3 = Carbon::now()->subMonths(3);
        $w2 = Carbon::now()->subMonths(2);
        $w1 = Carbon::now()->subMonths(1);

        $labels = [$w12,$w11,$w10,$w9,$w8,$w7,$w6,$w5,$w4,$w3,$w2,$w1];
        // dd($labels);

        $datas = array();

        /* daily transaction data start */
        $dailyTotalTransactions = [];
        foreach ($labels as $day) {
            $start_date = Carbon::parse($day)->startOfMonth()->format("Y-m-d");
            $end_date = Carbon::parse($day)->endOfMonth()->format("Y-m-d");

            $dailyTransactions = Transaction::where('transaction_amount', '>', 0)
                ->whereBetween('created_at', [$start_date." 00:00:00", $end_date." 23:59:59"])
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

    public function getLast7days()
    {

        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();
        $label= 'Visits';
        $borderWidth= 5;
        $borderColor= '#6777ef';
        $backgroundColor= 'transparent';
        $pointBackgroundColor= '#fff';
        $pointBorderColor= '#6777ef';
        $pointRadius= 4;

        $datasets = [
            'label'=> $label,
            'data'=> $data,
            'borderWidth'=> $borderWidth,
            'borderColor'=> $borderColor,
            'backgroundColor'=> $backgroundColor,
            'pointBackgroundColor'=> $pointBackgroundColor,
            'pointBorderColor'=> $pointBorderColor,
            'pointRadius'=> $pointRadius,
        ];
        
        return response()->json(
            [
                'labels'=>$labels,
                'datasets'=>$datasets,
                'max'=> max($data),
                'min'=> min($data)
            ]
        );
    }

    public function last7days()
    {
    
        $labels = $this->getSevenDaysLb();
        $data = $this->get7DayRecords();
        
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }

    public function lastMonth()
    {
        
        $labels = $this->getLastMonthLb();
        $data = $this->getMonthRecords();
        // dd($data);
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }

    public function thisMonth()
    {
        
        $labels = $this->getThisMonthLb();
        $data = $this->getThisMonthRecords();
        // dd($data);
        return response()->json(
            [
                'labels'=>$labels,
                'data'=>$data
            ]
        );
    }

    public function lastTwelveMonth(){
        $labels = $this->getLastTwelveMonthLb();
        $data = $this->get12MonthRecords();
        
        return response()->json(['labels'=>$labels, 'data'=>$data, 'max'=> max($data), 'min'=> min($data)]);
    }

}