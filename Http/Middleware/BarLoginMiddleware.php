<?php

namespace Modules\Bar\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class BarLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if(Auth::check() && Auth::user()->hasRole('bar')){
            return $next($request);
        } else {
            return redirect()->route('bar.login');
        }
    }
}
