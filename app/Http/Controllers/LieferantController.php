<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lieferant;
use App\Rules\OnlyAscii;

class LieferantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lieferanten = Lieferant::all();

        return view('lieferant.index', array (
            'lieferanten' => $lieferanten->toArray()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lieferant.create');
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
            'lieferant_name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', new OnlyAscii],
            'ansprechpartner' => 'required',
        ]);

        $lieferant = new Lieferant;
        $lieferant->name = $request->input('lieferant_name');
        $lieferant->email = $request->input('email');
        $lieferant->ansprechpartner = $request->input('ansprechpartner');
        $lieferant->telefon = $request->input('telefon');
        $lieferant->ort = $request->input('ort');
        $lieferant->plz = $request->input('plz');
        $lieferant->strasse = $request->input('strasse');
        $lieferant->land = $request->input('land');

        $lieferant->save();

        return redirect('/lieferanten')->with('success', 'Lieferant erstellt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lieferant = Lieferant::where('id', $id)->first();

        return view('lieferant.show', array (
            'lieferant' => $lieferant->toArray(),
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lieferant = Lieferant::where('id', $id)->first();

        return view('lieferant.edit', array (
            'lieferant' => $lieferant
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'lieferant_name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', new OnlyAscii],
            'ansprechpartner' => 'required',
        ]);

        $lieferant = Lieferant::where('id', $id)->first();
        $lieferant->name = $request->input('lieferant_name');
        $lieferant->email = $request->input('email');
        $lieferant->ansprechpartner = $request->input('ansprechpartner');
        $lieferant->telefon = $request->input('telefon');
        $lieferant->ort = $request->input('ort');
        $lieferant->plz = $request->input('plz');
        $lieferant->strasse = $request->input('strasse');
        $lieferant->land = $request->input('land');

        $lieferant->save();

        return redirect('/lieferanten')->with('success', 'Lieferant bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lieferant = Lieferant::where('id', $id)->first();

        $lieferant->delete();

        return redirect('/lieferanten')->with('success', 'Lieferant gelöscht');
    }
}
