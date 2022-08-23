<?php

namespace App\Console\Commands;

use App\Models\Bon;
use Illuminate\Console\Command;
use App\Models\Zutat;
use App\Models\Rezept;
use App\Models\Umrechnung;

class GetBons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bons:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Bons from POS system each minute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $incomingBons = Bon::where('processed', 0)->get();

        foreach ($incomingBons as $bon){

            $rezept = Rezept::where('id', $bon['rezept'])->first();

            foreach ($rezept->zutaten()->get() as $zutat){
                    $requestedZutatEinheit = floatval($zutat->pivot->einheit);
                    $requestedZutatMenge = floatval($zutat->pivot->menge);
                    $requestedZutatVerlust = floatval($zutat->pivot->verlust);
                    $zutat->updateIngredients($requestedZutatEinheit, $requestedZutatMenge, $requestedZutatVerlust, $bon['menge']);
            }

            $bon->processed = 1;
            $bon->save();
        }

    }
}
