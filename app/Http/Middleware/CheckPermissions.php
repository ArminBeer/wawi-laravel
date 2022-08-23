<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     * @return mixed
     */

    public function handle(Request $request, Closure $next, $permission)
    {
        if(!auth()->user()->hasPermission($permission)){
            return redirect('/dashboard')->with('error', 'Hierfür fehlen Ihnen Berechtigungen');
        }
        return $next($request);
    }

}
