<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\WhatsappSession;
use App\Models\Option;

use Session;

class Business
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
// dd(Auth::user());
        if(Auth::user()->logout_user == 1){
            Auth::logout();
        }

        if (str_contains(request()->path(), '/partner')) { 
            if(Auth::user()->is_enterprise == 1){
                Session(['current_panel' => 'partner']);
            }else{
                return Response(view('errors.401')->with('role', 'Business'));
            }
        }else{
            Session(['current_panel' => 'business']);
        }
    
        if ($request->user() && $request->user()->role_id != '2'){
            return Response(view('errors.401')->with('role', 'Business'));
        }
        
        if(isset($request->user()->pass_token) && $request->user()->pass_token != ''){
            return redirect()->to('/generate-password?token='.$request->user()->pass_token);
        }

        return $next($request);
    }
}
