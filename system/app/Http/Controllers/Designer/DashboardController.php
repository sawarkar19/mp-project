<?php

namespace App\Http\Controllers\Designer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('designer');
    }
	
	public function dashboard()
    {

        return view('designer.dashboard');
        
    }

}
