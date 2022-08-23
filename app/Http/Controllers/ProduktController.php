<?php

namespace App\Http\Controllers;

use App\Models\Einheit;
use App\Models\Produkt;
use App\Models\Umrechnung;
use Illuminate\Http\Request;
use App\Models\Zubereitung;
use App\Models\Zutat;
use App\Models\Lagerort;
use App\Models\Log;
use Intervention\Image\Facades\Image;

class ProduktController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        if ($type == 0)
            $produkte = Produkt::with('zubereitung')->get();
        else if ($type == 1)
            $produkte = Produkt::with('zubereitung')->where('type', 1)->get();
        else if ($type == 2)
            $produkte = Produkt::with('zubereitung')->where('type', 2)->get();
        else if ($type == 3)
            $produkte = Produkt::with('zubereitung')->where('type', 3)->get();

        return view('produkt.index', array (
            'produkte' => $produkte->toArray(),
            'type' => $type
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $zutaten = Zutat::where('lagerort', '!=', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $allEinheiten = Einheit::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $grundeinheiten = Einheit::where('grundeinheit', 1)->where('conversion_needed', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $allowedEinheiten = Einheit::where('grundeinheit', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $lagerorte = Lagerort::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('produkt.create', array (
            'zutaten' => $zutaten,
            'allEinheiten' => $allEinheiten,
            'allowedEinheiten' => $allowedEinheiten,
            'grundeinheiten' => $grundeinheiten,
            'lagerorte' => $lagerorte,
            'type' => $type,
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $type
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $this->validate($request, [
            'produkt_name' => 'required',
            'ertrag' => 'required',
            'zutat_einheiten.*' => 'required',
            'einheit' => 'required',
            'lagerort' => 'required',
            'mindestbestand' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
        ]);
        // sync each zutat
        $syncData = array();
        $allergeneData = array();
        foreach ($request->input('zutaten') as $key => $value){

            if ((!is_null($value)) && (!is_null($request->input('zutat_einheiten')[$key]))){
                $syncData[$value] = [
                    'menge' => floatval($request->input('mengen')[$key]),
                    'einheit' => intval($request->input('zutat_einheiten')[$key]),
                    'verlust' => floatval($request->input('zutat_verluste')[$key])
                ];

                foreach (Zutat::where('id', $value)->first()->allergene()->get() as $allergen){
                    if (!in_array($allergen['id'], $allergeneData))
                        $allergeneData[] = $allergen['id'];
                }
            }
        }

        // Mise en Place Zutat erstellen
        $zutat = new Zutat;
        $zutat->name = $request->input('produkt_name');
        $zutat->lagerbestand = 0;
        $zutat->round = $request->input('round');
        $zutat->lagerort = $request->input('lagerort');
        $zutat->lieferant = 1;
        $zutat->mindestbestand = floatval($request->input('mindestbestand'));
        $zutat->einheit = $request->input('einheit');

        $einheit = Einheit::where('id', $request->input('einheit'))->first();
        if ($einheit->conversion_needed){
            $zutat->conversion_einheit = $request->input('conversionEinheit');
            $zutat->faktor = floatval(str_replace(',', '.', $request->input('faktor')));
        }else {
            $zutat->conversion_einheit = null;
            $zutat->faktor = null;
        }

        $zutat->save();

        $zutat->allergene()->sync($allergeneData);

        // Zubereitung abspeichern
        $zubereitung = new Zubereitung;
        $zubereitung->description_short = $request->input('description_short');
        $zubereitung->description_long = $request->input('description_long');

        $zubereitung->save();

        // Produkt abspeichern
        $produkt = new Produkt;
        $produkt->name = $request->input('produkt_name');
        $produkt->type = $type;
        $produkt->zubereitung = $zubereitung['id'];
        $produkt->ertrag = floatval($request->input('ertrag'));
        $produkt->zutat = $zutat->id;

        // Image
        if ($request->image) {
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();

            $filePath = public_path('storage') . '/thumbnails';

            $img = Image::make($image->path());
            $img->resize(800, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('storage') . '/images';
            $image->move($filePath, $input['imagename']);

            $produkt->picture = '/thumbnails/' . $input['imagename'];
        }

        $produkt->save();
        $produkt->zutaten()->sync($syncData);

        return redirect($type .'/produkte')->with('success', 'Mise en Place erstellt');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produkt = Produkt::where('id', $id)->withTrashed()->with('zubereitung', 'zutaten')->first();
        $zutaten = Produkt::where('id', $id)->withTrashed()->first()->zutaten()->with('allergene', 'einheit')->get();
        $einheiten = Einheit::pluck('name', 'id')->toArray();

        // Search for Allergene without dublicates
        $allergene = [];
        foreach ($zutaten as $zutat){
            foreach ($zutat['allergene'] as $allergen)
                if (!in_array($allergen['name'], $allergene))
                    $allergene[] = $allergen['name'];
        }

        return view('produkt.show', array (
            'produkt' => $produkt->toArray(),
            'zutaten' => $zutaten,
            'einheiten' => $einheiten,
            'allergene' => $allergene
        ));
    }

    /**
     * Show Modal with produkt id in session.
     *
     * @param  int  $id
     */
    public function quantity($id)
    {
        $produkt = Produkt::where('id', $id)->first();
        $zutat = $produkt->producedZutat()->first();
        $produktErtrag = $produkt->ertrag;
        $produktEinheit = $zutat->einheit;

        $einheiten = $zutat->getAvailableEinheiten();

        // Show Modal to ask quantity of crafted produkte
        return redirect()->route('produkte.index', [$produkt->type])->with('quantity', $id)->with('link', "/" . $produkt->type . "/produkte")->with('einheiten', $einheiten)->with('produktErtrag', $produktErtrag)->with('produktEinheit', $produktEinheit);
    }

    /**
     * Craft produkt with quantity
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function craft(Request $request, $id)
    {
        $this->validate($request, [
            'quantity' => 'required',
            'einheit' => 'required',
        ]);

        $produkt = Produkt::where('id', $id)->first();

        // Initalizing form variables
        $multiplierInput = floatval(str_replace(',', '.', $request->input('multiplier')));
        $einheitInput = intval($request->input('einheit'));
        $quantityInput = floatval(str_replace(',', '.', $request->input('quantity')));

        // Lagerbestand der hergestellten Zutat angleichen
        $portion = $produkt->craft($multiplierInput, $quantityInput, $einheitInput);

        // Lagerbestände der Zutaten im Produkt angleichen
        foreach ($produkt->zutaten()->get() as $zutat){
            $requestedZutatEinheit = floatval($zutat->pivot->einheit);
            $requestedZutatMenge = floatval($zutat->pivot->menge);
            $requestedZutatVerlust = floatval($zutat->pivot->verlust);
            $zutat->updateIngredients($requestedZutatEinheit, $requestedZutatMenge, $requestedZutatVerlust, $portion);
        }

        // Redirect mit Success-Meldung
        return redirect($produkt->type . '/produkte')->with('success', 'Mise en Place hergestellt und Lagerbestand angepasst');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produkt = Produkt::where('id', $id)->with('zubereitung', 'producedZutat')->first();

        $activeZutaten = [];
        $activeZutatenObjects = Produkt::where('id', $id)->first()->zutaten()->get()->toArray();
        if($activeZutatenObjects){
            foreach($activeZutatenObjects as $item){
                $activeZutaten[] =  array(
                    'zutat' => $item['id'],
                    'menge' => $item['pivot']['menge'],
                    'einheit' => $item['pivot']['einheit'],
                    'verlust' => $item['pivot']['verlust']
                );
            }
        }

        $zutaten = Zutat::where('lagerort', '!=', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $allEinheiten = Einheit::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $grundEinheiten = Einheit::where('grundeinheit', 1)->where('conversion_needed', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $allowedEinheiten = Einheit::where('grundeinheit', 1)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $lagerorte = Lagerort::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        return view('produkt.edit', array (
            'produkt' => $produkt->toArray(),
            'zutaten' => $zutaten,
            'allEinheiten' => $allEinheiten,
            'grundEinheiten' => $grundEinheiten,
            'allowedEinheiten' => $allowedEinheiten,
            'lagerorte' => $lagerorte,
            'activeZutaten' => $activeZutaten
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
            'produkt_name' => 'required',
            'ertrag' => 'required',
            'mindestbestand' => 'required',
            'einheit' => 'required',
            'lagerort' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
        ]);

        // Zubereitung ändern
        $zubereitung = Zubereitung::where('id', $request->input('zubereitung_id'))->first();
        $zubereitung->description_short = $request->input('description_short');
        $zubereitung->description_long = $request->input('description_long');

        $zubereitung->save();

        // Produkt ändern
        $produkt = Produkt::where('id', $id)->first();
        $produkt->name = $request->input('produkt_name');
        $produkt->zubereitung = $request->input('zubereitung_id');
        $produkt->ertrag = floatval($request->input('ertrag'));

        // Image
        if ($request->image) {
            $image = $request->file('image');
            $input['imagename'] = time().'.'.$image->extension();

            $filePath = public_path('storage') . '/thumbnails';

            $img = Image::make($image->path());
            $img->resize(800, 800, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$input['imagename']);

            $filePath = public_path('storage') . '/images';
            $image->move($filePath, $input['imagename']);

            $produkt->picture = '/thumbnails/' . $input['imagename'];
        }

        $produkt->save();

        $syncData = array();
        foreach ($request->input('zutaten') as $key => $value){
            if ((!is_null($value)) && (!is_null($request->input('zutat_einheiten')[$key]))){
                $syncData[$value] = [
                    'menge' => floatval($request->input('mengen')[$key]),
                    'einheit' => $request->input('zutat_einheiten')[$key],
                    'verlust' => floatval($request->input('zutat_verluste')[$key])
                ];
            }
        }
        $this->createChangedZutatenLog($produkt, $syncData);
        $produkt->zutaten()->sync($syncData);

        //Änderungen an der zugehörigen Zutat
        $producedZutat = $produkt->producedZutat()->first();
        $producedZutat->name = $request->input('produkt_name');
        $producedZutat->mindestbestand = floatval($request->input('mindestbestand'));
        $producedZutat->einheit = $request->input('einheit');
        $producedZutat->lagerort = $request->input('lagerort');
        $producedZutat->round = $request->input('round');

        $einheit = Einheit::where('id', $request->input('einheit'))->first();
        if ($einheit->conversion_needed){
            $producedZutat->conversion_einheit = $request->input('conversionEinheit');
            $producedZutat->faktor = floatval(str_replace(',', '.', $request->input('faktor')));
        }else {
            $producedZutat->conversion_einheit = null;
            $producedZutat->faktor = null;
        }

        $producedZutat->save();

        return redirect($produkt->type . '/produkte')->with('success', 'Produkt bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produkt = Produkt::where('id', $id)->first();

        $produkt->delete();

        return redirect('/' . $produkt->type . '/produkte')->with('success', 'Produkt gelöscht');
    }

    /**
     * Create log for changed Zutaten
     *
     * Since there is no basic hock for the sync() function, which we can access in the models boot method,
     * in order to create a log entry on changed zutaten in produkt we either write a custom hock
     * or we manuelly create a log entry in the update method, which is what we do here
     */
    public function createChangedZutatenLog($produkt, $newSyncData)
    {
        // Create Array of old pivot entries to compare with
        $oldSyncData = array();
        $zutaten = $produkt->zutaten()->get();
        foreach ($zutaten as $zutat){
            $oldSyncData[$zutat->pivot->zutat] = [
                'menge' => $zutat->pivot->menge,
                'einheit' => intval($zutat->pivot->einheit),
                'verlust' => $zutat->pivot->verlust,
            ];
        }

        // Create Array with different entries for log
        $differences = array();

        foreach ($oldSyncData as $key => $oldSync){
            if (array_key_exists($key, $newSyncData)){
                if (array_diff($newSyncData[$key], $oldSync)){
                    $differences[$key] = "Zutat " . Zutat::where('id', $key)->first()->name . ": ";
                    foreach (array_diff($newSyncData[$key], $oldSync) as $field => $value){
                        $entry = ucfirst($field) . " " . $value . "; ";
                        if ($field == 'einheit')
                            $entry =  ucfirst($field) . " " . Einheit::where('id', $value)->first()->kuerzel . "; ";
                        elseif ($field == 'verlust')
                            $entry = " " . $value . '% Verlust;';
                        $differences[$key] .= $entry;
                    }
                }
            } else
                $differences[$key] = "Zutat " . Zutat::where('id', $key)->first()->name . " gelöscht";
        }

        foreach ($newSyncData as $key => $newSync){
            if(!array_key_exists($key, $oldSyncData)){
                $differences[$key] = "Neue Zutat " . Zutat::where('id', $key)->first()->name . ": ";
                foreach ($newSync as $field => $value){
                    $entry = ucfirst($field) . " " . $value;
                    if ($field == 'einheit')
                        $entry = Einheit::where('id', $value)->first()->kuerzel . ";";
                    elseif ($field == 'verlust')
                        $entry = " " . $value . '% Verlust;';

                    $differences[$key] .= $entry;
                }
            }
        }
        if ($differences){
            $logChanges = serialize($differences);
            $log = new Log;
            $log->verknuepfung_id = $produkt->id;
            $log->verknuepfung_type = get_class($produkt);
            $log->changes = $logChanges;
            $log->user = auth()->user()->id;
            $log->save();
        }
    }

    // Get Umrechnung for 2 given einheiten
    public function getUmrechnung($requestedEinheit, $mainEinheit){
        return Umrechnung::where('ist_einheit', $requestedEinheit)->where('soll_einheit', $mainEinheit)
                        ->orWhere('soll_einheit', $requestedEinheit)->where('ist_einheit', $mainEinheit)->first();
    }

    // Get conversion factor from 1 einheit and umrechnung
    public function getFaktor($einheit, $umrechnung){
        if($einheit == $umrechnung->soll_einheit)
            $faktor = $umrechnung->faktor;
        else
            $faktor = 1/($umrechnung->faktor);

        return $faktor;
    }
}
