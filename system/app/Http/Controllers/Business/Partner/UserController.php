<?php

namespace App\Http\Controllers\Business\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\Business\CommonSettingController;

use App\Models\User;
use Hash;
use Auth;
use DB;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function index(){
        $users = User::with('paidTransaction')->where("enterprise_id",Auth::id())->orderBy('id','desc')->latest()->paginate(10);


        $planData = CommonSettingController::getBusinessPlanDetails();
        $notification_list = CommonSettingController::getNotification();

        return view('partner.users.index', compact('users','notification_list','planData'));
    }
}
