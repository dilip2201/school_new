<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Localization
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
        if (Auth::check()) {
            if (Auth::user()->language_id > 0 && !empty(Auth::user()->language_id)) {

                \App::setlocale(Auth::user()->language->code);
            }else{
                \App::setlocale('en');
            }
        }
        return $next($request);
    }
}
