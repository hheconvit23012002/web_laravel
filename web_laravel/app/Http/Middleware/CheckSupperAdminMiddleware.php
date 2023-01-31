<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSupperAdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(session()->get('level') === 0){
            return  redirect()->back();
        }
        return $next($request);

    }
}
