<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zutat;
use App\Models\Tag;
use App\Models\Kategorie;
use App\Models\Inventur_Activity;

class InventarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventare = Zutat::where('lagerort', 1 )->get();

        return view('inventar.index', array (
            'inventare' => $inventare
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategorien = Kategorie::pluck('name', 'id')->toArray();
        $tags = Tag::pluck('name', 'id')->toArray();

        return view('inventar.create', array(
            'kategorien' => $kategorien,
            'tags' => $tags
        ));
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
            'inventar_name' => 'required',
            'lagerbestand' => 'required',
            'image' => 'mimes:jpeg,bmp,png,svg',
        ]);

        $inventar = new Zutat;
        $inventar->name = $request->input('inventar_name');
        $inventar->lagerbestand = floatval($request->input('lagerbestand'));
        $inventar->mindestbestand = floatval($request->input('mindestbestand'));
        $inventar->lieferant = 0;
        $inventar->einheit = 0;
        $inventar->lagerort = 1;

        // Image
         if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage') . '/images', $imageName);
            $inventar->picture = '/images/' . $imageName;
        }

        $inventar->save();

        $inventar->kategorien()->sync($request->input('kategorien'));
        $inventar->tags()->sync($request->input('tags'));

        return redirect('/inventare')->with('success', 'Inventar erweitert');
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        $inventar = Zutat::where('id', $id)->first();

        return view('inventar.add', array (
            'inventar' => $inventar,
        ));

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addstore(Request $request, $id)
    {
        $this->validate($request, [
            'addValue' => 'required',
        ]);

        $inventar = Zutat::where('id', $id)->first();

        $addedStock = $request->input('addValue');

        $inventurActivity = new Inventur_Activity;
        $inventurActivity->inventur = 0;
        $inventurActivity->zutat = $inventar->id;
        $inventurActivity->old_value = $inventar->lagerbestand;

        $inventar->lagerbestand += $addedStock;
        $inventar->save();

        $inventurActivity->new_value = $inventar->lagerbestand;
        $inventurActivity->save();

        return redirect('/inventare')->with('success', 'Laberbestand angepasst');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventar = Zutat::where('id', $id)->withTrashed()->first();

        $activeKategorien = [];
        $activeKategorienObjects = $inventar->kategorien()->get()->toArray();
        if($activeKategorienObjects)
            foreach($activeKategorienObjects as $item)
                $activeKategorien[] = $item['id'];

        $activeTags = [];
        $activeTagsObjects = $inventar->tags()->get()->toArray();
        if($activeTagsObjects)
            foreach($activeTagsObjects as $item)
                $activeTags[] = $item['id'];

        $kategorien = Kategorie::pluck('name', 'id')->toArray();
        $tags = Tag::pluck('name', 'id')->toArray();

        $activities = $inventar->inventurActivities()->orderBy('updated_at', 'DESC')->get();

        return view('inventar.edit', array (
            'inventar' => $inventar,
            'activities' => $activities,
            'kategorien' => $kategorien,
            'activeKategorien' => $activeKategorien,
            'tags' => $tags,
            'activeTags' => $activeTags,
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
            'inventar_name' => 'required',
            'lagerbestand' => 'required',
            'mindestbestand' => 'required',
            'image' => 'mimes:jpeg,bmp,png,svg',
        ]);

        $inventar = Zutat::where('id', $id)->first();

        if ($request->input('lagerbestand') != $inventar->lagerbestand){
            $inventurActivity = new Inventur_Activity;
            $inventurActivity->inventur = 0;
            $inventurActivity->zutat = $inventar->id;
            $inventurActivity->old_value = $inventar->lagerbestand;
            $inventurActivity->new_value = $request->input('lagerbestand');
            $inventurActivity->save();
        }

        $inventar->name = $request->input('inventar_name');
        $inventar->lagerbestand = floatval($request->input('lagerbestand'));
        $inventar->mindestbestand = floatval($request->input('mindestbestand'));

        // Image
        if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage') . '/images', $imageName);
            $inventar->picture = '/images/' . $imageName;
        }
        $inventar->save();

        $inventar->kategorien()->sync($request->input('kategorien'));
        $inventar->tags()->sync($request->input('tags'));

        return redirect('/inventare')->with('success', 'Objekt bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventar = Zutat::where('id', $id)->first();

        $inventar->delete();

        return redirect('/inventare')->with('success', 'Objekt gelöscht');
    }
}
