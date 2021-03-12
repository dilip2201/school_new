<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class InactiveCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(Auth::check() && auth()->user()->status == 'inactive'){
            Auth::guard('web')->logout();
            return redirect('/login');
        }
        return $next($request);
    }
}
