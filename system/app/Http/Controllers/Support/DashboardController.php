<?php

namespace App\Http\Controllers\Support;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('support');
    }
	
	public function dashboard()
    {
        return view('support.dashboard');
    }

    
}
