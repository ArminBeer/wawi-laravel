<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zutat;
use App\Models\Einheit;

class ApiEinheitenController extends Controller
{
    /**
     * Get available Einheiten for Zutat.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $zutat = Zutat::where('id', $id)->first();
        $einheiten = $zutat->getAvailableEinheiten();

        return response()->json($einheiten);
    }

    public function checkConversion($id)
    {
        $einheit = Einheit::where('id', $id)->first();

        if ($einheit->conversion_needed)
            return response()->json(true);
        else
            return response()->json(false);
    }

}
