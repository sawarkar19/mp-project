<?php

namespace App\Http\Controllers\SeoManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('seomanager');
    }
	
	public function dashboard()
    {
        return view('seomanager.dashboard');
    }

    
}
