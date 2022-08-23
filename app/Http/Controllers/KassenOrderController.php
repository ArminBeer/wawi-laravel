<?php

namespace App\Http\Controllers;

use App\Models\KassenOrder;
use App\Models\BusinessPeriod;
use App\Traits\GastrofixOrders;
use Illuminate\Http\Request;

class KassenOrderController extends Controller
{
    use GastrofixOrders;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//         foreach (config('services.lightspeed') as $gastro){
            // $businessPeriods = $this->getBusinessPeriods($gastro);
//        foreach ($businessPeriods as $businessPeriod) {
//            $this->getOrders($businessPeriod->id);
//        }
//        dd(KassenOrder::all());

//         }
        return $this->sync($request, "latest");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sync(Request $request, $periodId)
    {
        if ($periodId == "latest") {
            $businessPeriod = BusinessPeriod::whereNull('finishPeriodTimestamp')->first();
            if (!$businessPeriod) {
                $businessPeriod = BusinessPeriod::latest('finishPeriodTimestamp')->firstOrFail();
            }
            $new_orders = $this->getNewOrders($businessPeriod->id);
            // dd($new_orders);
        } else if ($periodId == "all") {
            foreach (config('services.lightspeed') as $gastro){
                $businessPeriods = $this->getBusinessPeriods($gastro);
                foreach ($businessPeriods as $businessPeriod) {
                    $this->getNewOrders($businessPeriod->id);
                }
            }
        } else {
            $this->getNewOrders($periodId);
        }
        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KassenOrder  $kassenOrder
     * @return \Illuminate\Http\Response
     */
    public function show(KassenOrder $kassenOrder)
    {
        //
    }
}
