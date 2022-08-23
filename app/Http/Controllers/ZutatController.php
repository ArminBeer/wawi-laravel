<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zutat;
use App\Models\Allergen;
use App\Models\Einheit;
use App\Models\Inventur_Activity;
use App\Models\Kategorie;
use App\Models\Lieferant;
use App\Models\Umrechnung;
use App\Models\Lagerort;
use App\Models\Tag;
use App\Models\Bereich;

class ZutatController extends Controller
{

    public function __construct( \Illuminate\Routing\Redirector $redirect)
    {
        // authentication
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zutaten = Zutat::where('lagerort', '!=', 1)->with('allergene', 'lieferant', 'einheit')->get();
        $bereiche = Bereich::pluck('name', 'id')->toArray();
        $kategorien = Kategorie::pluck('name', 'id')->toArray();
        $bereicheArr = [];
        foreach($zutaten as $zutat) {
            foreach($zutat->kategorien()->get() as $kategorie) {
                foreach($kategorie->bereiche()->get() as $bereich) {
                    $bereicheArr[$zutat->id][$bereich->name] = $bereich->id;
                }
            }
        }

        return view('zutat.index', array (
            'zutaten' => $zutaten,
            'kategorien' => $kategorien,
            'bereiche' => $bereiche,
            'bereicheArr' => $bereicheArr
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lieferanten = Lieferant::where('id', '!=', 1)->pluck('name', 'id')->toArray();
        $allergene = Allergen::pluck('name', 'id')->toArray();
        $einheiten = Einheit::where('grundeinheit', 1)->pluck('name','id')->toArray();
        $grundeinheiten = Einheit::where('grundeinheit', 1)->where('conversion_needed', 0)->pluck('name','id')->toArray();
        $lagerorte = Lagerort::pluck('name','id')->toArray();
        $kategorien = Kategorie::pluck('name', 'id')->toArray();
        $tags = Tag::pluck('name', 'id')->toArray();

        return view('zutat.create', array(
            'lieferanten' => $lieferanten,
            'allergene' => $allergene,
            'einheiten' => $einheiten,
            'grundeinheiten' => $grundeinheiten,
            'lagerorte' => $lagerorte,
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
            'zutat_name' => 'required|unique:zutaten,name',
            'lagerbestand' => 'required',
            'mindestbestand' => 'required',
            'lagerort' => 'required',
            'image' => 'mimes:jpeg,bmp,png,svg',
        ]);

        $zutat = new Zutat;
        $zutat->name = $request->input('zutat_name');
        $zutat->lagerbestand = floatval(str_replace(',', '.', $request->input('lagerbestand')));
        $zutat->mindestbestand = floatval(str_replace(',', '.', $request->input('mindestbestand')));
        $zutat->lieferant = $request->input('lieferant');
        $zutat->einheit = $request->input('einheit');
        $zutat->round = ($request->input('round') ? 1 : 0);
        $zutat->lagerort = $request->input('lagerort');

        $einheit = Einheit::where('id', $request->input('einheit'))->first();
        if ($einheit->conversion_needed){
            $zutat->conversion_einheit = $request->input('conversionEinheit');
            $zutat->faktor = floatval(str_replace(',', '.', $request->input('faktor')));
        }else {
            $zutat->conversion_einheit = null;
            $zutat->faktor = null;
        }


        // Image
         if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage') . '/images', $imageName);
            $zutat->picture = '/images/' . $imageName;
        }

        $zutat->save();

        $zutat->allergene()->sync($request->input('allergene'));
        $zutat->kategorien()->sync($request->input('kategorien'));
        $zutat->tags()->sync($request->input('tags'));

        return redirect('/zutaten')->with('success', 'Zutat erstellt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zutat = Zutat::where('id', $id)->with('lieferant', 'allergene')->first();

        return view('zutat.show', array (
            'zutat' => $zutat->toArray()
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        $zutat = Zutat::where('id', $id)->first();

        $einheiten = $zutat->getAvailableEinheiten();

        return view('zutat.add', array (
            'zutat' => $zutat,
            'einheiten' => $einheiten,
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

        $zutat = Zutat::where('id', $id)->first();
        $floatAddValue = floatval(str_replace(',', '.', $request->input('addValue')));
        // Haupteinheit
        $mainEinheit = $zutat->einheit;
        // Angeforderte Einheit
        $requestedEinheit = intval($request->input('einheit'));

        // Entsprechende Umrechnung finden
        if ($mainEinheit != $requestedEinheit){
            $umrechnung = Umrechnung::where('ist_einheit', $requestedEinheit)->where('soll_einheit', $mainEinheit)->orWhere('soll_einheit', $requestedEinheit)->where('ist_einheit', $mainEinheit)->first();

            if($mainEinheit == $umrechnung->soll_einheit)
                $faktor = $umrechnung->faktor;
            else
                $faktor = 1/($umrechnung->faktor);

            $addedStock = $floatAddValue*$faktor;
        } else {
            $addedStock = $floatAddValue;
        }

        $inventurActivity = new Inventur_Activity;
        $inventurActivity->inventur = 0;
        $inventurActivity->zutat = $zutat->id;
        $inventurActivity->old_value = $zutat->lagerbestand;

        $zutat->lagerbestand += $addedStock;
        $zutat->save();

        $inventurActivity->new_value = $zutat->lagerbestand;
        $inventurActivity->save();

        return redirect('/zutaten')->with('success', 'Laberbestand angepasst');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $zutat = Zutat::where('id', $id)->withTrashed()->first();

        $activeAllergene = [];
        $activeAllergeneObjects = $zutat->allergene()->get()->toArray();
        if($activeAllergeneObjects)
            foreach($activeAllergeneObjects as $item)
                $activeAllergene[] = $item['id'];

        $activeKategorien = [];
        $activeKategorienObjects = $zutat->kategorien()->get()->toArray();
        if($activeKategorienObjects)
            foreach($activeKategorienObjects as $item)
                $activeKategorien[] = $item['id'];

        $activeTags = [];
        $activeTagsObjects = $zutat->tags()->get()->toArray();
        if($activeTagsObjects)
            foreach($activeTagsObjects as $item)
                $activeTags[] = $item['id'];

        if ($zutat->lieferant != 1)
            $lieferanten = Lieferant::where('id', '!=', 1)->pluck('name', 'id')->toArray();
        else
            $lieferanten = Lieferant::where('id', 1)->pluck('name', 'id')->toArray();

        $allergene = Allergen::pluck('name', 'id')->toArray();
        $einheiten = Einheit::where('grundeinheit', 1)->pluck('name','id')->toArray();
        $grundeinheiten = Einheit::where('grundeinheit', 1)->where('conversion_needed', 0)->pluck('name','id')->toArray();
        $lagerorte = Lagerort::pluck('name', 'id')->toArray();
        $kategorien = Kategorie::pluck('name', 'id')->toArray();
        $tags = Tag::pluck('name', 'id')->toArray();

        $activities = $zutat->inventurActivities()->orderBy('updated_at', 'DESC')->get();

        return view('zutat.edit', array (
            'zutat' => $zutat,
            'activeAllergene' => $activeAllergene,
            'allergene' => $allergene,
            'lieferanten' => $lieferanten,
            'lagerorte' => $lagerorte,
            'einheiten' => $einheiten,
            'grundeinheiten' => $grundeinheiten,
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
            'zutat_name' => 'required',
            'lagerbestand' => 'required',
            'mindestbestand' => 'required',
            'lagerort' => 'required',
            'image' => 'mimes:jpeg,bmp,png,svg',
        ]);

        $zutat = Zutat::where('id', $id)->first();

        if ($request->input('lagerbestand') != $zutat->lagerbestand){
            $inventurActivity = new Inventur_Activity;
            $inventurActivity->inventur = 0;
            $inventurActivity->zutat = $zutat->id;
            $inventurActivity->old_value = $zutat->lagerbestand;
            $inventurActivity->new_value = $request->input('lagerbestand');
            $inventurActivity->save();
        }

        $zutat->name = $request->input('zutat_name');
        $zutat->lagerbestand = floatval(str_replace(',', '.', $request->input('lagerbestand')));
        $zutat->mindestbestand = floatval(str_replace(',', '.', $request->input('mindestbestand')));
        $zutat->lieferant = $request->input('lieferant');
        $zutat->einheit = $request->input('einheit');
        $zutat->round = ($request->input('round') ? 1 : 0);
        $zutat->lagerort = $request->input('lagerort');

        $einheit = Einheit::where('id', $request->input('einheit'))->first();
        if ($einheit->conversion_needed){
            $zutat->conversion_einheit = $request->input('conversionEinheit');
            $zutat->faktor = floatval(str_replace(',', '.', $request->input('faktor')));
        }else {
            $zutat->conversion_einheit = null;
            $zutat->faktor = null;
        }


        // Image
        if ($request->image) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('storage') . '/images', $imageName);
            $zutat->picture = '/images/' . $imageName;
        }
        $zutat->save();

        $zutat->allergene()->sync($request->input('allergene'));
        $zutat->kategorien()->sync($request->input('kategorien'));
        $zutat->tags()->sync($request->input('tags'));

        return redirect('/zutaten')->with('success', 'Zutat bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $zutat = Zutat::where('id', $id)->first();

        $zutat->delete();

        return redirect('/zutaten')->with('success', 'Zutat gelöscht');
    }
}
