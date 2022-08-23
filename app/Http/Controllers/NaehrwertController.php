<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Naehrwert;

class NaehrwertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $naehrwerte = Naehrwert::all();

        return view('naehrwert.index', array (
            'naehrwerte' => $naehrwerte->toArray()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('naehrwert.create');
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
            'naehrwert_name' => 'required',
            'einheit' => 'required',
        ]);

        $naehrwert = new Naehrwert;
        $naehrwert->name = $request->input('naehrwert_name');
        $naehrwert->einheit = $request->input('einheit');

        $naehrwert->save();

        return redirect('/naehrwerte')->with('success', 'Nährwert erstellt');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $naehrwert = Naehrwert::where('id', $id)->first();

        return view('naehrwert.edit', array (
            'naehrwert' => $naehrwert
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
            'naehrwert_name' => 'required',
        ]);

        $naehrwert = Naehrwert::where('id', $id)->first();
        $naehrwert->name = $request->input('naehrwert_name');
        $naehrwert->einheit = $request->input('einheit');

        $naehrwert->save();

        return redirect('/naehrwerte')->with('success', 'Nährwert bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $naehrwert = Naehrwert::where('id', $id)->first();

        $naehrwert->delete();

        return redirect('/naehrwerte')->with('success', 'Nährwert gelöscht');
    }
}
