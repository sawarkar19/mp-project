<?php

namespace App\Http\Controllers\Account;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function coupons(Request $request)
    {
        /* all coupon show data, search and pagination start */
        $conditions = [];
        $numberOfPage = $request->per_page ?? 10;
        if (!empty($request->src) && !empty($request->term)) {
            $allCoupons = Coupon::where($request->term, 'like', '%' . $request->src. '%')->orderBy('id', 'desc')->paginate($numberOfPage);
            $conditions[] = [$request->term, 'like', '%' . $request->src . '%']; 
        } else {
            $allCoupons = Coupon::orderBy('id', 'desc')->paginate($request->per_page);  
        }
        /* all coupon show data, search and pagination start */
        
        return view('account.coupons.index', compact('allCoupons', 'conditions', 'request'));

    }
}
