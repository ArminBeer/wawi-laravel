<?php

namespace App\Http\Controllers;

use App\Models\Bereich;
use App\Models\Kategorie;
use App\Models\Tag;
use Illuminate\Http\Request;

class KategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategorien = Kategorie::all();
        $bereiche = Bereich::pluck('name', 'id')->toArray();
        $tags = Tag::all();


        return view('kategorie.index', array (
            'kategorien' => $kategorien,
            'tags' => $tags,
            'bereiche' => $bereiche,
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
            'kategorie_name' => 'required',
            'bereiche' => 'required',
        ]);

        if ($request->input('cat_id')){
            $kategorie = Kategorie::where('id', $request->input('cat_id'))->first();
        } else {
            $kategorie = new Kategorie;
        }

        $kategorie->name = $request->input('kategorie_name');
        $kategorie->save();

        $kategorie->bereiche()->sync($request->input('bereiche'));

        return redirect('/kategorien')->with('success', 'Kategorie erstellt');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTag(Request $request)
    {
        $this->validate($request, [
            'tag_name' => 'required',
        ]);

        if ($request->input('tag_id')){
            $tag = Tag::where('id', $request->input('tag_id'))->first();
        } else {
            $tag = new Tag;
        }

        $tag->name = $request->input('tag_name');
        $tag->save();

        return redirect('/kategorien')->with('success', 'Tag erstellt');
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
        //
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
        $kategorie = Kategorie::where('id', $id)->first();

        $kategorie->delete();

        return redirect('/kategorien')->with('success', 'Kategorie gelöscht');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTag($id)
    {
        $tag = Tag::where('id', $id)->first();

        $tag->delete();

        return redirect('/kategorien')->with('success', 'Tag gelöscht');
    }
}
