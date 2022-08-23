<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Rezept;
use App\Models\Zubereitung;
use App\Models\Zutat;
use App\Models\Einheit;
use App\Models\Log;
use GuzzleHttp\Exception\GuzzleException;
use App\Traits\GastrofixArticles;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class RezeptController extends Controller
{
    use GastrofixArticles;

    /**
     * Display a listing of the resource.
     *
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function index($type = 0)
    {
        if ($type == 0)
            $rezepte = Rezept::with('zubereitung')->get();
        else if ($type == 1)
            $rezepte = Rezept::with('zubereitung')->where('type', 1)->get();
        else if ($type == 2)
            $rezepte = Rezept::with('zubereitung')->where('type', 2)->get();
        else if ($type == 3)
            $rezepte = Rezept::with('zubereitung')->where('type', 3)->get();

        return view('rezept.index', array(
            'rezepte' => $rezepte->toArray(),
            'type' => $type
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $type
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $zutaten = Zutat::where('lagerort', '!=', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $einheiten = Einheit::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        $articles = $this->get_skus();

        return view('rezept.create', array(
            'zutaten' => $zutaten,
            'einheiten' => $einheiten,
            'type' => $type,
            'articles' => $articles
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $type
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $this->validate($request, [
            'rezept_name' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
            'sku' => [
                'required_with:restaurant,eis',
                Rule::unique('articles', 'sku'),
            ],
        ]);

        // Zubereitung abspeichern
        $zubereitung = new Zubereitung;
        $zubereitung->description_short = $request->input('description_short');
        $zubereitung->description_long = $request->input('description_long');
        $zubereitung->save();

        // Rezept abspeichern
        $rezept = new Rezept;
        $rezept->name = $request->input('rezept_name');
        $rezept->type = $type;
        $rezept->zubereitung = $zubereitung['id'];

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

            $rezept->picture = '/thumbnails/' . $input['imagename'];
        }

        $rezept->save();

        // sync each zutat
        $syncData = array();
        foreach ($request->input('zutaten') as $key => $value) {

            if ((!is_null($value)) && (!is_null($request->input('zutat_einheiten')[$key]))) {
                $syncData[$value] = [
                    'menge' => floatval($request->input('zutat_mengen')[$key]),
                    'einheit' => $request->input('zutat_einheiten')[$key],
                    'verlust' => floatval($request->input('zutat_verluste')[$key])
                ];
            }
        }
        $rezept->zutaten()->sync($syncData);

        // Create array with needed business_ids
        $gastro = config('services.lightspeed');
        $business_ids = array();
        if ($request->input('restaurant'))
            $business_ids[] = $gastro[0]['business_id'];
        if ($request->input('eis'))
            $business_ids[] = $gastro[1]['business_id'];

        foreach ($business_ids as $business) {
            $article = new Article;
            $article->rezept = $rezept->id;
            $article->sku = $request->input('sku');
            $article->business_id = $business;
            $article->save();
        }


        // Update description in Gastrofix article
        foreach ($rezept->articles()->get() as $article) {
            try {
                // Do trait function
                $response = $this->setSingleArticleInfo($article);
            } catch (GuzzleException $e) {
                Log::emergency("Could not connect to articles API: " . $e->getMessage());
                return -1;
            }
        }

        return redirect($type . '/rezepte')->with('success', 'Rezept erstellt');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rezept = Rezept::where('id', $id)->withTrashed()->with('zubereitung', 'zutaten')->first();
        $zutaten = Rezept::where('id', $id)->withTrashed()->first()->zutaten()->with('allergene', 'einheit')->get();
        $einheiten = Einheit::pluck('name', 'id')->toArray();

        // Search for Allergene without dublicates
        $allergene = [];
        foreach ($zutaten as $zutat) {
            foreach ($zutat['allergene'] as $allergen)
                if (!in_array($allergen['name'], $allergene))
                    $allergene[] = $allergen['name'];
        }

        return view('rezept.show', array(
            'rezept' => $rezept,
            'zutaten' => $zutaten,
            'einheiten' => $einheiten,
            'allergene' => $allergene
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rezept = Rezept::where('id', $id)->with('zubereitung')->first();

        // Get Zutaten
        $activeZutaten = [];
        $activeZutatenObjects = Rezept::where('id', $id)->first()->zutaten()->get()->toArray();
        if ($activeZutatenObjects) {
            foreach ($activeZutatenObjects as $item) {
                $activeZutaten[] = array(
                    'zutat' => $item['id'],
                    'menge' => $item['pivot']['menge'],
                    'einheit' => $item['pivot']['einheit'],
                    'verlust' => $item['pivot']['verlust']
                );
            }
        }
        $zutaten = Zutat::where('lagerort', '!=', 0)->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
        $einheiten = Einheit::orderBy('name', 'ASC')->pluck('name', 'id')->toArray();

        $gastro = config('services.lightspeed');
        $restaurantArticle = $rezept->articles()->where('business_id', $gastro[0]['business_id'])->exists();

        $eiscafeArticle = $rezept->articles()->where('business_id', $gastro[1]['business_id'])->exists();


        $articles = $this->get_skus();

        return view('rezept.edit', array(
            'rezept' => $rezept,
            'zutaten' => $zutaten,
            'einheiten' => $einheiten,
            'activeZutaten' => $activeZutaten,
            'restaurantArticle' => $restaurantArticle,
            'eiscafeArticle' => $eiscafeArticle,
            'articles' => $articles
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'rezept_name' => 'required',
            'description_short' => 'required',
            'description_long' => 'required',
            'image' => 'image|mimes:jpg,jpeg,png,svg,gif',
            'sku' => [
                'required_with:restaurant,eis',
                Rule::unique('articles', 'sku')
                    ->ignore($id, 'rezept'),
            ],
        ]);

        // Zubereitung ändern
        $zubereitung = Zubereitung::where('id', $request->input('zubereitung_id'))->first();
        $zubereitung->description_short = $request->input('description_short');
        $zubereitung->description_long = $request->input('description_long');

        $zubereitung->save();

        // Rezept ändern
        $rezept = Rezept::where('id', $id)->first();
        $rezept->name = $request->input('rezept_name');
        $rezept->zubereitung = $request->input('zubereitung_id');

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

            $rezept->picture = '/thumbnails/' . $input['imagename'];
        }

        $rezept->save();

        // Sync Zutaten
        $syncData = array();
        foreach ($request->input('zutaten') as $key => $value) {

            if ((!is_null($value) && (!is_null($request->input('zutat_einheiten')[$key])))) {
                $syncData[$value] = [
                    'menge' => floatval($request->input('zutat_mengen')[$key]),
                    'einheit' => $request->input('zutat_einheiten')[$key],
                    'verlust' => floatval($request->input('zutat_verluste')[$key])
                ];
            }
        }
        $this->createChangedZutatenLog($rezept, $syncData);
        $rezept->zutaten()->sync($syncData);

        // Create array with needed business_ids
        $gastro = config('services.lightspeed');
        $business_ids = array();
        $business_ids[$gastro[0]['business_id']] = $request->input('restaurant');
        $business_ids[$gastro[1]['business_id']] = $request->input('eis');

        foreach (config('services.lightspeed') as $gastro) {
            $gastro_id = $gastro['business_id'];
            $article = $rezept->articles()->where('business_id', $gastro_id)->first();
            if ($article) {
                if ($business_ids[$gastro_id]) {
                    // checkbox set, update
                    // TODO maybe check if any change actually happened. in model?
                    $article->sku = $request->input('sku');
                    $article->save();
                } else {
                    // checkbox not set, remove
                    $article->delete();
                }
            } else {
                if (isset($business_ids[$gastro_id])) {
                    // checkbox set, create
                    $article = new Article;
                    $article->rezept = $rezept->id;
                    $article->sku = $request->input('sku');
                    $article->business_id = $gastro_id;
                    $article->save();
                } else {
                    // checkbox not set, do nothing
                }
            }
        }


        // Update description in Gastrofix article
        foreach ($rezept->articles()->get() as $article) {
            try {
                // Do trait function
                $response = $this->setSingleArticleInfo($article);
            } catch (GuzzleException $e) {
                Log::emergency("Could not connect to articles API: " . $e->getMessage());
                return -1;
            }
        }

        return redirect($rezept->type . '/rezepte')->with('success', 'Rezept bearbeitet');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rezept = Rezept::where('id', $id)->first();

        $rezept->delete();

        return redirect('/' . $rezept->type . '/rezepte')->with('success', 'Rezept gelöscht');
    }

    /**
     * Testing function for triggering order and updating lagerbestand of all zutaten
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     *
     */
    public function order($id)
    {

        $rezept = Rezept::where('id', $id)->first();

        // Loop through all Zutaten in Rezept and sync
        foreach ($rezept->zutaten()->get() as $zutat) {
            $requestedZutatEinheit = floatval($zutat->pivot->einheit);
            $requestedZutatMenge = floatval($zutat->pivot->menge);
            $requestedZutatVerlust = floatval($zutat->pivot->verlust);
            $zutat->updateIngredients($requestedZutatEinheit, $requestedZutatMenge, $requestedZutatVerlust, 1);
        }

        return redirect('/' . $rezept->type . '/rezepte')->with('success', 'Bestellung ausgelöst');
    }

    /**
     * Create log for changed Zutaten
     *
     * Since there is no basic hock for the sync() function, which we can access in the models boot method,
     * in order to create a log entry on changed zutaten in rezept we either write a custom hock
     * or we manually create a log entry in the update method, which is what we do here
     */
    public function createChangedZutatenLog($rezept, $newSyncData)
    {
        // Create Array of old pivot entries to compare with
        $oldSyncData = array();
        $zutaten = $rezept->zutaten()->get();
        foreach ($zutaten as $zutat) {
            $oldSyncData[$zutat->pivot->zutat] = [
                'menge' => $zutat->pivot->menge,
                'einheit' => intval($zutat->pivot->einheit),
                'verlust' => $zutat->pivot->verlust,
            ];
        }

        // Create Array with different entries for log
        $differences = array();

        foreach ($oldSyncData as $key => $oldSync) {
            if (array_key_exists($key, $newSyncData)) {
                if (array_diff($newSyncData[$key], $oldSync)) {
                    $differences[$key] = "Zutat " . Zutat::where('id', $key)->first()->name . ": ";
                    foreach (array_diff($newSyncData[$key], $oldSync) as $field => $value) {
                        $entry = ucfirst($field) . " " . $value . "; ";
                        if ($field == 'einheit')
                            $entry = ucfirst($field) . " " . Einheit::where('id', $value)->first()->kuerzel . "; ";
                        elseif ($field == 'verlust')
                            $entry = " " . $value . '% Verlust;';
                        $differences[$key] .= $entry;
                    }
                }
            } else
                $differences[$key] = "Zutat " . Zutat::where('id', $key)->first()->name . " gelöscht";
        }

        foreach ($newSyncData as $key => $newSync) {
            if (!array_key_exists($key, $oldSyncData)) {
                $differences[$key] = "Neue Zutat " . Zutat::where('id', $key)->first()->name . ": ";
                foreach ($newSync as $field => $value) {
                    $entry = ucfirst($field) . " " . $value;
                    if ($field == 'einheit')
                        $entry = Einheit::where('id', $value)->first()->kuerzel . ";";
                    elseif ($field == 'verlust')
                        $entry = " " . $value . '% Verlust;';

                    $differences[$key] .= $entry;
                }
            }
        }
        if ($differences) {
            $logChanges = serialize($differences);
            $log = new Log;
            $log->verknuepfung_id = $rezept->id;
            $log->verknuepfung_type = get_class($rezept);
            $log->changes = $logChanges;
            $log->user = auth()->user()->id;
            $log->save();
        }
    }
}
