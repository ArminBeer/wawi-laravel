<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\BusinessPeriod;
use App\Models\Rezept;
use App\Traits\GastrofixOrders;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class apiCallOrder extends Command
{

    use GastrofixOrders;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:getOrders {businessPeriodID?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'API Call to get Orders from Lightspeed';

    protected $businessPeriodID = NULL;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($businessPeriodID = NULL)
    {
        parent::__construct();

        $this->businessPeriodID = $businessPeriodID;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        /**
         * Hiefür müssen folgende ENV Variablen angelegt werden:
         * API_CLIENT_ID 1 & 2
         * API_BUSINESS_ID 1 & 2
         * Diese bekommt man aus der Lightspeed Cloud
         */

        // if a period id is provided by the command line, use it. otherwise use the one from the constructor
        $businessPeriodId = $this->argument("businessPeriodID")??$this->businessPeriodID;
        try {
            // get all NEW orders
            $new_orders = $this->getNewOrders();
        } catch (GuzzleException $e) {
            Log::emergency("Could not get orders: " . $e->getMessage());
            return -1;
        }

        Log::info("got " . $new_orders->count() . " new orders.", [
            "new_orders" => $new_orders,
        ]);
        foreach ($new_orders as $new_order) {
            $sku = $new_order->itemSku;
            // check if a rezept exists with this sku
            $rezept = null;
            $article = Article::where('sku', $sku)->first();
            if ($article)
                $rezept = $article->rezept()->first();

            if (!$rezept) {
                Log::alert("No recipe with SKU $sku", ["new_order" => $new_order]);
                continue;
            }
            // how many?
            $quantity = $new_order->quantity * $new_order->units;
            Log::info("Reducing " . $rezept->name . "(sku: $sku) by $quantity", ["rezept" => $rezept, "new_order" => $new_order]);
            // Loop through all Zutaten in Rezept and sync
            foreach ($rezept->zutaten()->get() as $zutat) {
                $requestedZutatEinheit = floatval($zutat->pivot->einheit);
                $requestedZutatMenge = floatval($zutat->pivot->menge);
                $requestedZutatVerlust = floatval($zutat->pivot->verlust);

                Log::info("updating stored amounts of ingredient " . $zutat->name, [
                    "zutat" => $zutat,
                    "requestedZutatEinheit" => $requestedZutatEinheit,
                    "requestedZutatMenge" => $requestedZutatMenge,
                    "requestedZutatVerlust" => $requestedZutatVerlust
                ]);
                $zutat->updateIngredients($requestedZutatEinheit, $requestedZutatMenge, $requestedZutatVerlust, $quantity);
            }
        }

        return 0;
    }
}
