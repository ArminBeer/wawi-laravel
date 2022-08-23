<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Einheit;
use App\Models\Umrechnung;

class EinheitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $einheiten = Einheit::all();
        $allEinheiten = Einheit::pluck('name', 'id')->toArray();

        $grundeinheiten = Einheit::where('grundeinheit', 1)->where('conversion_needed', 0)->pluck('name', 'id')->toArray();
        $noSpezialEinheiten = Einheit::where('conversion_needed', 0)->pluck('name', 'id')->toArray();
        $umrechnungen = Umrechnung::all();

        return view('einheit.index', array (
            'einheiten' => $einheiten,
            'grundeinheiten' => $grundeinheiten,
            'noSpezialEinheiten' => $noSpezialEinheiten,
            'umrechnungen' => $umrechnungen,
            'allEinheiten' => $allEinheiten
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('einheit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'einheiten_name' => 'required',
            'kuerzel' => 'required',
        ]);


        if ($request->input('einheit_id')){
            $einheit = Einheit::where('id', $request->input('einheit_id'))->first();
        } else {
            $einheit = new Einheit;
        }

        $einheit->name = $request->input('einheiten_name');
        $einheit->kuerzel = $request->input('kuerzel');
        $einheit->grundeinheit = $request->input('grundeinheit') ? 1 : 0;
        $einheit->conversion_needed = $request->input('conversion_needed') ? 1 : 0;

        $einheit->save();

        return redirect('/einheiten')->with('success', 'Einheit erstellt');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUmrechnung(Request $request)
    {
        $this->validate($request, [
            'factor' => 'required',
        ]);

        if ($request->input('umrechnung_id')){
            $umrechnung = Umrechnung::where('id', $request->input('umrechnung_id'))->first();
        } else {
            $umrechnung = new Umrechnung;
        }

        $umrechnung->ist_einheit = $request->input('ist_einheit');
        $umrechnung->soll_einheit = $request->input('soll_einheit');
        $umrechnung->faktor = floatval(str_replace(',', '.', $request->input('factor')));

        $umrechnung->save();

        return redirect('/einheiten')->with('success', 'Einheit erstellt');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $einheit = Einheit::where('id', $id)->first();

        $einheit->delete();

        return redirect('/einheiten')->with('success', 'Einheit gelöscht');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUmrechnung($id)
    {
        $umrechnung = Umrechnung::where('id', $id)->first();

        $umrechnung->delete();

        return redirect('/einheiten')->with('success', 'Umrechnung gelöscht');
    }

}
