<?php

namespace App\Http\Controllers\Account;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function report(Request $request)
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-04-01 00:00:00');
        $end_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-03-31 23:59:59');
        if (now() < $start_date) {

            /* financial date start */
            $financial_start_date = date('d-m-Y', strtotime('-1 year', strtotime($start_date)));
            $financial_end_date = date('d-m-Y', strtotime($end_date));
            /* financial date end */

            $start_date = date('Y-m-d', strtotime('-1 year', strtotime($start_date)));
            $end_date = date('Y-m-d', strtotime($end_date));

            if (!empty($request->date)) {
                $date = $request->date;
                $explode_id = explode(' - ', $date);

                $sequenceStartDate = date('Y-m-d', strtotime($explode_id[0]));
                $sequenceEndDate = date('Y-m-d', strtotime($explode_id[1]));

                $totalTransactionCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('transaction_amount', '>', 0)
                    ->where('status', 1)
                    ->count();

                $totaltransactionAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('status', 1)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                $total = 0;

                foreach ($totaltransactionAmount as $key => $amount) {
                    $total = $amount['transaction_amount'] + $total;
                }

                $totalGst = ($total / 100) * 18;

                /* total amount payment gateways start */
                $cashfreeTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                $totalCashfree = 0;
                foreach ($cashfreeTotalAmount as $cashfree) {
                    $totalCashfree = $cashfree['transaction_amount'] + $totalCashfree;
                }
                $cashfreePercentage = ($totalCashfree / $total) * 100;

                $razorpayTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalRazorpay = 0;
                    foreach ($razorpayTotalAmount as $razorpay) {
                        $totalRazorpay = $razorpay['transaction_amount'] + $totalRazorpay;
                    }
                    $razorpayPercentage = ($totalRazorpay / $total) * 100;    

                $paypalTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                     
                    $totalPaypal = 0;
                foreach ($paypalTotalAmount as $paypal) {
                    $totalPaypal = $paypal['transaction_amount'] + $totalPaypal;
                }
                $paypalPercentage = ($totalPaypal / $total) * 100;    

                    
                $paytmTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalPaytm = 0;
                foreach ($paytmTotalAmount as $paytm) {
                    $totalPaytm = $paytm['transaction_amount'] + $totalPaytm;
                }
                $paytmPercentage = ($totalPaytm / $total) * 100;    


                $chequeTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalCheque = 0;
                foreach ($chequeTotalAmount as $cheque) {
                    $totalCheque = $cheque['transaction_amount'] + $totalCheque;
                }
                $chequePercentage = ($totalCheque / $total) * 100;  
                
                $nftTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalNft = 0;
                foreach ($nftTotalAmount as $nft) {
                    $totalNft = $nft['transaction_amount'] + $totalNft;
                }
                $nftPercentage = ($totalNft / $total) * 100;

                /* total amount payment gateways end */

                /* transaction data show, search and pagination  start*/

                $conditions = [];
                $numberOfPage = $request->no_of_users ?? 10;

                if (!empty($request->src) && !empty($request->term)) {
                    $transactions = Transaction::select('transactions.*')
                        ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->where($request->term, 'like', '%' . $request->src . '%')
                        ->whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                        ->orderBy('id', 'DESC')
                        ->paginate($numberOfPage);
                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                } else {
                    $transactions = Transaction::where('status', 1)
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                        ->orderBy('id', 'DESC')
                        ->paginate($request->no_of_users);
                }
                /* transaction data show, search and pagination  start*/

                /* graph counts data start */
                $cashfreeCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $razorpayCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paypalCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paytmCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $chequeCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $nftCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();    
                /* graph counts data end */
            } else {
                $totalTransactionCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('transaction_amount', '>', 0)
                    ->where('status', 1)
                    ->count();

                $totaltransactionAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('status', 1)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                $total = 0;

                foreach ($totaltransactionAmount as $key => $amount) {
                    $total = $amount['transaction_amount'] + $total;
                }

                $totalGst = ($total / 100) * 18;

                /* total amount payment gateways start */
                $cashfreeTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                $totalCashfree = 0;
                foreach ($cashfreeTotalAmount as $cashfree) {
                    $totalCashfree = $cashfree['transaction_amount'] + $totalCashfree;
                }
                $cashfreePercentage = ($totalCashfree / $total) * 100;

                $razorpayTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalRazorpay = 0;
                    foreach ($razorpayTotalAmount as $razorpay) {
                        $totalRazorpay = $razorpay['transaction_amount'] + $totalRazorpay;
                    }
                $razorpayPercentage = ($totalRazorpay / $total) * 100;


                $paypalTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                     
                    $totalPaypal = 0;
                foreach ($paypalTotalAmount as $paypal) {
                    $totalPaypal = $paypal['transaction_amount'] + $totalPaypal;
                }
                $paypalPercentage = ($totalPaypal / $total) * 100;

                    
                $paytmTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalPaytm = 0;
                foreach ($paytmTotalAmount as $paytm) {
                    $totalPaytm = $paytm['transaction_amount'] + $totalPaytm;
                }
                $paytmPercentage = ($totalPaytm / $total) * 100;

                $chequeTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalCheque = 0;
                foreach ($chequeTotalAmount as $cheque) {
                    $totalCheque = $cheque['transaction_amount'] + $totalCheque;
                }
                $chequePercentage = ($totalCheque / $total) * 100;

                $nftTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalNft = 0;
                foreach ($nftTotalAmount as $nft) {
                    $totalNft = $nft['transaction_amount'] + $totalNft;
                }
                $nftPercentage = ($totalNft / $total) * 100;
                /* total amount payment gateways end */

                /* transaction data show, search and pagination  start*/

                $conditions = [];
                $numberOfPage = $request->no_of_users ?? 10;
                if (!empty($request->src) && !empty($request->term)) {
                    $transactions = Transaction::select('transactions.*')
                        ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->where($request->term, 'like', '%' . $request->src . '%')
                        // ->where('created_at', '>', $start_date)
                        // ->where('created_at', '<', $end_date)
                        ->orderBy('id', 'DESC')
                        ->paginate($numberOfPage);
                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                } else {
                    $transactions = Transaction::where('status', 1)
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('id', 'DESC')
                        ->paginate($request->no_of_users);
                }
                /* transaction data show, search and pagination  start*/

                /* graph counts data start */
                $cashfreeCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $razorpayCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paypalCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paytmCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $chequeCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $nftCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();    
                /* graph counts data end */
            }
        } else {
            $financial_start_date = date('d-m-Y', strtotime($start_date));
            // dd($start_date);
            $financial_end_date = date('d-m-Y', strtotime('+1 year', strtotime($end_date)));

            $start_date = date('Y-m-d', strtotime($start_date));
            // dd($start_date);
            $end_date = date('Y-m-d', strtotime('+1 year', strtotime($end_date)));

            if (!empty($request->date)) {
                $date = $request->date;
                $explode_id = explode(' - ', $date);

                $sequenceStartDate = date('Y-m-d', strtotime($explode_id[0]));
                $sequenceEndDate = date('Y-m-d', strtotime($explode_id[1]));

                $totalTransactionCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('transaction_amount', '>', 0)
                    ->where('status', 1)
                    ->count();

                $totaltransactionAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('status', 1)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                $total = 0;

                foreach ($totaltransactionAmount as $key => $amount) {
                    $total = $amount['transaction_amount'] + $total;
                }

                $totalGst = ($total / 100) * 18;
                /* total amount payment gateways start */
                $cashfreeTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                $totalCashfree = 0;
                foreach ($cashfreeTotalAmount as $cashfree) {
                    $totalCashfree = $cashfree['transaction_amount'] + $totalCashfree;
                }
                $cashfreePercentage = ($totalCashfree / $total) * 100;

                $razorpayTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalRazorpay = 0;
                    foreach ($razorpayTotalAmount as $razorpay) {
                        $totalRazorpay = $razorpay['transaction_amount'] + $totalRazorpay;
                    }
                    $razorpayPercentage = ($totalRazorpay / $total) * 100;    

                $paypalTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                     
                    $totalPaypal = 0;
                foreach ($paypalTotalAmount as $paypal) {
                    $totalPaypal = $paypal['transaction_amount'] + $totalPaypal;
                }
                $paypalPercentage = ($totalPaypal / $total) * 100;
                    
                $paytmTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalPaytm = 0;
                foreach ($paytmTotalAmount as $paytm) {
                    $totalPaytm = $paytm['transaction_amount'] + $totalPaytm;
                }
                $paytmPercentage = ($totalPaytm / $total) * 100;

                $chequeTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalCheque = 0;
                foreach ($chequeTotalAmount as $cheque) {
                    $totalCheque = $cheque['transaction_amount'] + $totalCheque;
                }
                $chequePercentage = ($totalCheque / $total) * 100;

                $nftTotalAmount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalNft = 0;
                foreach ($nftTotalAmount as $nft) {
                    $totalNft = $nft['transaction_amount'] + $totalNft;
                }
                $nftPercentage = ($totalNft / $total) * 100;
                /* total amount payment gateways end */

                /* transaction data show, search and pagination  start*/
                $conditions = [];
                $numberOfPage = $request->no_of_users ?? 10;

                if (!empty($request->src) && !empty($request->term)) {
                    $transactions = Transaction::select('transactions.*')
                        ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->where($request->term, 'like', '%' . $request->src . '%')
                        ->whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                        ->orderBy('id', 'DESC')
                        ->paginate($numberOfPage);
                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                } else {
                    $transactions = Transaction::where('status', 1)
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        // ->has('user')
                        ->whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                        ->orderBy('id', 'DESC')
                        ->paginate($request->no_of_users);
                }
                /* transaction data show, search and pagination  end*/
                /* graph counts data start */
                $cashfreeCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $razorpayCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paypalCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paytmCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $chequeCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $nftCount = Transaction::whereBetween('created_at', [$sequenceStartDate, $sequenceEndDate])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();
                /* graph counts data end */
            } else {
                $totalTransactionCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('transaction_amount', '>', 0)
                    ->where('status', 1)
                    ->count();
                // dd($totalTransactionCount);

                $totaltransactionAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('status', 1)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                $total = 0;

                foreach ($totaltransactionAmount as $key => $amount) {
                    $total = $amount['transaction_amount'] + $total;
                }

                $totalGst = ($total / 100) * 18;

                /* total amount payment gateways start */
                $cashfreeTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                $totalCashfree = 0;
                foreach ($cashfreeTotalAmount as $cashfree) {
                    $totalCashfree = $cashfree['transaction_amount'] + $totalCashfree;
                }
                $cashfreePercentage = ($totalCashfree / $total) * 100;
                
                $razorpayTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalRazorpay = 0;
                    foreach ($razorpayTotalAmount as $razorpay) {
                        $totalRazorpay = $razorpay['transaction_amount'] + $totalRazorpay;
                    } 
                    $razorpayPercentage = ($totalRazorpay / $total) * 100;       

                $paypalTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();
                     
                    $totalPaypal = 0;
                foreach ($paypalTotalAmount as $paypal) {
                    $totalPaypal = $paypal['transaction_amount'] + $totalPaypal;
                }
                $paypalPercentage = ($totalPaypal / $total) * 100;
                    
                $paytmTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalPaytm = 0;
                foreach ($paytmTotalAmount as $paytm) {
                    $totalPaytm = $paytm['transaction_amount'] + $totalPaytm;
                }
                $paytmPercentage = ($totalPaytm / $total) * 100;

                $chequeTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalCheque = 0;
                foreach ($chequeTotalAmount as $cheque) {
                    $totalCheque = $cheque['transaction_amount'] + $totalCheque;
                }
                $chequePercentage = ($totalCheque / $total) * 100;

                $nftTotalAmount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->get();

                    $totalNft = 0;
                foreach ($nftTotalAmount as $nft) {
                    $totalNft = $nft['transaction_amount'] + $totalNft;
                }
                $nftPercentage = ($totalNft / $total) * 100;
                /* total amount payment gateways end */

                /* transaction data show, search and pagination  start*/
                $conditions = [];
                $numberOfPage = $request->no_of_users ?? 10;
                if (!empty($request->src) && !empty($request->term)) {
                    $transactions = Transaction::select('transactions.*')
                        ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->where($request->term, 'like', '%' . $request->src . '%')
                        // ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('id', 'DESC')
                        ->paginate($numberOfPage);

                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                } else {
                    $transactions = Transaction::with('user')
                        // ->has('user')
                        ->where('transaction_amount', '>', 0)
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->where('status', 1)
                        ->orderBy('id', 'DESC')
                        ->paginate($request->no_of_users);
                    // dd($transactions);
                }
                /* transaction data show, search and pagination  start*/

                /* graph counts data start */
                $cashfreeCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 12)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $razorpayCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 4)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paypalCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 5)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $paytmCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 14)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $chequeCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 17)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();

                $nftCount = Transaction::whereBetween('created_at', [$start_date, $end_date])
                    ->where('category_id', 15)
                    ->where('transaction_amount', '>', 0)
                    ->select('transaction_amount')
                    ->count();    
                /* graph counts data end */
            }
        }

        $data = [$razorpayCount, $cashfreeCount, $paypalCount, $paytmCount, $chequeCount, $nftCount];

        return view('account.reports.report', compact('transactions', 'conditions', 'request', 'start_date', 'end_date', 'totalTransactionCount', 'totaltransactionAmount', 'total', 'totalGst', 'cashfreeTotalAmount', 'totalCashfree', 'razorpayTotalAmount', 'totalRazorpay', 'paypalTotalAmount', 'totalPaypal', 'paytmTotalAmount', 'totalPaytm', 'chequeTotalAmount', 'totalCheque', 'financial_start_date', 'financial_end_date', 'data', 'cashfreePercentage', 'razorpayPercentage', 'paypalPercentage', 'paytmPercentage', 'chequePercentage', 'nftTotalAmount', 'nftPercentage', 'totalNft'));
    }

    public function exportReportList(Request $request)
    {
        $start_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-04-01 00:00:00');
        $end_date = Carbon::createFromFormat('Y-m-d H:s:i', date('Y') . '-03-31 23:59:59');

        if (now() < $start_date) {
            $financial_start_date = date('d-m-Y', strtotime('-1 year', strtotime($start_date)));
            $financial_end_date = date('d-m-Y', strtotime($end_date));
            /* financial date end */

            $start_date = date('Y-m-d', strtotime('-1 year', strtotime($start_date)));
            $end_date = date('Y-m-d', strtotime($end_date));

        }else {
            $financial_start_date = date('d-m-Y', strtotime($start_date));
            // dd($start_date);
            $financial_end_date = date('d-m-Y', strtotime('+1 year', strtotime($end_date)));

            $start_date = date('Y-m-d', strtotime($start_date));
            // dd($start_date);
            $end_date = date('Y-m-d', strtotime('+1 year', strtotime($end_date)));
        }

        if (!empty($request->date)) {
            $date = $request->date;
            $explode_id = explode(' - ', $date);

            $start_date = date('Y-m-d', strtotime($explode_id[0]));
            $end_date = date('Y-m-d', strtotime($explode_id[1]));
        }
        $transactions = Transaction::where('status', 1)
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('id', 'DESC')
                        ->paginate($request->no_of_users);
        if($request->export == "export"){
            $transactions = Transaction::where('status', 1)
                        ->where('transaction_amount', '>', 0)
                        ->with('user')
                        ->has('user')
                        ->whereBetween('created_at', [$start_date, $end_date])
                        ->orderBy('id', 'DESC')
                        ->get();
            $data = [];
            $i = 1;
            foreach($transactions as $key => $transaction){
                $data[] =
                    [
                        'sr_no' => $i,
                        'name' => $transaction->user->name ?? 'Customer',
                        'invoice_no' => $transaction->invoice_no,
                        'date' => \Carbon\Carbon::parse($transaction->created_at)->format('d M Y'),
                        'transaction_id' => $transaction->transaction_id,
                        'transaction_amount' => $transaction->transaction_amount,
                        'gst_claim' => $transaction->gst_claim == 1 ? 'Yes' : 'No'
                    ];
                $i++;
            }
            return Excel::download(new TransactionExport($data), 'transaction-report'.now().'.xlsx');
        }else{
            return view('account.reports.export-reports', compact('transactions','request','financial_start_date', 'financial_end_date'));
        }
    }
}
