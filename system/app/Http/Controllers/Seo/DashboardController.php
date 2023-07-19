<?php

namespace App\Http\Controllers\Seo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('seo');
    }
	
	public function dashboard()
    {
        return view('seo.dashboard');
    }

    
}
