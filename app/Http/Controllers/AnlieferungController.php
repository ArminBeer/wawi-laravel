<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bestellung;
use App\Models\Bestellung_Activity;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class AnlieferungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Confirm if delivery was correct.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirm($id)
    {
        $bestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant')->first();

        $zutaten = $bestellung->zutaten()->with('einheit')->get();

        // Get Zutaten
        $activeZutatenMengen = [];
        $activeZutatenObjects = $bestellung->zutaten()->get();
        if($activeZutatenObjects){
            foreach($activeZutatenObjects as $item){
                $activeZutatenMengen[$item->id] =  $item->pivot->bestellmenge;
            }
        }

        return view('anlieferung.confirm', array (
            'bestellung' => $bestellung,
            'zutaten' => $zutaten,
            'activeZutatenMengen' => $activeZutatenMengen
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
        $bestellung = Bestellung::where('id', $id)->with('zutaten')->first();
        // Set default message if everything worked out
        $message = "Warenanlieferung abgeschlossen";


        // First save new delivered items to liefermengen
            // Get ordered Zutaten
            $orderedZutatenMengen = [];
            $orderedZutatenObjects = $bestellung->zutaten()->get()->toArray();
            if($orderedZutatenObjects){
                foreach($orderedZutatenObjects as $item){
                    $orderedZutatenMengen[$item['id']] =  [
                        'bestellmenge' => $item['pivot']['bestellmenge'],
                        'liefermenge' => $item['pivot']['bestellmenge'],
                    ];
                }
            }
            $doubleInputLiefermengen = array_map('floatval', $request->input('liefermengen'));

            // sync each zutat
            $syncData = array();
            // Get old pivot fields if order already accepted once
            if ($bestellung->latestActivity()->status == 'Teillieferung'){
                $zutaten = $bestellung->zutaten()->get();
                foreach ($zutaten as $zutat){
                    $syncData[$zutat->id] = [
                        'bestellmenge' => $zutat->pivot->bestellmenge,
                        'liefermenge' => $zutat->pivot->liefermenge
                    ];
                }
            }
            // Update new pivot fields
            foreach ($doubleInputLiefermengen as $key => $value){
                $syncData[$key] = [
                    'bestellmenge' => $orderedZutatenMengen[$key]['bestellmenge'],
                    'liefermenge' => isset($request->input('fit')[$key]) ? $orderedZutatenMengen[$key]['bestellmenge'] : $value,
                ];
            }
            $bestellung->zutaten()->sync($syncData);

            // Add note
            $bestellung->lagernotiz = $request->input('lagernotiz');
            $bestellung->save();

        // Get Array of wrong delivered zutaten
        $diffArray = [];
        foreach($syncData as $key => $value){
            if (array_diff_assoc($syncData[$key], $orderedZutatenMengen[$key]))
                $diffArray[$key] = (array_diff_assoc($syncData[$key], $orderedZutatenMengen[$key]));
        }

        // Take care of corresponding saved data and redirect
            $changes = 'Alle Waren korrekt geliefert';
            if($diffArray){
                $status = 'Problem';
                $changes = 'Angelieferte Waren:';
                foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat){
                    $changes .= "\n" . $zutat['name'] . ' ' . $zutat['pivot']['liefermenge'] . ' ' . $zutat['einheit']['name'];
                }
            }
            else{
                $status = 'abgeschlossen';
            }

            // Bestellungs Aktivität erstellen
            $activity = new Bestellung_Activity;
            $activity->bestellung = $bestellung->id;
            $activity->status = $status;
            $activity->changes = $changes;
            $activity->user = auth()->user()->id;
            $activity->save();
            $bestellung->touch();

        // Update Lagerbestand
        foreach ($bestellung->zutaten()->get() as $zutat){
            $zutat->lagerbestand += $syncData[$zutat->id]['liefermenge'];
            $zutat->save();
        }
        // Show Modal to create nachlieferung if delivery wasn't correct
        if($status == 'Problem')
            return redirect('/bestellungen')->with('error', 'Bestellstatus als Problem markiert');

        return redirect('/bestellungen')->with('success', $message);
    }

}
