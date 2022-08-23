<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allergen;

class AllergenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allergene = Allergen::all();

        return view('allergen.index', array (
            'allergene' => $allergene->toArray()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('allergen.create');
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
            'allergen_name' => 'required',
        ]);

        $allergen = new Allergen;
        $allergen->name = $request->input('allergen_name');
        $allergen->tag = $request->input('tag');

        $allergen->save();

        return redirect('/allergene')->with('success', 'Allergen erstellt');
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
        $allergen = Allergen::where('id', $id)->first();

        return view('allergen.edit', array (
            'allergen' => $allergen
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
            'allergen_name' => 'required',
        ]);

        $allergen = Allergen::where('id', $id)->first();
        $allergen->name = $request->input('allergen_name');
        $allergen->tag = $request->input('tag');

        $allergen->save();

        return redirect('/allergene')->with('success', 'Allergen bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $allergen = Allergen::where('id', $id)->first();

        $allergen->delete();

        return redirect('/allergene')->with('success', 'Allergen gelöscht');
    }
}
