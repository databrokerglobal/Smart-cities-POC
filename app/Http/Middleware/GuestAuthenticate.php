<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class GuestAuthenticate
{
    public function handle($request, Closure $next) {
        if (Session::has('admin_user')) {
            return redirect()->route('admin.index');
        } else {
           return $next($request); 
       }
    }
}
