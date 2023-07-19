<?php

namespace App\Http\Controllers\WaCloud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('wacloud');
    }
	
	public function dashboard()
    {

        return view('wacloud.dashboard');
        
    }

}
