<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SeoManager
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

        if ($request->user() && $request->user()->role_id != '6'){
            return Response(view('errors.401')->with('role', 'SeoManager'));
        }
        
        return $next($request);
    }
}
