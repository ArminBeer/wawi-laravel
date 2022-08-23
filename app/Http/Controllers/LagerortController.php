<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lagerort;

class LagerortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lagerorte = Lagerort::all();

        return view('lagerort.index', array (
            'lagerorte' => $lagerorte
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'lagerort_name' => 'required',
        ]);

        $lagerort = new Lagerort;
        $lagerort->name = $request->input('lagerort_name');
        $lagerort->picture = $request->input('picture');

        $lagerort->save();

        return redirect('/lagerorte')->with('success', 'Lagerort erstellt');
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
        $lagerort = Lagerort::where('id', $id)->first();

        return view('lagerort.edit', array (
            'lagerort' => $lagerort
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
            'lagerort_name' => 'required',
        ]);

        $lagerort = Lagerort::where('id', $id)->first();

        $lagerort->name = $request->input('lagerort_name');

        $lagerort->save();

        return redirect('/lagerorte')->with('success', 'Lagerort bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lagerort = Lagerort::where('id', $id)->first();

        $lagerort->delete();

        return redirect('/lagerorte')->with('success', 'Lagerort gelöscht');
    }
}
