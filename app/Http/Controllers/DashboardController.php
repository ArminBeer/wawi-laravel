<?php

namespace App\Http\Controllers;

use App\Models\Zutat;
use Illuminate\Http\Request;
use App\Models\Bestellung;
use App\Models\Einheit;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Models\Global_Inventurflag;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zutaten = Zutat::all();
        $rebuyZutaten = [];

        foreach ($zutaten as $zutat){
            if ($zutat->einheit != 0){
                $mindestbestand = $zutat->mindestbestand;
                $lagerbestand = $zutat->lagerbestand;
                if ($lagerbestand < $mindestbestand)
                    $rebuyZutaten[] = $zutat;
            }
        }

        $problemBestellungen = Bestellung::whereHas('bestellungActivities', function(EloquentBuilder $q){
            $q->where('status', 'Problem')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            });
        })->latest('updated_at')->with('lieferant', 'zutaten', 'bestellungActivities')->get();


        $openBestellungen = Bestellung::whereHas('bestellungActivities', function(EloquentBuilder $q){
            $q->where('status', 'bestellt')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            })
            ->orWhere('status', 'Teillieferung')->whereIn('id', function(QueryBuilder $q){
                $q->selectRaw('max(id)')->from('bestellung_activities')->whereColumn('bestellung', 'bestellungen.id');
            });
        })->latest('updated_at')->with('lieferant', 'zutaten', 'bestellungActivities')->get();

        $globalInventurFlag = Global_Inventurflag::where('id', 1)->first()->active;

        $openInventuren = auth()->user()->inventuren()->where('completed', 0)->get();

        return view('dashboard', array (
            'rebuyZutaten' => $rebuyZutaten,
            'problemBestellungen' => $problemBestellungen,
            'openBestellungen' => $openBestellungen,
            'globalInventurFlag' => $globalInventurFlag,
            'openInventuren' => $openInventuren,
        ));
    }
}
