<?php

namespace App\Http\Controllers\Seo;
use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Option;
use App\Exports\UserExport;
use App\Models\Transaction;
use App\Models\UserChannel;
use Illuminate\Http\Request;
use App\Models\BusinessDetail;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Business\CommonSettingController;

class PlanController extends Controller
{
    
    public function planHistory(Request $request ,$id)
    {
        $userid =decrypt($id);
        $plans= Transaction::where('user_id',$userid)->where('transaction_amount', '>', 0)->where('transaction_type','plan')->orderBy('id','desc')->latest()->paginate(10);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('seo.transaction',compact('plans','notification_list','planData'));
    }

    public function viewTransactionHistory($id)
    {
        
        $transaction= Transaction::with('method','userplans')->where('id',$id)->orderBy('id','desc')->first();

        // dd($transaction);

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

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();
        
        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();
        // dd($transaction);
        // dd($id);

        if(!empty($transaction) && $transaction->id == $id){
            //notification_list
            $notification_list = CommonSettingController::getNotification();
            $planData = CommonSettingController::getBusinessPlanDetails();
            
            
            return view('seo.viewTransactionHistory',compact('transaction','notification_list','planData','plan_period', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'));
        }else{
            abort(404);
        }
    }

    public function viewTransactionInvoice($id)
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
        // $transaction->userplans_channel->emp = UserEmployee::whereIsFree(0)->whereUserId(Auth::id())->count();

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months','transactions.user_id')
                        ->first();

        if(!empty($transaction) ){

            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);

            $customPaper = array(0,0,794.00,1123.00);
            $pdf = \PDF::loadView('seo.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            return $pdf->stream('invoice.pdf');
        }else{
            // dd('Not exist!');
            abort(404);
        }
    }

    
    public function downloadTransactionHistory($id)
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
        // $transaction->userplans_channel->emp = UserEmployee::whereIsFree(0)->whereUserId(Auth::id())->count();

        // $users = UserEmployee::with('employee')->where('user_id',Auth::id())->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id',$id)
                        ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                        ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                        ->select('plans.name', 'plans.months')
                        ->first();

        if(!empty($transaction) ){
            $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)->orderBy('id', 'desc')->first();
            $user = User::findorFail($transaction->user_id);
            //dd($business);

            $customPaper = array(0,0,794.00,1123.00);

            $pdf = \PDF::loadView('seo.download-history',compact('transaction','plan_period','business','user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])->setPaper($customPaper, 'portrait');

            #return $pdf->stream('invoice.pdf');
            return $pdf->download('invoice.pdf');
        }else{
            abort(404);
        }
    }

    public function exportUsers(Request $request)
    {
        
        $users = User::with('paidTransaction')
                        ->where('role_id', 2)
                        ->where('status', 1)
                        ->get();

        if (count($users) > 0) {
        
            try {
                $data = [];
                $i = 1;
                foreach($users as $k => $user){

                    if($user->paidTransaction == null){
                        $status = 'FREE';
                    }else{
                        $status = 'PAID';
                    }
                
                    $data[] =
                    [
                        'sr_no' => $i,
                        'mobile' => $user->mobile,
                        'name' => $user->name,
                        'email' => $user->email,
                        'status' => $status,
                        'joined_date' => Carbon::parse($user->created_at)->format("j M, Y"),
                    ];

                    $i++;
                }

                return Excel::download(new UserExport($data), 'Users' . '_' . date('Y_m_d_H_i_s') . '.xlsx');
            } catch(Exception $e) {
                exit($e->getMessage());
            }
        }else{
            return Redirect::back()->with('error_msg', 'Users not found.');
        }
    }
}
