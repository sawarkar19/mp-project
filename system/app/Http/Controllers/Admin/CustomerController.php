<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;

use App\Helper\Subscription\Instamojo;
use App\Helper\Subscription\Cashfree;
use App\Helper\Subscription\PayU;
use App\Helper\Subscription\Paytm;


use App\Models\Categorymeta;
use App\Models\Useroption;
use App\Models\Transaction;
use App\Models\Userplan;
use App\Models\Category;

use App\Models\Option;
use App\Models\State;
use App\Models\User;
use App\Models\Plan;
use App\Models\BusinessDetail;
use App\Models\Recharge;
use App\Models\DirectPost;
use App\Models\Employee;
use App\Models\BeforePayment;
use App\Models\MessageWallet;
use App\Models\Channel;
use App\Models\Coupon;
use App\Models\UserChannel;
use App\Models\UserEmployee;

use App\Mail\OrderMail;

use Carbon\Carbon;

use Hash;
use Session;
use Auth;
use DB;
use URL;

class CustomerController extends Controller
{
    protected $request;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $customers_url = Session(['customers_url' => '#']);
        $type = $request->type ?? 'all';
        
        if ($type == 'trash') {
            $type = 0;
        }

        $conditions = [];
        if (!empty($request->src) && !empty($request->term)) {
            if ($type === 'all') {
                $customers = User::where('role_id', 2)
                    ->with('user_plan')
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()
                    ->paginate(10);
                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                    // dd($conditions);
                    
            } else {
                $customers = User::where('role_id', 2)
                    ->where('status', $type)
                    ->with('user_plan')
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()
                    ->paginate(10);
                    $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                    
            }
        } else {
            if ($type === 'all') {
                $customers = User::where('role_id', 2)
                    ->with('user_plan')
                    ->latest()
                    ->paginate(10);
            } else {
                $customers = User::where('role_id', 2)
                    ->where('status', $type)
                    ->with('user_plan')
                    ->latest()
                    ->paginate(10);
            }
        }

        $all = User::where('role_id', 2)->count();
        $actives = User::where('role_id', 2)
            ->where('status', 1)
            ->count();
        $suspened = User::where('role_id', 2)
            ->where('status', 2)
            ->count();
        $trash = User::where('role_id', 2)
            ->where('status', 0)
            ->count();
        $requested = User::where('role_id', 2)
            ->where('status', 4)
            ->count();
        $pendings = User::where('role_id', 2)
            ->where('status', 3)
            ->count();
        // dd($customers);

        return view('admin.customer.index', compact('customers', 'request', 'type', 'all', 'actives', 'suspened', 'trash', 'requested', 'pendings', 'conditions'));
    }

    public function transactions(Request $request)
    {
        $conditions = [];

        if (!empty($request->src) && !empty($request->term)) {
            $transactions = Transaction::select('transactions.*')
                            ->leftjoin('users', 'transactions.user_id', '=', 'users.id')
                            ->where('transaction_amount', '>', 0)
                            ->with('user')
                            ->has('user')
                            ->latest()
                            ->where($request->term, 'like', '%' . $request->src . '%')
                            ->paginate(10);

            $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
        } else {
            $transactions = Transaction::where('status', 1)
                            ->where('transaction_amount', '>', 0)
                            ->with('user')
                            ->has('user')
                            ->latest()
                            ->paginate(10);
                
        }

        return view('admin.customer.transactions', compact('transactions', 'request', 'conditions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|max:100|email|unique:users',
            'name' => 'required|min:2|max:50',
            'business_name' => 'required|min:2|max:50',
            'mobile' => 'required|unique:users|regex:/[0-9]/|not_regex:/[a-z]/|min:10' /*,
            'password' => 'required',
            'plan' => 'required'*/,
        ]);

        // $order_prefix=\App\Models\Option::where('key','order_prefix')->first();

        // $plan_info=Plan::find($request->plan);

        // if($plan_info->is_default == 1){
        //    $validatedData = $request->validate([

        //     'transaction_id' => 'required',
        //     'transaction_method' => 'required',

        //   ]);
        // }

        $date = \Carbon\Carbon::now()->format('Ymd');

        $n = 8;
        $char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomPass = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($char) - 1);
            $randomPass .= $char[$index];
        }

        $m = 180;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';

        for ($i = 0; $i < $m; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomCode .= $characters[$index];
        }

        $check = User::where('mobile', $request->mobile)
            ->where('id', '=', $id)
            ->first();
        if ($check) {
            return response()->json(['status' => false, 'message' => 'Mobile number already exists.']);
        }

        $user = new User();
        $user->name = ucwords($request->name);
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->created_by = Auth::id();
        $user->password = Hash::make($randomPass);
        $user->pass_token = $randomCode . $date;
        $user->status = 1;
        $user->role_id = 2;
        // dd($user);
        $user->save();

        if ($user != null) {
            $plan = Plan::where('discount', 0)->first();
            // dd($plan);

            $transection = new Transaction();
            $transection->category_id = 1;
            $transection->user_id = $user->id;
            $transection->transaction_id = 0;
            $transection->status = 1;
            $transection->save();

            $exp_days = $plan->days;
            $expiry_date = \Carbon\Carbon::now()
                ->addDays($exp_days - 1)
                ->format('Y-m-d');

            $max_order = Userplan::max('id');
            $order_prefix = Option::where('key', 'order_prefix')->first();

            $order_no = $order_prefix->value . $max_order;
            $userplan = new Userplan();
            // $userplan->order_no = $order_no;
            // $userplan->amount = 0;
            $userplan->user_id = $user->id;
            $userplan->plan_id = $plan->id;
            $userplan->transaction_id = $transection->id;
            $userplan->will_expire_on = $expiry_date;
            $userplan->status = 1;
            // dd($userplan);
            $userplan->save();

            $details = new BusinessDetail();
            $details->business_name = $request->business_name;
            $details->user_id = $user->id;
            $details->uuid = $user->id . 'BUSI' . date('Ymd');
            $details->save();
        }

        $data = [
            'name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'token' => $user->pass_token,
        ];

        $url = route('admin.customer.index', $request->id);

        \App\Http\Controllers\CommonMailController::BusinessByAdminMail($data);

        return response()->json(['status' => true, 'message' => 'Customer Created Successfully !', 'url' => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_info = User::findOrFail($id);
        $plan_history = Userplan::with('plan_info', 'payment_method') /*->where('amount', '<>', '0')*/
            ->where('user_id', $id)
            ->latest()
            ->paginate(5);

        // dd($user_info);

        return view('admin.customer.show', compact('user_info', 'plan_history'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history($id)
    {
        $user_info = User::findOrFail($id);
        // $tran= Transaction::where('user_id',$id)->first();
        // dd($tran);

        $posts = Transaction::where('user_id', $id)
            ->where('transaction_type', 'plan')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate(10);

        // dd($posts);

        return view('admin.customer.history', compact('user_info', 'posts'));
    }

    public function invoice($id)
    {
        $transaction = Transaction::where('id', $id)
            ->with('method', 'userplans')
            // ->withCount('employee', 'direct_post')
            ->orderBy('id', 'desc')
            ->first();
        //  dd($post);

        $channel_ids = [];
        $count_free_paid_employee_ids = 0;
        $empPlanData = $rechargeInfo = [];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(',', $plan->channel_ids);
            // dd($channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if (!empty($plan->free_employee_ids)) {
                $free_employee_ids = explode(',', $plan->free_employee_ids);
            }

            if ($plan->paid_employee_ids) {
                $paid_employee_ids = explode(',', $plan->paid_employee_ids);
                if (count($paid_employee_ids) > 0) {
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData = $plan->plan_info;
            }

            $rechargeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel')
            ->whereIn('id', $channel_ids)
            ->get();
        // dd($post->userplans_channel);

        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id', $transaction->id)
            ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
            ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
            ->select('plans.name', 'plans.months')
            ->first();
        // dd($plan_period);

        return view('admin.customer.current', compact('transaction', 'plan_period', 'employee_price', 'rechargeInfo', 'empPlanData', 'count_free_paid_employee_ids'));
    }

    public function current($id)
    {
        $user_info = User::findOrFail($id);
        $plan_history = Userplan::with('plan_info', 'payment_method') /*->where('amount', '<>', '0')*/
            ->where('user_id', $id)
            ->latest()
            ->paginate(5);

        $post = Transaction::where('user_id', $id)
            ->with('method', 'userplans')
            ->withCount('employee', 'direct_post')
            ->orderBy('id', 'desc')
            ->first();

        $plan_period = Transaction::where('transactions.id', $post->id)
            ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
            ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
            ->select('plans.name')
            ->first();

        // dd($plan_period);

        return view('admin.customer.current', compact('user_info', 'plan_history', 'post', 'plan_period'));
    }

    public function planInfo($id)
    {
        $planinfo = [];
        $records = [];
        $userplans = Userplan::with('plan_info', 'payment_method')
            ->where('user_id', $id)
            ->where('status', 1)
            ->get();
        //  dd($userplans);

        $channel = UserChannel::with('channel')
            ->where('user_id', $id)
            ->get();
        // dd($channel);
        $useremployee = UserEmployee::with('employee')
            ->where('user_id', $id)
            ->get();
        $message = MessageWallet::with('users')
            ->where('user_id', $id)
            ->get();
        //  dd($message);

        return view('admin.customer.subscription_info', compact('planinfo', 'userplans', 'records', 'channel', 'useremployee', 'message'));
    }

    public function planview($id)
    {
        // dd($planinfo);
        return view('admin.customer.planinfo');
    }

    public function updateplaninfo(Request $request, $id)
    {
        return response()->json('Info Updated Successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customers_url = Session(['customers_url' => URL::previous()]);
        $info = User::findorFail($id);
        $details = BusinessDetail::where('user_id', $id)->first();
        // dd($details->business_name);
        return view('admin.customer.edit', compact('info', 'details'));
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
            'email' => 'required|max:100|email',
            'name' => 'required|min:2|max:50',
            'business_name' => 'required|min:2|max:50',
            'mobile' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10',
        ]);

        $user = User::findorFail($id);
        $customers_url = Session::get('customers_url');
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->is_enterprise = $request->is_enterprise;
        // dd($user);
        $user->save();

        $details = BusinessDetail::where('user_id', $user->id)->first();
        $details->business_name = $request->business_name;
        $details->save();

        return response()->json(['status' => true, 'message' => 'User Updated Successfully !', 'url' => $customers_url]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!isset($request->method)) {
            return response()->json(['status' => false, 'message' => 'Please Select Action !']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Checkbox !']);
        }

        if ($request->type == 'user_delete') {
            foreach ($request->ids ?? [] as $key => $id) {
                \App\Models\Customer::destroy($id);
            }
        } else {
            if ($request->method == 'delete') {
                foreach ($request->ids ?? [] as $key => $id) {
                    \File::deleteDirectory('uploads/' . $id);
                    $user = User::destroy($id);
                }
            } else {
                foreach ($request->ids ?? [] as $key => $id) {
                    $user = User::find($id);

                    if ($request->method == 'trash') {
                        $user->status = 0;
                    } else {
                        $user->status = $request->method;
                    }

                    $user->save();
                }
            }
        }
        return response()->json(['status' => true, 'message' => 'Successfully done !']);
    }

    public function regeneratePassword(Request $request)
    {
        $date = \Carbon\Carbon::now()->format('Ymd');
        $m = 180;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';

        for ($i = 0; $i < $m; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomCode .= $characters[$index];
        }

        $user = User::where('id', $request->user_id)->first();
        $user->pass_token = $randomCode . $date;
        $user->save();

        $data = [
            'name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'token' => $user->pass_token,
        ];

        \App\Http\Controllers\CommonMailController::BusinessByAdminMail($data);

        return response()->json(['Password Regeneated & Email Sent!']);
    }

    public function downloadInvoice($id)
    {
        // dd($id);
        $transaction = Transaction::with('method', 'userplans', 'state')
            // ->withCount('employee', 'direct_post')
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $channel_ids = [];
        $count_free_paid_employee_ids = 0;
        $empPlanData = $rechargeInfo = [];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(',', $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if (!empty($plan->free_employee_ids)) {
                $free_employee_ids = explode(',', $plan->free_employee_ids);
            }

            if ($plan->paid_employee_ids) {
                $paid_employee_ids = explode(',', $plan->paid_employee_ids);
                if (count($paid_employee_ids) > 0) {
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData = $plan->plan_info;
            }

            $rechargeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel')
            ->whereIn('id', $channel_ids)
            ->get();

        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id', $id)
            ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
            ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
            ->select('plans.name', 'plans.months')
            ->first();

        $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)
            ->orderBy('id', 'desc')
            ->first();
        $user = User::findorFail($transaction->user_id);
        //dd($business);

        $customPaper = [0, 0, 794.0, 1123.0];
        $pdf = \PDF::loadView('admin.customer.invoice', compact('transaction', 'plan_period', 'business', 'user', 'rechargeInfo', 'empPlanData', 'count_free_paid_employee_ids', 'employee_price'))
            ->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])
            ->setPaper($customPaper, 'portrait');

        //return $pdf->stream('invoice.pdf');
        return $pdf->download('invoice.pdf');
    }

    public function viewInvoice($id)
    {
        // dd($id);
        $transaction = Transaction::with('method', 'userplans', 'state')
            // ->withCount('employee', 'direct_transaction')
            ->where('id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $channel_ids = [];
        $count_free_paid_employee_ids = 0;
        $empPlanData = $rechargeInfo = [];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(',', $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if (!empty($plan->free_employee_ids)) {
                $free_employee_ids = explode(',', $plan->free_employee_ids);
            }

            if ($plan->paid_employee_ids) {
                $paid_employee_ids = explode(',', $plan->paid_employee_ids);
                if (count($paid_employee_ids) > 0) {
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData = $plan->plan_info;
            }

            $rechargeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel')
            ->whereIn('id', $channel_ids)
            ->get();
        //  dd($transaction->userplans_channel);

        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id', $id)
            ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
            ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
            ->select('plans.name', 'plans.months')
            ->first();

        $business = BusinessDetail::with('stateDetail')->where('user_id', $transaction->user_id)
            ->orderBy('id', 'desc')
            ->first();
        $user = User::findorFail($transaction->user_id);
        //dd($business);

        $customPaper = [0, 0, 794.0, 1123.0];
        $pdf = \PDF::loadView('admin.customer.invoice', compact('transaction', 'plan_period', 'business', 'user', 'rechargeInfo', 'empPlanData', 'count_free_paid_employee_ids', 'employee_price'))
            ->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream('invoice.pdf');
        // return $pdf->download('invoice.pdf');
    }

    /* Backend Payment Entries */
    public function managePayments($id)
    {
        // --- transaction start ---//
        $last_paid_transaction = Transaction::where('user_id', $id)
            ->where('transaction_amount', '>', 0)
            ->orderBy('id', 'desc')
            ->first();
        $last_paid_tran_date = Carbon::now()->format('Y-m-d');

        if ($last_paid_tran_date != null) {
            $last_paid_tran_date = Carbon::parse($last_paid_transaction->created_at)->format('Y-m-d');
        }
        //--- transaction end---//

        //****plan new code dinesh start****//
        $plans = Plan::where('status', '1')
            ->orderBy('ordering', 'asc')
            ->get();
        //****plan new code dinesh end****//

        //****userchannel new code dinesh start****//
        $purchasedChannelIds = UserChannel::where('user_id', $id)
            ->pluck('channel_id')
            ->toArray();
        $paidChannels = Channel::with('admin_user_channel')
            ->whereIn('id', $purchasedChannelIds)
            ->orderBy('price', 'asc')
            ->get();
        // dd($paidChannels);
        $unpaidChannels = Channel::whereNotIn('id', $purchasedChannelIds)->get();
        //****userchannel new code dinesh end****//

        $renew_info = Option::where('key', 'renew_before_days')->first();

        $users = UserEmployee::with('employee')
            ->where('user_id', $id)
            ->get();

        $employee_price = Option::where('key', 'employee_price')->first();

        /* Plan Setting */
        $setting = Option::where('key','plan_setting')->first();

        $message_plan = MessageWallet::where('user_id', $id)->first();
        $message_plans = Recharge::where('status', 1)->get();
        
        

        //---notification_list start---//

        //---notification_list end---//

        $getways = Category::where('type', 'payment_gateway')
            ->where('status', 1)
            ->where('slug', '!=', 'cod')
            ->with('preview')
            ->first();
        // dd($getways);

        return view('admin.customer.manage-payments', compact('setting', 'id','plans', 'getways', 'purchasedChannelIds', 'paidChannels', 'renew_info', 'unpaidChannels', 'users', 'employee_price', 'message_plans', 'message_plan'));
    }

    //---coupon code code start---//
    public function getCouponCode(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon)
            ->where('status', '1')
            ->first();
        // dd($coupon);
        if ($coupon != null) {
            return response()->json([
                'status' => true,
                'coupon' => $coupon,
                'message' => 'Coupon found.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'coupon' => '',
                'message' => 'Coupon not found.',
            ]);
        }
    }
    //---coupon code code end---//

    //---payment code start---//
    public function proceedToPay(Request $request)
    {
        // dd($request);
        $planData = $request->except('_token');
        // dd($planData);
        Session($planData);
        
        $url = url('admin/make-payment/' . $planData['plan_id']);
        // dd($url);

        return response()->json(['status' => true, 'message' => 'Data stored in session', 'url' => $url]);
    }

    public function make_payment($id)
    {
        // dd($id);
        // dd(Session::has());
        if (Session::has('success')) {
            Session::flash('success', 'Thank You For Subscribe After Review The Order You Will Get A Notification Mail From Admin');
            return redirect('admin/customer');
        }

        if (!Session::get('payble_price')) {
            return Redirect::route('admin.customer.managePayments', array('id' => $id));
        }

        $payble_price = Session::get('payble_price');
        // dd($payble_price);
        $planDetails = ['plan_id' => Session::get('plan_id'), 'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];
        // dd($planDetails['plan_id']);
        
        
        $info = Plan::findOrfail(Session::get('plan_id'));
        
        $getways = Category::where('type', 'payment_gateway')
        ->where('status', 1)
        ->where('slug', '!=', 'cod')
        ->with('preview')
        ->get();
        
        $states = State::where('status', 1)->get();
        
        $currency = Option::where('key', 'currency_info')
        ->orderBy('id', 'desc')
        ->first();
        $currency =json_decode($currency->value);
        $currency_name = $currency->currency_name;
        $total = $payble_price;

        $price = '<span class="h6 font-weight-bold text-success">'.$currency_name.' '.$total.'</span> (Inclusive GST).';

        $businessDetail = BusinessDetail::where('user_id', Session::get('user_id'))->first();
        // dd($businessDetail->id);
        $user = User::find(Session::get('user_id'));
        // dd($user);
        
        return view('admin.customer.payment', compact('payble_price', 'planDetails', 'info', 'getways', 'states', 'currency', 'currency_name', 'total', 'price', 'businessDetail', 'user'));
    }
    //---payment code end---//

    //---make charge start---//
    public function make_charge(Request $request,$id)
    {
        #dd(Session::all());
        $payble_price = Session::get('payble_price');
        
        $planDetails = ['plan_id' => Session::get('plan_id'),'payble_price' => Session::get('payble_price'), 'plan_name' => Session::get('plan_name'), 'billing_type' => Session::get('billing_type')];
        // dd($planDetails);

        if($request->gst_claim == null || $request->gst_claim == ''){
            $gst_claim = 0;
        }else{ $gst_claim = $request->gst_claim; }
        if($request->gst_business_name == null || $request->gst_business_name == ''){
            $gst_business_name = 0;
        }else{ $gst_business_name = $request->gst_business_name; }
        if($request->gst_address == null || $request->gst_address == ''){
            $gst_address = 0;
        }else{ $gst_address = $request->gst_address; }
        if($request->gst_state == null || $request->gst_state == ''){
            $gst_state = 0;
        }else{ $gst_state = $request->gst_state; }
        if($request->gst_city == null || $request->gst_city == ''){
            $gst_city = 0;
        }else{ $gst_city = $request->gst_city; }
        if($request->gst_pincode == null || $request->gst_pincode == ''){
            $gst_pincode = 0;
        }else{ $gst_pincode = $request->gst_pincode; }
        if($request->gst_number == null || $request->gst_number == ''){
            $gst_number = 0;
        }else{ $gst_number = $request->gst_number; }

        $info=Plan::findorFail($id);
        
        
        $getway=Category::where('type','payment_gateway')->where('featured',1)->where('slug','!=','cod')->findorFail($request->mode);
        // dd($getway);
        
        $currency=Option::where('key','currency_info')->orderBy('id', 'desc')->first();
        $currency=json_decode($currency->value);
        $currency_name=$currency->currency_name;
        
        $total=$payble_price;

        $user = User::find(Session::get('user_id'));

        // dd($user->email);

        $data['ref_id']=$id;
        $data['getway_id']=$request->mode;
        $data['amount']=$total;
        $data['email']=$user->email;
        $data['name']=$user->name;
        $data['phone']=$request->phone;
        $data['billName']=Session::get('plan_name');
        $data['billing_type']=Session::get('billing_type');
        $data['gst_claim']=$gst_claim;
        $data['gst_business_name']=$gst_business_name;
        $data['gst_address']=$gst_address;
        $data['gst_state']=$gst_state;
        $data['gst_city']=$gst_city;
        $data['gst_pincode']=$gst_pincode;
        $data['gst_number']=$gst_number;
        $data['transaction_type'] = 'plan';
        $data['currency']=strtoupper($currency_name);

        Session::put('order_info',$data);

        // Update User Business Details
        BusinessDetail::whereUserId($id)->update([
            'billing_address_line_1'=>$request['gst_address'],
            'billing_state'=>$request['gst_state'],
            'billing_city'=>$request['gst_city'],
            'billing_pincode'=>$request['gst_pincode'],
        ]);

        if ($getway->slug=='paypal') {
           return Paypal::make_payment($data);
        }
        if ($getway->slug=='instamojo') {
           return Instamojo::make_payment($data);
        }
        if ($getway->slug=='toyyibpay') {
           return Toyyibpay::make_payment($data);
        }
        if ($getway->slug=='stripe') {
            $data['stripeToken']=$request->stripeToken;
           return Stripe::make_payment($data);
        }
        if ($getway->slug=='mollie') {
            return Mollie::make_payment($data);
        }
        if ($getway->slug=='paystack') {            
            return Paystack::make_payment($data);
        }
        if ($getway->slug=='mercado') {            
            return Mercado::make_payment($data);
        }
        
        if ($getway->slug=='razorpay') {
           return redirect('/admin/payment-with/razorpay');
        }
        
        if ($getway->slug=='cashfree') {
           return Cashfree::make_payment($data);
        }
        
        if ($getway->slug=='payu') {
           return PayU::make_payment($data);
        }
        
        if ($getway->slug=='paytm') {
           return Paytm::make_payment($data);
        }
    }
    //--- make charge end---// 

    //---payment success start---//
    public function success()
    {
        //   dd("success ok");
        $user = User::find(Session::get('user_id'));
        // dd($user);
        // dd(Session::has('payment_info'));
        if (Session::has('payment_info')) {

            $data = Session::get('payment_info');
            $plan=Plan::findorFail($data['ref_id']);
            $exp_days =  $plan->days;
            
            $newPayment = BeforePayment::where('order_id',$data['payment_id'])->orderBy('id','desc')->first();
            if($newPayment != null){
                $before_payment_data = json_decode($newPayment->session_data, true);

                Session($before_payment_data);
            }

            DB::beginTransaction();
            try {

                $transaction = new Transaction;
                $transaction->invoice_no = $this->getInvoiceNo();
                $transaction->category_id = $data['getway_id'];
                $transaction->user_id = $user->id;
                $transaction->transaction_id = $data['payment_id'];
                $transaction->transaction_amount= $data['amount'];
                $transaction->total_amount = Session::get('total_price');
                $transaction->gst_claim = $data['gst_claim'];
                $transaction->gst_business_name = $data['gst_business_name'];
                $transaction->gst_number = $data['gst_number'];
                $transaction->gst_address = $data['gst_address'];
                $transaction->gst_state = $data['gst_state'];
                $transaction->gst_city = $data['gst_city'];
                $transaction->gst_pincode = $data['gst_pincode'];
                $transaction->transaction_type = $data['transaction_type'];

                if (isset($data['payment_status'])) {
                    $transaction->status = $data['payment_status'];
                }else{
                    $transaction->status = 1;
                }
                $transaction->save();

                $today = \Carbon\Carbon::now()->format("Y-m-d");
                if($plan->slug == 'monthly'){
                    $invoice_date = Carbon::now()->addMonth(1)->format('Y-m-d');
                }elseif($plan->slug == 'yearly'){
                    $invoice_date = Carbon::now()->addYear(1)->format('Y-m-d');
                }

                /* Message Plan */
                if(Session::get('message_plan_id') != ''){
                    $message_plan = Recharge::findOrFail(Session::get('message_plan_id'));
                    $message_expiry = Carbon::now()->addYear(1)->format('Y-m-d');
                    
                    $wallet = MessageWallet::where('user_id', $user->id)->first();
                    $wallet->total_messages = $wallet->total_messages + $message_plan->messages;
                    $wallet->will_expire_on = $message_expiry;
                    $wallet->save();
                }

                /* Buy Users */
                $paidEmployeeIds = $freeEmployeeIds = array();
                if(Session::get('buy_users') != ''){
                    for($i = 0; $i < Session::get('buy_users'); $i++){
                        $paid_employee = new UserEmployee;
                        $paid_employee->user_id = $user->id;
                        $paid_employee->is_free = 0;
                        $paid_employee->will_expire_on = $invoice_date;
                        $paid_employee->save();

                        $paidEmployeeIds[] = $paid_employee->id;
                    }
                }

                /* Renew Users */
                if(Session::get('renew_users') != ''){
                    $userIds = explode(',', Session::get('renew_users'));

                    foreach($userIds as $userId){
                        $renew_paid_employee = UserEmployee::findOrFail($userId);

                        if($plan->slug == 'monthly'){
                            $paid_emply_renew_date = Carbon::parse($renew_paid_employee->will_expire_on)->addMonth(1)->format('Y-m-d');
                        }elseif($plan->slug == 'yearly'){
                            $paid_emply_renew_date = Carbon::parse($renew_paid_employee->will_expire_on)->addYear(1)->format('Y-m-d');
                        }

                        $renew_paid_employee->will_expire_on = $paid_emply_renew_date;
                        $renew_paid_employee->save();

                        $paidEmployeeIds[] = $renew_paid_employee->id;
                    }
                }

                /* Buy Channel */
                $channelIds = array();
                if(Session::get('buy_channels') != ''){
                    $buyChannelIds = explode(',', Session::get('buy_channels'));

                    foreach($buyChannelIds as $buyChannelId){
                        $channel = Channel::findOrFail($buyChannelId);
                        
                        if($channel->free_employee > 0){
                            for($i = 0; $i < $channel->free_employee; $i++){
                                $free_employee = new UserEmployee;
                                $free_employee->user_id = $user->id;
                                $free_employee->is_free = 1;
                                $free_employee->free_with_channel = $channel->id;
                                $free_employee->will_expire_on = $invoice_date;
                                
                                $free_employee->save();
        
                                $freeEmployeeIds[] = $free_employee->id;
                            }
                        }

                        $buy_channel = new UserChannel;
                        $buy_channel->user_id = $user->id;
                        $buy_channel->channel_id = $buyChannelId;
                        $buy_channel->will_expire_on = $invoice_date;
                        $buy_channel->save();

                        $channelIds[] = $buy_channel->id;
                    }
                }

                /* Renew Channels */
                if(Session::get('renew_channels') != ''){
                    $renewChannelIds = explode(',', Session::get('renew_channels'));

                    foreach($renewChannelIds as $renewChannelId){
                        $freeEmployees = UserEmployee::where('user_id', $user->id)->where('free_with_channel', $renewChannelId)->get();

                        if(!empty($freeEmployees)){
                            foreach($freeEmployees as $emply){
                                
                                $free_employee = UserEmployee::findOrFail($emply->id);

                                if($plan->slug == 'monthly'){
                                    $emply_renew_date = Carbon::parse($free_employee->will_expire_on)->addMonth(1)->format('Y-m-d');
                                }elseif($plan->slug == 'yearly'){
                                    $emply_renew_date = Carbon::parse($free_employee->will_expire_on)->addYear(1)->format('Y-m-d');
                                }

                                $free_employee->will_expire_on = $emply_renew_date;
                                $free_employee->save();
        
                                $freeEmployeeIds[] = $free_employee->id;
                            }
                        }

                        $renew_channel = UserChannel::where('user_id', $user->id)->where('channel_id',$renewChannelId)->first();

                        if($plan->slug == 'monthly'){
                            $channel_renew_date = Carbon::parse($renew_channel->will_expire_on)->addMonth(1)->format('Y-m-d');
                        }elseif($plan->slug == 'yearly'){
                            $channel_renew_date = Carbon::parse($renew_channel->will_expire_on)->addYear(1)->format('Y-m-d');
                        }

                        $renew_channel->user_id = $user->id;
                        $renew_channel->channel_id = $renewChannelId;
                        $renew_channel->will_expire_on = $channel_renew_date;
                        $renew_channel->save();

                        $channelIds[] = $renew_channel->id;
                    }
                }

                $channelArr = $paidEmplooyeeArr = $freeEmplooyeeArr = '';
                if(!empty($channelIds)){
                    $channelArr = implode(',', $channelIds);
                }

                if(!empty($paidEmployeeIds)){
                    $paidEmplooyeeArr = implode(',', $paidEmployeeIds);
                }

                if(!empty($freeEmployeeIds)){
                    $freeEmplooyeeArr = implode(',', $freeEmployeeIds);
                }

                /* Userplan */
                $userplan = new Userplan;
                $userplan->user_id = $user->id;
                $userplan->plan_id = $plan->id;
                $userplan->transaction_id = $transaction->id;
                $userplan->will_expire_on = $invoice_date;
                $userplan->channel_ids = $channelArr;
                $userplan->free_employee_ids = $freeEmplooyeeArr;
                $userplan->paid_employee_ids = $paidEmplooyeeArr;
                $userplan->recharge_plan_id = Session::get('message_plan_id');
                $userplan->save();

                Session::flash('success', 'Thank You For Subscribe,You Will Get A Notification Mail From Admin');

                $data['info'] = $user;
                $data['to_admin'] = env('MAIL_TO');
                $data['from_email'] = $user->email;
            
                DB::commit();
            } catch (Exception $e) {
                DB::rollback();
            }

            $amount = Session::get('payble_price');
            $plan_name = $plan->name;

            $gst = $amount - ($amount * (100 / (100 + 18 ) ) );
            $priceWithoutGst = $amount - $gst;

            $emailData = [
                'name' => $user->name,
                'mobile' => $user->mobile,
                'email' => $user->email,
                'plan_name' => $plan_name,
                'plan_price' => $amount,
                'plan_gst' => $gst,
                'plan_without_gst' => $priceWithoutGst,
                'plan_date' => $userplan->created_at
            ];

            $msg = \App\Http\Controllers\CommonMessageController::updateSubscriptionWpMessage($emailData);
            // dd($msg);
            // \App\Http\Controllers\CommonMessageController::sendMessage('91'.$user->mobile, $msg);

            \App\Http\Controllers\CommonMailController::BusinessPlanUpdateMail($emailData);
            return redirect('admin/thank-you');
        }
        abort(404);
    }
    //---payment success end---//

    //---thank you start---//
    public function thankYou(Request $request)
    {
        // dd(!Session::has('payment_info'));
        if(!Session::has('payment_info')){
            return redirect()->route('admin.dashboard');
        }
        
        $user = User::find(Session::get('user_id'));
        // dd($user);
        Session::forget('payment_info');

        //$msg = \App\Http\Controllers\CommonMessageController::welcomeWpMessage($user->name);
        //\App\Http\Controllers\CommonMessageController::sendMessage('91'.$user->mobile, $msg);

        //notification_list
        // $notification_list = CommonSettingController::getNotification();
        // $planData = CommonSettingController::getBusinessPlanDetails();

        return view('admin.customer.payment-success', compact('user'));
    }
    //---thank you end---//


    

    public function getInvoiceNo()
    {
        $currentYr = Carbon::now()->format('y');
        $month = date('m');

        if ($month < 4) {
            $currentYr = $currentYr - 1;
        }

        $nextYr = $currentYr + 1;
        $slug = 'MP/' . $currentYr . '-' . $nextYr;

        $transaction = Transaction::where('invoice_no', '!=', '')
                                    ->where('invoice_no', 'like', '%'.$slug.'%')
                                    ->orderBy('id', 'desc')
                                    ->select('invoice_no')
                                    ->first();
        
        $sr_no = 1;
        if ($transaction != null) {
            $sr_no = substr($transaction->invoice_no, strrpos($transaction->invoice_no, '/') + 1) + 1;
        }

        if(strlen($sr_no) == 1){
            $sr_no = '0'.$sr_no;
        }
        $invoice_no = $slug . '/' . $sr_no;

        return $invoice_no;
    }

    
    public function suspendCustomer(Request $request){
        $user = User::find($request->user_id);
        $user->mobile = '0123456789';
        $user->email = 'user.suspended.'.$user->id.'@mouthpublicity.io';
        $user->social_post_api_token = $user->social_post_api_token.$user->id;
        $user->status = 2;
        $user->logout_user = 1;
        
        if($user->save()){

            $employeeIds = User::where('created_by', $user->id)->pluck('id')->toArray();

            if(!empty($employeeIds)){
                foreach($employeeIds as $employeeId){
                    $employee = User::find($employeeId);
                    $employee->mobile = '0123456789';
                    $employee->status = 2;
                    $employee->logout_user = 1;
                    $employee->save();
                }
            }

            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function userInfo(Request $request,$id)
    {
        $type = $request->type ?? 'all';
        
        if ($type == 'trash') {
            $type = 0;
        }

        $conditions = [];
        if (!empty($request->src) && !empty($request->term)) {
            if ($type === 'all') {
            $users = User::where('role_id', 3)
                ->where($request->term, 'like', '%' . $request->src . '%')
                ->where('created_by', $id)
                ->get(); 
            }else{
                $users = User::where('role_id', 3)
                ->where($request->term, 'like', '%' . $request->src . '%')
                ->where('created_by', $id)
                ->where('status', $type)
                ->get();
            }   
        }else{
            if ($type === 'all') {
                $users = User::where('role_id',3)->where('created_by', $id)->get();
            }else{
                $users = User::where('role_id',3)->where('created_by', $id)->where('status', $type)->get();
            }
        }
        $all = User::where('role_id', 3)->where('created_by', $id)->count();
        $suspened = User::where('role_id', 3)
            ->where('status', 2)
            ->where('created_by', $id)
            ->count();
        //dd($users);
        return view('admin.customer.user_info', compact('users','request','type','all','suspened','id'));
    }

    public function suspendUser(Request $request){
        $user = User::find($request->user_id);
        $user->mobile = '0123456789';
        $user->status = 2;
        $user->logout_user = 1;
        if($user->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    
}
