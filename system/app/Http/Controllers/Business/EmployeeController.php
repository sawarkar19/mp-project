<?php

namespace App\Http\Controllers\Business;

use Auth;
use Hash;
use DeductionHelper;

use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\DeductionHistory;

use App\Jobs\DeductActiveEmployeeCostJob;

use App\Models\Userplan;
use App\Models\RedeemDetail;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use App\Models\BusinessCustomer;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Business\CommonSettingController;
use Carbon\Carbon;


class EmployeeController extends Controller
{
    protected $request;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
       $this->middleware('business');
    }

    public function checkEmployeeLogin(Request $request){
        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'employee_login_cost');

        if($request->type == "checkBalance"){
            $checkWalletBalance = DeductionHelper::checkWalletBalance(Auth::id(), $deductionDetail->id);
            return $checkWalletBalance;
        }else if($request->type == "checkDeductions"){
            $today = Date('Y-m-d');
            
            // Get Active Employee
            $activeEmployeesCount = User::where('role_id', 3)->where('created_by', Auth::id())->where('status', 1)->count();

            // Get today number of employee deduct count
            $deductedEmpCount = DeductionHistory::where('deduction_id', $deductionDetail->id)->where('user_id', Auth::id())->whereDate('created_at', $today)->count();
            
            $form_type = $request->form_type;
            if($form_type=="addUser"){
                // dd($deductedEmpCount, $activeEmployeesCount);
                if($deductedEmpCount <= $activeEmployeesCount){
                    return ['status'=>true, 'code'=>'deduction_popup_show'];
                }else{
                    return ['status'=>false, 'code'=>'deduction_popup_hide'];    
                }
            }else{
                // dd($deductedEmpCount, $activeEmployeesCount);
                if($deductedEmpCount <= $activeEmployeesCount){
                    return ['status'=>true, 'code'=>'deduction_popup_show'];
                }else{
                    return ['status'=>false, 'code'=>'deduction_popup_hide'];
                }
            }
        }else{
            return [ 'status' => false, 'message' => 'none' ];
        }
    }
    
    public function index(Request $request)
    {

        $type=$request->type ?? 'all';

        $term = $request->term;
        if (!empty($request->src) && !empty($request->term)) {
            if ($type === 'all') {
                $employees=User::where('role_id',3)->where('created_by', Auth::id())->where($request->term, 'like','%'.$request->src.'%')->latest()->paginate(20);
            }
            else{
                $employees=User::where('role_id',3)->where('created_by', Auth::id())->where('status',$type)->where($request->term, 'like','%'.$request->src.'%')->latest()->paginate(20);
            }
        }
        else{  
            if ($type === 'all') { 
                $employees=User::where('role_id',3)->where('created_by', Auth::id())->latest()->paginate(20);
            }
            else{
                $employees=User::where('role_id',3)->where('created_by', Auth::id())->where('status',$type)->latest()->paginate(20);
            }
        }

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.employee.index',compact('employees','request','type', 'term','notification_list','planData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        /* $userEmployee = UserEmployee::whereNull('employee_id')->where('user_id', Auth::id())->first();
        if($userEmployee == null){
            return Redirect::to('/business/employee');
        } */

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'employee_login_cost');

        return view('business.employee.create', compact('notification_list', 'planData', 'deductionDetail'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10',
            'password' => 'required'
        ]);

        $exist = User::where('mobile',$request->mobile)->first();
        if($exist != null){
            return response()->json(["success" => false, "message" => 'Mobile number already exists']);
        }   

        $user = new User;
        $user->name = ucwords($request->name);
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->status = $request->status ?? 1;
        $user->role_id = 3;
        $user->created_by = Auth::user()->id;
        $user->save(); 

        // Deduct Active Employees Cost
        if($request->status == 1){
            dispatch(new DeductActiveEmployeeCostJob(Auth::id()));
        }

        $url = route('business.employee.index');

        return response()->json(["success" => true, "message" => 'User Created Successfully', 'url' => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee_info= User::where([
                            ['id', $id],
                            ['role_id',3]
                        ])->with(['bussiness_details', 'employee_details'])->first();
        $total_shares = OfferSubscription::where('created_by', $employee_info->id)->count();
        $total_redeems = RedeemDetail::where('redeem_by', $employee_info->id)->count();
        
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.employee.show',compact(['employee_info','total_shares', 'total_redeems','notification_list','planData']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info=User::findorFail($id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'employee_login_cost');

        return view('business.employee.edit',compact('info','notification_list', 'planData', 'deductionDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'name' => 'required|max:50',
			'mobile' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10',
        ]);

        $exist = User::where('mobile',$request->mobile)->where('id', '!=', $id)->orderBy('id', 'desc')->first();
        if($exist != null){
            return response()->json(["success" => false, "message" => 'Mobile number already exists']);
        }

        $user=User::findorFail($id);
        $user->name=$request->name;
        $user->mobile = $request->mobile;

        if ($request->password) {
            $user->password=Hash::make($request->password);
        }
        $user->status=$request->status;
        $user->save();

        // Deduct Active Employees Cost
        if($request->status == 1){
            dispatch(new DeductActiveEmployeeCostJob(Auth::id()));
        }

        $url = route('business.employee.index');

        return response()->json(["success" => true, "message" => 'User Updated Successfully', 'url' => $url]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!empty($request->method)) {
            if ($request->method=="delete") {
                foreach ($request->ids ?? [] as $key => $id) {
                   $user=User::destroy($id);
                }
            }
            else{
                foreach ($request->ids ?? [] as $key => $id) {
                   $user=User::find($id);

                   if ($request->method=="trash") {
                        $user->status=0;
                   }
                   else{
                        $user->status=$request->method;
                   }

                   $user->save();
                }
            }
        }

        return response()->json(['Success']);
    }

    public function checkEmployeeLimit(){

    }
}