<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Userplan;
use App\Models\UserChannel;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->logout_user == 1){
            Auth::logout();
        }
        
        if(isset($request->user()->id) && !empty($request->user()->id)){
            $userLoginInfo = UserLogin::where('user_id', $request->user()->id)->orderBy('id', 'DESC')->first();
            if($userLoginInfo==NULL){
                Auth::logout();
				return redirect('/login');
            }
            else if(isset($userLoginInfo)){
                $date = \Carbon\Carbon::now();
                $todayDate = $date->format('Y-m-d');
                $dbDate = \Carbon\Carbon::parse($userLoginInfo->wallet_deduct_date)->format('Y-m-d');
                $todayTimeStamp = strtotime($todayDate);
                $loginTimeStamp = strtotime($dbDate);

                if($loginTimeStamp != $todayTimeStamp){
                    Auth::logout();
				    return redirect('/login');
                }
            }
        }
		
		if ($request->user() && $request->user()->status != 1){
			Auth::logout();
			return redirect('/login');
        }
		
		if ($request->user() && $request->user()->role_id != '3'){
            return Response(view('errors.401')->with('role', 'Employee'));
        }
        
        return $next($request);
    }
}
