<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginMiddleware
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
        if ($request->session()->get('logged') == 1) {
            $user_permission = session()->get('user_permission');

            if ($user_permission == 0) {
                return redirect(route('adminIndex'));
            }
            if ($user_permission == 1) {
                return redirect(route('employeeIndex'));
            }
          
        } else {
            return $next($request);
        }
    }
}
