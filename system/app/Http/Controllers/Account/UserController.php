<?php

namespace App\Http\Controllers\Account;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Offer;
use App\Models\Option;
use App\Models\Userplan;
use App\Models\InstantTask;
use App\Models\Transaction;
use App\Models\UserChannel;
use Illuminate\Http\Request;
use App\Models\BusinessDetail;
use App\Models\DeductionHistory;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function user(Request $request)
    {
        /*  active user count and inactive user count start*/
        $activeUser = User::where('status', 1)->count();
        $inactiveUser = User::where('status', 0)->count();
        /*  active user count and inactive user count end*/

        // $today = Carbon::now();
        $paidUser = Transaction::where('transaction_amount', '>', 0)
            ->groupBy('user_id')
            // ->whereDate('created_by', '>=', $today)
            ->get();

            foreach ($paidUser as $key => $User) {
                   $data[] = $User->id;
            }
            $unPaidUser = Transaction::whereNotIn('user_id', $data)->where('transaction_amount', 0)->groupBy('user_id')->get();

            /* all user show data, search and pagination start */
            $conditions = [];
            $numberOfPage = $request->no_of_users ?? 10;
            if (!empty($request->src) && !empty($request->term)) {
                $allUsers = User::where('role_id', 2)->where($request->term, 'like', '%'. $request->src . '%' )->paginate($numberOfPage);
            $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
            } else{
                $allUsers = User::where('role_id', 2)->orderBy('id', 'DESC')->paginate($request->no_of_users);
            }
            /* all user show data, search and pagination end */

        return view('account.users.user', compact('activeUser', 'inactiveUser', 'paidUser', 'unPaidUser', 'allUsers', 'conditions', 'request'));

    }

    public function userShow(Request $request, $id){
        $id = decrypt($id);
        $allUsers = User::with('getRedeemedCustomers','getShareSubscriptions','getInstantSubscriptions','getUniqueClicks','getExtraClicks','getOffersList','getRedeemedCodeSent','getCompletedTasks','employees')->whereId($id)->first();

        $offers = $allUsers->getOffersList()->paginate(10 , ['*'], 'offer_page', $request->offer_page);

        $instantTasks = InstantTask::join('tasks', 'tasks.id', '=', 'instant_tasks.task_id')
                                    ->where('instant_tasks.user_id', '=', $id)
                                    ->where('tasks.status', '=', 1)
                                    ->count();

        $socilPosts = Offer::with('unique_clicks', 'extra_clicks','getTwitterClicks','getFacebookClicks')
                            ->join('instant_tasks', 'instant_tasks.offer_id', '=', 'offers.id')
                            ->select('offers.*', 'instant_tasks.created_at as created') 
                            ->where('offers.user_id', '=', $id)
                            ->where('offers.status', '=', 1)
                            ->paginate(10, ['*'], 'social_post_page', $request->social_post_page);

        $deductionHistory = DeductionHistory::with('getUserDeductionReport','user','deduction','businessCustomer','getEmployees')
                                            ->whereUserId($id)
                                            ->paginate(10, ['*'], 'deduction_page', $request->deduction_page);

        $employees = $allUsers->employees()->paginate(10 , ['*'], 'employee_page', $request->employee_page);;

        return view('account.users.usershow', compact('allUsers','offers','instantTasks','socilPosts','deductionHistory','request','employees'));
    }

    public function planHistory($user_id)
    {
        $user_id = decrypt($user_id);

        $plans= Transaction::where('user_id',$user_id)->where('transaction_amount', '>', 0)->where('transaction_type','plan')->orderBy('id','desc')->latest()->paginate(10);

        return view('account.users.history',compact('plans'));
    }

    public function viewHistory($id)
    {
        
        $transaction= Transaction::with('method','userplans')->where('id',$id)->orderBy('id','desc')->first();

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
        // dd($plan_period);

        if(!empty($transaction)){
            return view('account.users.view-history',compact('transaction','plan_period', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'));
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

        if(!empty($transaction)){
            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);

            $pdf = \PDF::loadView('account.users.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

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

        if(!empty($transaction)){

            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);
            $pdf = \PDF::loadView('account.users.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            return $pdf->stream('invoice.pdf');
        }else{
            // dd('Not exist!');
            abort(404);
        }
    }
}
