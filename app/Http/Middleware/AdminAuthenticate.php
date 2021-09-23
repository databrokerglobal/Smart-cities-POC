<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminAuthenticate
{
    public function handle($request, Closure $next) {
        if (Session::has('admin_user')) {
            return $next($request);
        } else {
            return redirect()->route('admin.login');
        }
    }
}
