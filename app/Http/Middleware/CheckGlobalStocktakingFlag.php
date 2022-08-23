<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Global_Inventurflag;

class CheckGlobalStocktakingFlag
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if(Global_Inventurflag::where('id', $type)->first()->active == 1){
            return redirect('/dashboard')->with('error', 'Aktuell wird eine Inventur durchgeführt! Daher keine Änderungen möglich!');
        }
        return $next($request);
    }
}
