<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Session;


use App\Models\FrontEndSearch;

class FrontEndSearchContoller extends Controller
{
    //

    public function __construct()
    {
        // $this->middleware('guest, auth');
    }

    public function index(Request $request){

        $results = FrontEndSearch::Search($request->keyword)->get();

        dd($results);

    }

    public function results(Request $request){

        $results = FrontEndSearch::Search($request->keyword)->get();

        dd($results);

    }
}
