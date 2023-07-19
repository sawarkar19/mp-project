<?php

namespace App\Http\Controllers\Business\Partner;

use DB;
use Auth;

use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\State;
use App\Models\Coupon;
use App\Models\Option;
use App\Mail\OrderMail;
use App\Models\Channel;

use App\Models\Feature;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Recharge;
use App\Models\Userplan;
use App\Models\DirectPost;
use App\Models\Useroption;
use App\Models\PaymentLink;
use App\Models\Transaction;
use App\Models\UserChannel;
use App\Models\AdminMessage;

use App\Models\Categorymeta;
use App\Models\UserEmployee;
use App\Models\BeforePayment;

use App\Models\MessageWallet;

use App\Models\BusinessDetail;
use App\Helper\Subscription\PayU;

use App\Helper\Subscription\Paytm;

use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\Instamojo;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\Business\CommonSettingController;

class TransactionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('business');
    }

    public function index()
    {

        $plans = Transaction::where('enterprise_id',Auth::id())->where('transaction_amount', '>', 0)->where('transaction_type','plan')->orderBy('id','desc')->latest()->paginate(10);
// dd($plans);
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('partner.transactions.history',compact('plans','notification_list','planData'));
    }


    public function viewHistory($id)
    {
        
        // $post= Transaction::with('method','userplans')->withCount('employee','direct_post')->where('id',$id)->orderBy('id','desc')->first();
        $post= Transaction::with('method','userplans')->where('id',$id)->orderBy('id','desc')->first();
        // dd($post);

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($post->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);

                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            
            $rechangeInfo = $plan->recharge_info;
        }

        $post->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();

        $employee_price = Option::where('key', 'employee_price')->first();
        
        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();
        
        if(!empty($post) && $post->enterprise_id == Auth::id()){
            //notification_list
            $notification_list = CommonSettingController::getNotification();
            $planData = CommonSettingController::getBusinessPlanDetails();
            
            // return view('business.plan.view-history',compact('post','notification_list','planData','plan_period'));
            return view('partner.transactions.view-history',compact('post','notification_list','planData','plan_period', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'));
        }else{
            abort(404);
        }
    }

    public function downloadHistory($id)
    {
       
        $transaction= Transaction::with('method','userplans','state')->where('id',$id)->orderBy('id','desc')->first();

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);
                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();

        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();

        if(!empty($transaction) && $transaction->enterprise_id == Auth::id()){
            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);

            $pdf = \PDF::loadView('partner.transactions.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            #return $pdf->stream('invoice.pdf');
            return $pdf->download('invoice.pdf');
        }else{
            abort(404);
        }
    }

    public function viewInvoice($id)
    {
        
        $transaction= Transaction::with('method','userplans','state')->where('id',$id)->orderBy('id','desc')->first();

        $channel_ids =[];
        $count_free_paid_employee_ids=0;
        $empPlanData=$rechangeInfo=[];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(",", $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if(!empty($plan->free_employee_ids)){
                $free_employee_ids = explode(",", $plan->free_employee_ids);
                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if($plan->paid_employee_ids){
                $paid_employee_ids = explode(",", $plan->paid_employee_ids);
                if(count($paid_employee_ids)>0){
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData=$plan->plan_info;
            }
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')->whereIn('id', $channel_ids)->get();

        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();

        if(!empty($transaction) && $transaction->enterprise_id == Auth::id()){

            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);
            $pdf = \PDF::loadView('partner.transactions.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            return $pdf->stream('invoice.pdf');
        }else{
            // dd('Not exist!');
            abort(404);
        }
    }

}
