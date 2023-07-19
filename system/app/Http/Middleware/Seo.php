<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Seo
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
        
        if ($request->user() && $request->user()->role_id != '4'){
            return Response(view('errors.401')->with('role', 'Seo'));
        }
        
        return $next($request);
    }
}
