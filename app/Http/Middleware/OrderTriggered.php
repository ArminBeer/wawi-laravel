<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Bestellung;

class OrderTriggered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $bestellung = Bestellung::where('id', $request->route()->parameters()['bestellung'])->first();

        if($bestellung->latestActivity()->status == "bestellt"){
            return redirect('/bestellungen')->with('error', 'Diese Bestellung wurde bereits versendet und kann nicht mehr bearbeitet werden!');
        }

        return $next($request);

    }
}
