<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ( !Auth::guard('staff')->user() ){
            abort(403);
        }

        return $next($request);
    }
}
