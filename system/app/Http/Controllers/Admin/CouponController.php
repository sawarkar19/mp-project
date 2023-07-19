<?php

namespace App\Http\Controllers\Admin;

use DB;
use URL;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Userplan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ArchiveCoupons;
use App\Models\DocumentCategory;
use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;



class CouponController extends Controller
{
    protected $id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $conditions = [];
        $numberOfPage = $request->no_of_page ?? 10;
        if (!empty($request->src) && !empty($request->term)) {
            $allCoupons = Coupon::where($request->term, 'like', '%' . $request->src . '%')
            ->paginate($numberOfPage);
            $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
        } else {
            $allCoupons = Coupon::orderBy('id', 'DESC')->paginate($request->no_of_page);
        }
        
        $coupon_url = Session(['coupon_url' => '#']);
        return view('admin.coupon.index', compact('allCoupons', 'conditions', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // $allCoupons = array();
        // $users = User::where('role_id', 2)->select('name','id')->get();
        // dd($users);
        //   $free = DB::table('transactions')->where('total_amount', 0)->select('user_id')->get();
        //  dd($free);

        //  $getFreeUser = User::get();
        // dd($getFreeUser);
        // dd($getFreeUser[5]->user_apps);
        // $getFreeUser = User::with('user_free')->get();
        // $freeUser =  $this->getSubscriberUsers();
        // dd($freeUser);

        // $subscription = OfferSubscription::where('uuid',$request->uuid)->first();
        // dd($subscription);
        //create redeem
        // $redeem_code = $this->getRedeemCode($subscription->id);

        // dd($redeem_code);

        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $checkDiscount = Coupon::where('discount', $request->discount)
            ->where('mobile', $request->mobile)
            ->where('email', $request->email)
            ->where('code', $request->code)
            ->first();
        
        $checkCouponCode = Coupon::where('code', $request->code)->first();    

        if ($request->is_default != 0) {
            Coupon::where('is_default', '1')->update(['is_default' => 0]);
        }

        if ($checkDiscount == null && $checkCouponCode == null ) {
            $coupon = new Coupon();
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->description = $request->description;
            $coupon->coupon_for = $request->coupon_for;
            if ($request->coupon_for == 'individuals') {
                $coupon->user_id = $request->user_id;
                $coupon->subscriber_type = $request->subscriber_type;
                $coupon->mobile = $request->mobile;
                $coupon->email = $request->email;
            } else {
                $coupon->user_id = 0;
            }
            $coupon->coupon_type = $request->coupon_type;
            $coupon->discount = $request->discount;
            $coupon->no_of_time = $request->no_of_time ?? 1;
            $coupon->start_date = date('Y-m-d', strtotime($request->start_date));

            $coupon->end_date = date('Y-m-d', strtotime($request->end_date));
            $coupon->featured = $request->featured;
            $coupon->is_default = $request->is_default ?? 1;
            $coupon->status = $request->status;
            $coupon->save();
            $url = route('admin.coupon.index', $request->id);

            return response()->json(['status' => true, 'message' => 'Coupon Created Successfully!', 'url' => $url]);
        } else {
            return response()->json(['status' => false, 'message' => 'This Coupon Is Already Exist']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->id = $id;
        $couponDetail = Coupon::where('id', $id)->get();
        // dd($couponDetail);

        return view('admin.coupon.show', compact('couponDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon_url = Session(['coupon_url' => URL::previous()]);
        $info = Coupon::find($id);
        $getUser = User::find($info->user_id);
        $getIndividualUser = User::where('status', 1)
            ->where('role_id', 2)
            ->get();
        // dd($getUser);

        $timestamp1 = strtotime($info->start_date);
        $timestamp2 = strtotime($info->end_date);
        $start_date = date('Y-m-d', $timestamp1);
        $end_date = date('Y-m-d', $timestamp2);
        return view('admin.coupon.edit', compact('info', 'start_date', 'end_date', 'getUser', 'getIndividualUser'));
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
        if ($request->is_default != 0) {
            Coupon::where('is_default', '1')->update(['is_default' => 0]);
        }

        $checkDiscount = Coupon::where('discount', $request->discount)
            ->where('mobile', $request->mobile)
            ->where('email', $request->email)
            ->where('id', '!=', $id)
            ->first();
        
        $checkCouponCode = Coupon::where('code', $request->code)->where('id', '!=', $id)->first();    

        if ($checkDiscount == null && $checkCouponCode == null) {
            $coupon = Coupon::find($id);
            $coupon_url = Session::get('coupon_url');
            $coupon->name = $request->name;
            $coupon->code = $request->code;
            $coupon->description = $request->description;
            $coupon->coupon_for = $request->coupon_for;
            // dd($coupon->coupon_for=$request->coupon_for);

            if ($request->coupon_for == 'individuals') {
                $coupon->user_id = $request->user_id;
                $coupon->subscriber_type = $request->subscriber_type;
                $coupon->mobile = $request->mobile;
                $coupon->email = $request->email;
            } else {
                $coupon->user_id = 0;
            }
            $coupon->coupon_type = $request->coupon_type;
            $coupon->discount = $request->discount;
            $coupon->no_of_time = $request->no_of_time ?? 1;
            $coupon->start_date = date('Y-m-d', strtotime($request->start_date));
            $coupon->end_date = date('Y-m-d', strtotime($request->end_date));

            $coupon->featured = $request->featured;
            $coupon->is_default = $request->is_default ?? 1;
            $coupon->status = $request->status;
            $coupon->save();

            return response()->json(['status' => true, 'message' => 'Coupon Updated Successfully!', 'url' => $coupon_url]);
        } else {
            return response()->json(['status' => false, 'message' => 'This Coupon Is  Already Exist']);
        }
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
            return response()->json(['status' => false, 'message' => 'Please Select Action!']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Coupon!']);
        }

        if ($request->type == 'delete') {
            foreach ($request->ids as $row) {
                Coupon::destroy($row);
            }
            return response()->json(['status' => true, 'message' => 'Coupon Deleted Successfully!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Coupon Not Deleted!']);
        }
    }

    public function archive($id)
    {
        $this->id = $id;
        $couponDetail = Coupon::find($id);

        $archivedCoupon = new ArchiveCoupons();
        $archivedCoupon->coupon_id = $id;
        $archivedCoupon->name = $couponDetail->name;
        $archivedCoupon->code = $couponDetail->code;
        $archivedCoupon->description = $couponDetail->description;
        $archivedCoupon->coupon_type = $couponDetail->coupon_type;
        $archivedCoupon->discount = $couponDetail->discount;
        $archivedCoupon->start_date = $couponDetail->start_date;
        $archivedCoupon->end_date = $couponDetail->end_date;
        $archivedCoupon->coupon_for = $couponDetail->coupon_for;
        $archivedCoupon->featured = $couponDetail->featured;
        $archivedCoupon->is_default = $couponDetail->is_default;
        $archivedCoupon->status = $couponDetail->status;
        $archivedCoupon->save();
        $couponDetail->delete();
        return response()->json(['Coupon Archived Successfully!']);
    }

    /*----This function used for showing userlist based on subscription plan----*/
    //   public function getSubscriberUsers(Request $request){
    //       $currentDate = Carbon::now()->format('Y-m-d');
    //       $usertypeArray = isset($request->usertypeArray) ? $request->usertypeArray : []; //dd($usertypeArray);
    // $userList = $finalUserList = [];
    // if(!isset($usertypeArray) || !empty($usertypeArray)){
    // 	foreach($usertypeArray as $usertype)
    // 	{

    // 		if($usertype=="1")
    // 		{

    // 			$getFreeUser = User::with('user_free')->where('role_id',2)->get(); //dd($getFreeUser);
    // 			if($getFreeUser != null){
    // 				foreach($getFreeUser as $user){
    // 					if($user->user_free != null){
    // 					$userList[] =  ['userid'=>$user->id,'name'=>$user->name];
    // 					}
    // 				}
    // 			}

    // 		}

    // 		if($usertype=="2")
    // 		{

    // 			$getPaidUser = User::with('user_paid')->where('role_id',2)->get(); //dd($getPaidUser);
    // 			if($getPaidUser != null){
    // 				foreach($getPaidUser as $user){
    // 					if($user->user_paid != null){
    // 					$userList[] =  ['userid'=>$user->id,'name'=>$user->name];
    // 					}
    // 				}
    // 			}

    // 		}

    // 		if($usertype=="3")
    // 		{
    // 			$getExpiredUser = User::with('user_expired')->where('role_id',2)->get();
    // 			if($getExpiredUser != null){
    // 				foreach($getExpiredUser as $user){
    // 					if($user->user_expired != null){
    // 					$userList[] =  ['userid'=>$user->id,'name'=>$user->name];
    // 					}
    // 				}
    // 			}

    // 		}

    // 		if($usertype=="4")
    // 		{
    // 			$getAllApps = User::with('user_apps')->where('role_id',2)->get();
    // 			foreach($getAllApps as $user){
    // 				$userList[] =  ['userid'=>$user->id,'name'=>$user->name];
    // 			}

    // 		}
    // 		$finalUserList = [];
    // 		foreach($userList as $finalUser){

    // 			if(!in_array($finalUser['userid'],$finalUserList)){
    // 				$finalUserList[$finalUser['userid']] = ['userid'=>$finalUser['userid'],'name'=>ucfirst($finalUser['name'])];
    // 			}

    // 		}

    // 	}
    // }

    //       if(!empty($finalUserList)) {

    //           return $response = response()->json(['status' => true, 'userList' => $finalUserList]);
    //       } else {
    //           return $response = response()->json(['status' => true, 'userList' => [], 'message' => 'User not found']);
    //       }

    //   }

    public function getSubscriberUsers(Request $request)
    {
        $free = $paid = $expired = $all = [];
        $users = User::where('role_id', '2')
            ->orderBy('name', 'ASC')
            ->get();

        $currentDate = Carbon::now()->format('Y-m-d');

        foreach ($users as $user) {
            // dd($user->user_apps);
            if (count($user->user_apps) >= 2) {
                $free[] = ['userid' => $user->id, 'name' => $user->name];
            } elseif (count($user->user_apps) == 1) {
                $paid[] = ['userid' => $user->id, 'name' => $user->name];

                foreach ($user->expierd as $app) {
                    // dd($app->will_expire_on);
                    $will_expired = Carbon::parse($app->will_expire_on);
                    // dd($will_expired);
                    if ($will_expired <= $currentDate) {
                        $expired[] = ['userid' => $user->id, 'name' => $user->name];
                        // dd($expired);
                    }
                }
            } else {
                $all[] = ['userid' => $user->id, 'name' => $user->name];
            }
        }

        $usertypeArray = isset($request->usertypeArray) ? $request->usertypeArray : [];
        $userList = $finalUserList = [];
        // dd($usertypeArray);

        if (!isset($usertypeArray) || !empty($usertypeArray)) {
            if ($usertypeArray == '1') {
                $userList = $free;
            }

            if ($usertypeArray == '2') {
                $userList = $paid;
            }

            if ($usertypeArray == '3') {
                $userList = $expired;
            }

            // if ($usertype == "4") {
            //     $userList = $all;
            // }

            $finalUserList = [];
            // dd($finalUserList);
            foreach ($userList as $finalUser) {
                if (!in_array($finalUser['userid'], $finalUserList)) {
                    $finalUserList[$finalUser['userid']] = ['userid' => $finalUser['userid'], 'name' => ucfirst($finalUser['name'])];
                }
            }
        }

        if (!empty($finalUserList)) {
            return $response = response()->json(['status' => true, 'userList' => $finalUserList]);
        } else {
            return $response = response()->json(['status' => true, 'userList' => [], 'message' => 'User not found']);
        }
    }

    public function instantReedemCoupon($couponArray)
    {
        // $type = $couponArray['type'];
        if($couponArray['type'] == 'Fixed Amount' || $couponArray['type'] == 'Percentage Discount'){
            
            if($couponArray['type'] == 'Fixed Amount'){ $type = 'flat_rate'; }else{ $type = 'percentage'; }

            if($type == 'percentage'){
                $discount = $couponArray['details']['discount_percent'];
            } else {
                $discount = $couponArray['details']['discount_amount'];
            }
            
            
            $coupon = new Coupon();
            $coupon->name = $couponArray['phone'];
            $coupon->mobile = $couponArray['phone'];
            $coupon->code = $couponArray['reedemCode'];
            $coupon->description = 'Reedem code coupon form instant challenge for mobile '.$couponArray['phone'];
            $coupon->coupon_for = 'individuals';
            $coupon->coupon_type = $type;
            $coupon->discount = $discount;
            $coupon->no_of_time = 1;
            $coupon->start_date = Carbon::now()->format('Y-m-d');
            $coupon->end_date = Carbon::now()->format('Y-m-d');
            $coupon->save();
            return $coupon;
        }
            
    }
}
