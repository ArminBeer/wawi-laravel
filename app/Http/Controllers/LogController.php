<?php

namespace App\Http\Controllers;
use App\Models\Log;
use App\Models\Zubereitung;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::orderBy('created_at', 'DESC')->get();

        $models = array (
            'API' => 'Kassensystem',
            'App\Models\Bestellung' => 'Bestellung',
            'App\Models\Inventur' => 'Inventur',
            'App\Models\Lagerort' => 'Lagerort',
            'App\Models\Lieferant' => 'Lieferant',
            'App\Models\Produkt' => 'Mise en Place',
            'App\Models\Rezept' => 'Gericht',
            'App\Models\User' => 'Benutzer',
            'App\Models\Zubereitung' => 'Zubereitung',
            'App\Models\Zutat' => 'Lager',
            'App\Models\Kategorie' => 'Kategorie',
            'App\Models\Tag' => 'Tag',
        );

        return view('log.index', array (
            'logs' => $logs,
            'models' => $models,
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
