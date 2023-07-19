<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
use App\Models\Feature;
use App\Models\Coupon;

use App\Mail\OrderMail;

use Carbon\Carbon;

use Session;
use Auth;
use DB;
use URL;

class PlanController extends Controller
{
    protected $id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Plan::withCount('active_users')
            ->latest()
            ->paginate(10);
        $plan_url = Session(['plan_url' => '#']);
        // dd($posts);
        return view('admin.plan.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxValue = Plan::max('id');
        $result_max = $maxValue + 1;
        // dd($result_max);

        // dd($request);
        $rules = [
            'name' => 'required|max:100',
        ];
        $messages = [
            'name.required' => 'Plan Name Is Required !',
        ];
        $this->validate($request, $rules, $messages);

        if ($request->is_default == 1) {
            Plan::where('is_default', 1)->update(['is_default' => 0]);
        }
        $check = Plan::where('name', $request->name)->first();
        if ($check && $request->name) {
            return response()->json(['status' => false, 'message' => ' Plan Name Is Already Exists.']);
        }
        $plan = new Plan();
        $plan->name = $request->name;
        $plan->slug = Str::slug($request->name);
        $plan->discount = $request->discount;
        $plan->months = $request->months;
        $plan->days = $request->days;
        $plan->is_default = $request->is_default;
        $plan->status = $request->status;
        $plan->save();
        $plan->ordering = $result_max;
        $plan->save();
        // dd($plan);
        $url = route('admin.plan.index', $request->id);

        return response()->json(['status' => true, 'message' => 'Plan Created Successfully!', 'url' => $url]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Plan::findOrfail($id);
        $this->id = $id;

        $customers = User::where('role_id', 2)
            ->whereHas('user_plan', function ($q) {
                return $q->where('plan_id', $this->id);
            })
            ->with('user_plan')
            ->latest()
            ->paginate(40);

        //dd($customers);

        return view('admin.plan.show', compact('customers', 'posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan_url = Session(['plan_url' => URL::previous()]);
        $info = Plan::find($id);
        return view('admin.plan.edit', compact('info'));
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
        
        $rules = [
            'name' => 'required|max:100',
        ];
        $messages = [
            'name.required' => 'Plan Name Is Required !',
        ];
        $this->validate($request, $rules, $messages);

        if ($request->is_default == 1) {
            Plan::where('is_default', 1)->update(['is_default' => 0]);
        }
        $plan = Plan::find($id);
        $plan_url = Session::get('plan_url');
        $plan->name = $request->name;
        $plan->slug = Str::slug($request->name);
        $plan->discount = $request->discount;
        $plan->months = $request->months;
        $plan->ordering = $request->ordering;
        $plan->days = $request->days;
        $plan->is_default = $request->is_default;
        $plan->status = $request->status;
        $plan->save();
        // dd($plan);

        return response()->json(['status' => true, 'message' => 'Plan Updated Successfully!', 'url' => $plan_url]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!isset($request->type)) {
            return response()->json(['status' => false, 'message' => 'Please Select Action !']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Plan !']);
        }

        if ($request->type == 'delete') {
            foreach ($request->ids as $row) {
                Plan::destroy($row);
            }

            return response()->json(['status' => true, 'message' => 'Plan Deleted Successfully !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Plan Not Deleted !']);
        }
    }
}
