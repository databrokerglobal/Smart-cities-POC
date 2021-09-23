<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ReturnAfterAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next) {        
        if(strpos($request->url(), 'register_nl') === false)
            $request->session()->put('url.intended', $request->url());       
        return $next($request);
    }
}
