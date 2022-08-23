<?php

namespace App\Services;
use App\Models\Einheit;
use App\Models\Umrechnung;

class ConversionService
{
    /**
     * Suche nach der direkten Umrechnung die 2 Einheiten verbinden
     *
     */
    public function getUmrechnung($requestedEinheit, $givenEinheit){
        return Umrechnung::where('ist_einheit', $requestedEinheit)->where('soll_einheit', $givenEinheit)
                        ->orWhere('soll_einheit', $requestedEinheit)->where('ist_einheit', $givenEinheit)->first();
    }

    /**
     * Auflösung des Faktors für die Umrechnung
     */
    public function getFaktor($requestedEinheit, $umrechnung){
        if($requestedEinheit == $umrechnung->ist_einheit)
            $faktor = $umrechnung->faktor;
        else
            $faktor = 1/($umrechnung->faktor);

        return $faktor;
    }

    /**
     * Tiefensuche von 2 Seiten, Start- und Endeinheit, suche der Einheit die beide
     * durch Umrechnungen verbinden
     */
    public function getTwoWayUmrechnung($givenEinheit, $requestedEinheit){
        $givenUmrechnungen = $givenEinheit->umrechnungen()->get();
        $requestedUmrechnungen = $requestedEinheit->umrechnungen()->get();

        /**
         * Bauen eines Einheiten Arrays bestehend aus Einheiten von Umrechnungen außer der eigenen
         * ausgehend von der gesuchten Einheit
         */
        $allGivenEinheiten = collect(new Einheit);
        foreach($givenUmrechnungen as $givenUmrechnung){
            if ($givenUmrechnung->ist_einheit()->first() == $givenEinheit)
                $allGivenEinheiten[] = $givenUmrechnung->soll_einheit()->first()->id;
            else
                $allGivenEinheiten[] = $givenUmrechnung->ist_einheit()->first()->id;
        }
        $allGivenEinheiten = $allGivenEinheiten->unique()->toArray();

        /**
         * Bauen eines Einheiten Arrays bestehend aus Einheiten von Umrechnungen außer der eigenen
         * ausgehend von der gesuchten Einheit
         */
        $allRequestedEinheiten = collect(new Einheit);
        foreach($requestedUmrechnungen as $requestedUmrechnung){
            if ($requestedUmrechnung->ist_einheit()->first() == $requestedEinheit)
                $allRequestedEinheiten[] = $requestedUmrechnung->soll_einheit()->first()->id;
            else
                $allRequestedEinheiten[] = $requestedUmrechnung->ist_einheit()->first()->id;
        }
        $allRequestedEinheiten = $allRequestedEinheiten->unique()->toArray();

        // Suche der Übereinstimmenden Einheit
        $einheitInTheMiddle = array_intersect($allGivenEinheiten, $allRequestedEinheiten);

        return $einheitInTheMiddle;
    }
}
