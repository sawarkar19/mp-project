<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Category;
use App\Models\Categorymeta;

class SettingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('account');
    }

    public function settings()
    {
        
        $payment_gateways = Category::with('preview')->where('type', 'payment_gateway')->whereIn('display', [1,0])->get();
        
        return view('account.settings', compact('payment_gateways'));

    }
}
