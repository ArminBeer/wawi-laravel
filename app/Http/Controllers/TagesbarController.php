<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Counter;

class TagesbarController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counters = Counter::groupBy('type')->groupBy('day')->orderBy('day', 'DESC')->selectRaw('day')->selectRaw('count(*) as total, type')->selectRaw('SUM(price) as total_revenue')->get();
        $daily_revenue = Counter::groupBy('day')->orderBy('day', 'DESC')->selectRaw('day')->selectRaw('SUM(price) as total_revenue')->get();

        return view('tagesbar.index', array (
            'counters' => $counters,
            'daily_revenue' => $daily_revenue,
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function counter()
    {
        return view('tagesbar.counter');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string  $type
     * @param  int  $amount
     * @param  float  $price
     * @return \Illuminate\Http\Response
     */
    public function setItem($type, $amount, $price)
    {
        $i = 0;
        while ($i<$amount) {
            Counter::create([
                'day' => date("Y-m-d"),
                'type' => $type,
                'price' => $price,
            ]);
            $i++;
        }

        return response()->json(true);
    }
}
