<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Wacloud
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
        
        if ($request->user() && $request->user()->role_id != '9'){
            return Response(view('errors.401')->with('role', 'Wacloud'));
        }

        /*Clear Browser Cache*/
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0 "); // Proxies.
        
        return $next($request);
    }
}
