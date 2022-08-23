<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lieferant;
use App\Models\Bestellung;
use App\Models\Bestellung_Activity;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BestellungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bestellungen = Bestellung::latest('updated_at')->with('lieferant', 'zutaten', 'bestellungActivities')->get();

        $openBestellungen = Bestellung::whereHas('bestellungActivities', function(EloquentBuilder $q){
            $q->where('status', 'bestellt')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            })
            ->orWhere('status', 'Teillieferung')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            });
        })->latest('updated_at')->with('lieferant', 'zutaten', 'bestellungActivities')->get();

        $problemBestellungen = Bestellung::whereHas('bestellungActivities', function(EloquentBuilder $q){
            $q->where('status', 'Problem')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            });
        })->latest('updated_at')->with('lieferant', 'zutaten', 'bestellungActivities')->get();


        return view('bestellung.index', array (
            'bestellungen' => $bestellungen,
            'openBestellungen' => $openBestellungen,
            'problemBestellungen' => $problemBestellungen,
        ));
    }

    /**
     * Display a listing of lieferanten to create choose from which to create new order.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        $lieferanten = Lieferant::all();

        return view('bestellung.new', array (
            'lieferanten' => $lieferanten->toArray()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
        $lieferant = Lieferant::where('id', $id)->first();

        $zutaten = $lieferant->zutaten()->with('einheit')->orderByRaw('(lagerbestand - mindestbestand) ASC')->get()->toArray();

        return view('bestellung.create', array(
            'lieferant' => $lieferant,
            'zutaten' => $zutaten
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
        $bestellung = new Bestellung;
        $bestellung->lieferant = $request->input('lieferant');
        $bestellung->save();

        // sync each zutat
        $syncData = array();
        $doubleInputBestellmengen = array_map('floatval', $request->input('bestellmengen'));

        foreach ($doubleInputBestellmengen as $key => $value){
            if ($value != 0)
            $syncData[$key] = ['bestellmenge' => $value];
        }
        $bestellung->zutaten()->sync($syncData);

        $changes = 'Bestellinhalt:';
        foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat){
            $changes .= "\n" . $zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name'];
        }

        // Bestellungs Aktivität erstellen
        $this->setActivity($bestellung->id, 'erstellt', $changes);

        return redirect('/bestellungen/' . $bestellung['id'] . '/confirm')->with('success', 'Bestellung angelegt');
    }

    /**
     * Return confirm blade
     *
     * @param  int  $id
     */
    public function confirm($id){

        $bestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant', 'bestellungActivities')->first();

        $latestActivity = $bestellung->latestActivity();

        $zutaten = $bestellung->zutaten()->with('einheit')->get()->toArray();

        return view('bestellung.confirm', array (
            'bestellung' => $bestellung->toArray(),
            'zutaten' => $zutaten,
            'latestActivity' => $latestActivity
        ));
    }

    /**
     * Add note and save
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendsave(Request $request, $id){

        $message = "Bestellung erfolgreich erstellt";

        $bestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant')->first();

        // Add bestellnotiz when condition true
        if ($request->input('bestellnotiz') && $request->input('bestellnotiz') != $bestellung->bestellnotiz){
            $bestellung->bestellnotiz = $request->input('bestellnotiz');
            $bestellung->save();

            // Bestellungs Aktivität erstellen
            $this->setActivity($bestellung->id, 'bearbeitet', 'Bestellnotiz hinzugefügt/geändert');

            $message = "Bestellnotiz erfoglreich hinzugefügt";
        }


        if ($request->input('action') == "send") {
            $bestellung->sendOrder();
            $bestellung->touch();

            $changes = 'Bestellte Waren:';
            foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat){
                $changes .= "\n" . $zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name'];
            }

            // Bestellungs Aktivität erstellen
            $this->setActivity($bestellung->id, 'bestellt', $changes);

            $message = "Bestellung erfolgreich abgeschickt";
        } elseif ($request->input('action') == "edit")
            return redirect()->route('bestellungen.triggered', [$bestellung->id]);

        return redirect('/bestellungen')->with('success', $message);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant')->first();

        $zutaten = Lieferant::where('id', $bestellung->lieferant)->first()->zutaten()->with('einheit')->orderByRaw('(lagerbestand - mindestbestand) ASC')->get()->toArray();

        $lieferant =  $bestellung->lieferant()->first()->name;

        // Get Zutaten
        $activeZutatenMengen = [];
        $activeZutatenObjects = $bestellung->zutaten()->get()->toArray();
        if($activeZutatenObjects){
            foreach($activeZutatenObjects as $item)
                $activeZutatenMengen[$item['id']] =  $item['pivot']['bestellmenge'];
        }

        return view('bestellung.edit', array (
            'bestellung' => $bestellung->toArray(),
            'zutaten' => $zutaten,
            'lieferant' => $lieferant,
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
        $message = "Keine Änderungen vorgenommen";
        $bestellung = Bestellung::where('id', $id)->with('zutaten')->first();
        $doubleInputBestellmengen = array_map('floatval', $request->input('bestellmengen'));

        // Get old Zutaten
        $oldZutatenMengen = [];
        $oldZutatenObjects = $bestellung->zutaten()->get()->toArray();
        if($oldZutatenObjects){
            foreach($oldZutatenObjects as $item)
                $oldZutatenMengen[$item['id']] =  $item['pivot']['bestellmenge'];
        }

        // sync each zutat when bestellmengen not zero
        if(array_diff_assoc($doubleInputBestellmengen, $oldZutatenMengen)){
            $syncData = array();
            foreach ($doubleInputBestellmengen as $key => $value){
                if ($value != 0)
                    $syncData[$key] = ['bestellmenge' => $value];
            }
            $bestellung->zutaten()->sync($syncData);
            $bestellung->touch();

            // Create changes field value
            $changes = 'Bestellinhalt geändert:';
            foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat){
                $changes .= "\n" . $zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name'];
            }

            // Bestellungs Aktivität erstellen
            $this->setActivity($bestellung->id, 'bearbeitet', $changes);

            $message = "Bestellung wurde geändert";
        }

        return redirect('/bestellungen/' . $bestellung['id'] . '/confirm')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bestellung::find($id)->delete();

        return redirect('/bestellungen')->with('success', 'Bestellung gelöscht');
    }

    /**
     * History listing of this order
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history($id)
    {
        $bestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant', 'bestellungActivities')->first();

        $activities = $bestellung->bestellungActivities()->orderBy('created_at', 'ASC')->with('user')->get();
        $latestActivity = $bestellung->latestActivity();

        return view('bestellung.history', array (
            'bestellung' => $bestellung,
            'activities' => $activities,
            'latestActivity' => $latestActivity
        ));
    }

     /**
     * Reorder a wrong delivery
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reorder($id)
    {
        $failedBestellung = Bestellung::where('id', $id)->with('zutaten', 'lieferant')->first();

        $reorder = new Bestellung;
        $reorder->lieferant = $failedBestellung->lieferant;
        $reorder->save();

        $failedBestellung->child_id = $reorder->id;
        $failedBestellung->save();

        // Bestellungs Aktivität für failedBestellung erstellen
        $this->setActivity($failedBestellung->id, 'Nachbestellung angelegt');

        // sync each zutat
        $syncData = array();
        foreach ($failedBestellung->zutaten()->get()->toArray() as $zutat){
            if ($zutat['pivot']['bestellmenge'] != $zutat['pivot']['liefermenge']){
                $syncData[$zutat['id']] = ['bestellmenge' => ($zutat['pivot']['bestellmenge']-$zutat['pivot']['liefermenge'])];
            }
        }
        $reorder->zutaten()->sync($syncData);

        $changes = 'Nachbestellung mit Bestellinhalt:';
        foreach ($reorder->zutaten()->with('einheit')->get()->toArray() as $zutat){
            $changes .= "\n" . $zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name'];
        }
        // Bestellungs Aktivität für reorder erstellen
        $this->setActivity($reorder->id, 'erstellt', $changes);

        $zutaten = Lieferant::where('id', $reorder->lieferant)->first()->zutaten()->orderByRaw('(lagerbestand - mindestbestand) ASC')->get()->toArray();

        // Get Zutaten
        $activeZutatenMengen = [];
        $activeZutatenObjects = $reorder->zutaten()->get()->toArray();
        if($activeZutatenObjects){
            foreach($activeZutatenObjects as $item){
                $activeZutatenMengen[$item['id']] =  $item['pivot']['bestellmenge'];
            }
        }

        // Touch to make sure reorder is later than failedorder
        $reorder->touch();

        $lieferant =  $reorder->lieferant()->first()->name;

        return redirect('bestellungen/' . $reorder->id . '/edit')
            ->with('success', 'Die Fehlenden Mengen sind hier schon voreingetragen')
            ->with(array(
                'bestellung' => $reorder->toArray(),
                'zutaten' => $zutaten,
                'lieferant' => $lieferant,
                'activeZutatenMengen' => $activeZutatenMengen,
            ));
    }

    public function setActivity($id, $status, $changes = ''){
        $activity = new Bestellung_Activity;
        $activity->bestellung = $id;
        $activity->status = $status;
        $activity->changes = $changes;
        $activity->user = auth()->user()->id;
        $activity->save();
    }

    /**
     * Rework a partial delivery
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function partialDelivery($id)
    {
        $bestellung = Bestellung::where('id', $id)->first();
        $bestellung->touch();

        $this->setActivity($bestellung->id, 'Teillieferung');

        return redirect()->route('bestellungen.history', [$bestellung->id])->with('success', 'Bestellung wurde auf Status "Teillieferung" gestellt');
    }

    /**
     * Show history with accept modal
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showAccept(Request $request, $id)
    {
        $bestellung = Bestellung::where('id', $id)->first();

        return redirect()->route('bestellungen.history', ['bestellung' => $id])->with('acceptOrder', $id);
    }


    /**
     * Accept a problematic delivery
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, $id)
    {
        $this->validate($request, [
            'lastnote' => 'required',
        ]);

        $bestellung = Bestellung::where('id', $id)->first();
        $bestellung->endnotiz = $request->input('lastnote');
        $bestellung->save();

        $this->setActivity($bestellung->id, 'Akzeptiert', 'Akzeptierungsgrund siehe Notiz');

        return redirect()->route('bestellungen.history', [$bestellung->id])->with('success', 'Bestellung wurde auf Status "Akzeptiert" gestellt');
    }
}
