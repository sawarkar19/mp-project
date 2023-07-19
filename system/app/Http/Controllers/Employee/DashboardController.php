<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;

use App\Models\Offer;
use App\Models\Transaction;
use App\Models\RedeemDetail;
use Illuminate\Http\Request;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('employee');
    }
	
	public function index()
    {
        
        $employee_info = User::where([
            ['id', Auth::id()],
            ['role_id',3],
            ['status',1]
        ])->with(['bussiness_details', 'employee_details'])->orderBy('id', 'desc')->first();

        $total_shares = OfferSubscription::where('created_by', $employee_info->id)->count();
        $total_redeems = RedeemDetail::where('redeem_by', $employee_info->id)->count();

        /* Current Offer */
        $today = date("Y-m-d");
        $current_offer = Offer::where('user_id',Auth::user()->created_by)->where('start_date', '<=', $today)->where('end_date', '>=', $today)->where('status', 1)->first();

        if($current_offer == null){
            /* find upcoming if no current offer available */
            $current_offer = Offer::where('user_id',Auth::user()->created_by)->where('start_date', '>', $today)->where('status', 1)->orderBy('start_date', 'asc')->first();
        }

        $is_posted = 0;
        if($current_offer != ''){
            $is_posted = $current_offer->social_post__db_id ? 1 : 0;
        }

        return view('employee.dashboard', compact('employee_info', 'total_shares', 'total_redeems','current_offer','is_posted'));
    }

    public function thankYou(Request $request)
    {
        if(!Session::has('payment_info')){
            return redirect()->route('employee.dashboard');
        }

        $user = Auth::User();
        $paymentData = Session::get('payment_info');
        $transaction = Transaction::where('transaction_id', $paymentData['payment_id'])->first();
        
        Session::forget('payment_info');
        
        return view('employee.payment-success', compact('user', 'paymentData', 'transaction'));
    }
}
