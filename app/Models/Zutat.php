<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ConversionService;

class Zutat extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'zutaten';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name',
        'lagerbestand',
        'mindestbestand',
        'lieferant',
        'einheit',
        'umrechnung',
        'round',
        'lagerort',
    ];

    // Boot Method
    protected static function boot()
    {
        parent::boot();

        static::created(function($zutat){
            $log = new LoggingService;
            $log->saveLog($zutat, 'created');
        });

        static::updated(function($zutat){
            $log = new LoggingService;
            $log->saveLog($zutat, 'updated');
        });

        static::deleting(function($zutat)
        {
            $zutat->deleted_by = auth()->user()->id;
            $zutat->save();

            $log = new LoggingService;
            $log->saveLog($zutat, 'delete');

            // $zutat->allergene()->detach();

            if($zutat->isProdukt()){
                $zutat->selfmadeProdukt()->first()->delete();
            }

        });
    }

    // Beziehungen
    public function allergene() {
        return $this->belongsToMany('App\Models\Allergen', 'zutaten_zu_allergene', 'zutat', 'allergen');
    }

    public function lieferant() {
        return $this->belongsTo('App\Models\Lieferant', 'lieferant');
    }

    public function einheit() {
        return $this->belongsTo('App\Models\Einheit', 'einheit');
    }

    public function conversion_einheit() {
        return $this->belongsTo('App\Models\Einheit', 'conversion_einheit');
    }

    public function lagerort() {
        return $this->belongsTo('App\Models\Lagerort', 'lagerort');
    }

    public function rezepte() {
        return $this->morphedByMany('App\Models\Rezept', 'verknuepfung', 'zutaten_zu_rezepte_produkte', 'zutat', 'verknuepfung_id')->withPivot('menge', 'einheit', 'verlust');
    }
    public function produkte() {
        return $this->morphedByMany('App\Models\Produkt', 'verknuepfung', 'zutaten_zu_rezepte_produkte', 'zutat', 'verknuepfung_id')->withPivot('menge', 'einheit', 'verlust');
    }

    public function bestellungen() {
        return $this->belongsToMany('App\Models\Bestellung', 'bestellungen_zu_zutaten', 'zutat', 'bestellung')->withPivot('menge');
    }

    public function inventurActivities() {
        return $this->hasMany('App\Models\Inventur_Activity', 'zutat');
    }


    public function selfmadeProdukt(){
        return $this->hasOne('App\Models\Produkt', 'zutat');
    }

    public function kategorien(){
        return $this->morphToMany('App\Models\Kategorie', 'verknuepfung', 'kategorien_zuordnungen', null, 'kategorie');
    }

    public function tags(){
        return $this->morphToMany('App\Models\Tag', 'verknuepfung', 'tags_zuordnungen', null, 'tag');
    }

    public function isProdukt(){
        if ($this->selfmadeProdukt()->first())
            return true;
        else
            return false;
    }


    public function getAvailableEinheiten() {

        $multipleEinheiten = collect(new Einheit);

        // Einheiten von der individuellen Umrechnungseinheit ziehen
        if ($this->conversion_einheit){
            $individualEinheit = $this->conversion_einheit()->first();

            // Von der Zutat Einheit alle Grundeinheiten die umrechenbar sind raussuchen
            $attachedGrundeinheiten = $individualEinheit->getAttachedGrundeinheiten();

            $multipleEinheiten[] = $this->einheit()->first();

            foreach ($attachedGrundeinheiten as $attachedGrundeinheit){
                $umrechnungen = $attachedGrundeinheit->umrechnungen()->get();
                foreach($umrechnungen as $umrechnung){
                    $multipleEinheiten[] = $umrechnung->ist_einheit()->first();
                    $multipleEinheiten[] = $umrechnung->soll_einheit()->first();
                }
            }
        } else {
            // Selber Spass wie oben nochmal für die allgemeine Umrechnung
            $attachedGrundeinheiten = $this->einheit()->first()->getAttachedGrundeinheiten();

            // Für jede dieser Grundeinheiten umrechenbare Einheiten raussuchen
            foreach ($attachedGrundeinheiten as $attachedGrundeinheit){
                $umrechnungen = $attachedGrundeinheit->umrechnungen()->get();
                    foreach($umrechnungen as $umrechnung){
                        $multipleEinheiten[] = $umrechnung->ist_einheit()->first();
                        $multipleEinheiten[] = $umrechnung->soll_einheit()->first();
                    }
            }
        }

        $einheiten = $multipleEinheiten->unique()->pluck('name', 'id')->toArray();

        return $einheiten;
    }

    /**
     * Algorithmus zum angleich des Lagerbestands
     * Aktualisiert den Lagerbestand unter Berücksichtigung folgender Fälle:
     * Fall 1: Verwendete Einheit im Rezept entspricht Zutatgrundeinheit
     * Fall 2: Verwendete Einheit im Rezept entspricht Umrechnung der Zutatgrundeinheit
     * Fall 3: Verwendete Einheit im Rezept entspricht Umrechnung der Zutatgrundeinheit mit einem Zwischenschritt
     * Fall 4: Verwendete Einheit im Rezept entspricht individueller Einheit
     * Fall 5: Verwendete Einheit im Rezept entspricht Umrechnung der individuellen Einheit
     * Fall 6: Verwendete Einheit im Rezept entspricht Umrechnung der individuellen Einheit mit einem Zwischenschritt
     */
    public function updateIngredients($requestedEinheit, $requestedMenge, $requestedVerlust, $portion = 1){

        // Initialisierung notwendiger Variablen
        $mainZutatEinheit = $this->einheit;
        $conversions = new ConversionService;
        $faktor = 1;

        // Beginn der Fallunterscheidung
        if ($requestedEinheit == $mainZutatEinheit)
            // Fall 1
            $faktor = 1;
        elseif (!$this->conversion_einheit){
            // Fall 2 & 3
            $umrechnung = $conversions->getUmrechnung($requestedEinheit, $mainZutatEinheit);
            if($umrechnung)
                // Fall 2
                $faktor = $conversions->getFaktor($requestedEinheit, $umrechnung);
            else {
                // Fall 3
                $requestedEinheitModel = Einheit::where('id', $requestedEinheit)->first();
                $middleEinheit = $conversions->getTwoWayUmrechnung($this->einheit()->first(), $requestedEinheitModel);
                $middleEinheit = array_shift($middleEinheit);
                $faktor1 = $conversions->getFaktor($middleEinheit, $conversions->getUmrechnung($middleEinheit, $this->einheit));
                $faktor2 = $conversions->getFaktor($requestedEinheit, $conversions->getUmrechnung($requestedEinheit, $middleEinheit));
                $faktor = $faktor1*$faktor2;
            }
        } else {
            // Fall 4 & 5 & 6
            if ($requestedEinheit == $this->conversion_einheit)
                // Fall 4
                $faktor = 1 / $this->faktor;
            else {
                // Fall 5 & 6
                $umrechnung = $conversions->getUmrechnung($requestedEinheit, $this->conversion_einheit);
                if ($umrechnung)
                    // Fall 5
                    $faktor = (1 / $this->faktor) * $conversions->getFaktor($requestedEinheit, $umrechnung);
                else {
                    // Fall 6
                    $requestedEinheitModel = Einheit::where('id', $requestedEinheit)->first();
                    $middleEinheit = $conversions->getTwoWayUmrechnung($this->conversion_einheit()->first(), $requestedEinheitModel);
                    $middleEinheit = array_shift($middleEinheit);
                    $middleFaktor1 = $conversions->getFaktor($middleEinheit, $conversions->getUmrechnung($middleEinheit, $this->conversion_einheit));
                    $middleFaktor2 = $conversions->getFaktor($requestedEinheit, $conversions->getUmrechnung($requestedEinheit, $middleEinheit));
                    $middleFaktor = $middleFaktor1*$middleFaktor2;
                    $faktor = (1/$this->faktor)*$middleFaktor;
                }
            }
        }

        $finalMenge = $portion * $requestedMenge * $faktor * ( 1 + $requestedVerlust/100);

        // Überprüfe ob gerundet werden muss
        if ($this->round)
            $finalMenge = ceil($finalMenge);

        // Save
        $this->lagerbestand -= $finalMenge;
        $this->save();
    }

}
