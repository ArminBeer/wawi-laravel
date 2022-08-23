<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\LoggingService;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ConversionService;

class Produkt extends Model
{
    use HasFactory, SoftDeletes;

    // Table Name
    protected $table = 'produkte';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'zubereitung',
        'verlust',
        'picture',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($produkt){
            $log = new LoggingService;
            $log->saveLog($produkt, 'created');
        });

        static::updated(function($produkt){
            $log = new LoggingService;
            $log->saveLog($produkt, 'updated');
        });

        static::deleting(function($produkt)
        {
            if ($produkt->zubereitung()->first())
                $produkt->zubereitung()->delete();

            // $produkt->zutaten()->detach();

            if ($produkt->producedZutat()->first())
                $produkt->producedZutat()->delete();

            $produkt->deleted_by = auth()->user()->id;
            $produkt->save();

            $log = new LoggingService;
            $log->saveLog($produkt, 'delete');
        });
    }

    // Beziehungen
    public function zubereitung(){
        return $this->belongsTo('App\Models\Zubereitung', 'zubereitung');
    }

    public function zutaten(){
        return $this->morphToMany('App\Models\Zutat', 'verknuepfung', 'zutaten_zu_rezepte_produkte', null, 'zutat')->withPivot('menge', 'einheit', 'verlust');
    }

    public function rezepte() {
        return $this->producedZutat()->first()->rezepte()->get();
    }

    public function producedZutat(){
        return $this->belongsTo('App\Models\Zutat', 'zutat');
    }



    /**
     * Allgorithmus bei der Herstellung eines Produkt.
     * Aktualisiert den Lagerbestand der am Ende hergestellten Zutat unter Berücksichtigung mehrerer Fälle:
     * Fall 1: Herstellung durch durchführung des Produktrezepts oder bei direkter Mengenangabe mit der eingepflegten Grundeinheit der Zutat
     * Fall 2: Herstellung mit Mengenangabe, Umrechnung von der Grundeinheit notwendig
     * Fall 3: Herstellung mit Mengenangabe, Umrechnung von der Grundeinheit mit einem Zwischenschritt notwendig
     * Fall 4: Herstellung mit Mengenangabe, Umrechnung der individuellen Umrechnungseinheit notwendig
     * Fall 5: Herstellung mit Mengenangabe, Umrechnung von der individuellen Umrechnungseinheit notwendig
     * Fall 6: Herstellung mit Mengenangabe, Umrechnung von der individuellen Umrechnungseinheit mit einem Zwischenschritt notwendig
     */
    public function craft($multiplierInput = null, $quantityInput = null, $einheitInput = null){

        $producedZutat = $this->producedZutat()->first();
        $conversions = new ConversionService;

        /**
         * Vorbereitung damit bei der Herstellung eines Produkts zwei Fälle zum Fall 1 zusammengefasst werden können:
         *  - Angabe eines Multiplikators
         *  - Angabe einer hergestellten Menge, in Zusammenhang mit der Grundeinheit
         */
        if ($multiplierInput){
            $requestedEinheit = $producedZutat->einheit()->first()->id;
            $requestedQuantity = $this->ertrag * $multiplierInput;
        }
        else {
            $requestedEinheit = $einheitInput;
            $requestedQuantity = $quantityInput;
        }

        $craftedMenge = 0;

        // Beginn der Fallunterscheidung
        if ($requestedEinheit == $producedZutat->einheit){
            // Fall 1
            $craftedMenge = $requestedQuantity;
        }
        else{
            // Fall 2 & 3 & 4 & 5 & 6
            //Abfrage Fall 2 & 3 oder 4 & 5 & 6
            if (!$producedZutat->conversion_einheit){
                // Fall 2 & 3
                $umrechnung = $conversions->getUmrechnung($requestedEinheit, $producedZutat->einheit);
                if ($umrechnung){
                    // Fall 2
                    $faktor = $conversions->getFaktor($producedZutat->einheit, $umrechnung);
                } else {
                    // Fall 3
                    $requestedEinheitModel = Einheit::where('id', $requestedEinheit)->first();
                    $middleEinheit = $conversions->getTwoWayUmrechnung($producedZutat->einheit()->first(), $requestedEinheitModel);
                    $middleEinheit = array_shift($middleEinheit);
                    $faktor1 = $conversions->getFaktor($middleEinheit, $conversions->getUmrechnung($middleEinheit, $producedZutat->einheit));
                    $faktor2 = $conversions->getFaktor($requestedEinheit, $conversions->getUmrechnung($requestedEinheit, $middleEinheit));
                    $faktor = $faktor1*$faktor2;
                }
            }else {
                // Fall 4 & 5 & 6
                if ($requestedEinheit == $producedZutat->conversion_einheit){
                    // Fall 4
                    $faktor = 1 / $producedZutat->faktor;
                } else {
                    // Fall 5 & 6
                    $umrechnung = $conversions->getUmrechnung($requestedEinheit, $producedZutat->conversion_einheit);
                    if ($umrechnung){
                        // Fall 5
                        $faktor = (1 / $producedZutat->faktor) * $conversions->getFaktor($requestedEinheit, $umrechnung);
                    } else {
                        // Fall 6
                        $requestedEinheitModel = Einheit::where('id', $requestedEinheit)->first();
                        $middleEinheit = $conversions->getTwoWayUmrechnung($producedZutat->conversion_einheit()->first(), $requestedEinheitModel);
                        $middleEinheit = array_shift($middleEinheit);
                        $middleFaktor1 = $conversions->getFaktor($middleEinheit, $conversions->getUmrechnung($middleEinheit, $producedZutat->conversion_einheit));
                        $middleFaktor2 = $conversions->getFaktor($requestedEinheit, $conversions->getUmrechnung($requestedEinheit, $middleEinheit));
                        $middleFaktor = $middleFaktor1*$middleFaktor2;
                        $faktor = (1/$producedZutat->faktor)*$middleFaktor;
                    }
                }
            }
            // Erzeugen der Variable die die hergestellte Menge darstellt unter berücksichtigung des vorhin generierten Faktors
            $craftedMenge = $requestedQuantity*$faktor;
        }

        // Überprüfe ob gerundet werden muss
        if ($producedZutat->round)
            $craftedMenge = ceil($craftedMenge);

        // Lagerbestand angleichen
        $producedZutat->lagerbestand += $craftedMenge;
        $producedZutat->save();

        // Variable die das Verhältnis darstellt zwischen der tatsächlich hergestellten Menge und dem Ertrag des Rezepts
        $portion = $craftedMenge/$this->ertrag;

        return $portion;
    }
}
