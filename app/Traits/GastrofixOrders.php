<?php

namespace App\Traits;

use App\Models\BusinessPeriod;
use App\Models\KassenOrder;
use App\Models\KassenOrderItem;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

/**
 * Trait GastrofixOrders
 *
 * @brief Allows to get orders from the Gastrofix API
 * @package App\Traits
 */
trait GastrofixOrders
{
    use CallsGastrofixApi;

    /**
     * @brief Syncs the business periods from Gastrofix
     * @return Collection All business periods
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBusinessPeriods($gastro)
    {
        $responseBody = $this->queryGastrofix('business_periods', 'transaction', $gastro);
        $items = collect([]);
        foreach ($responseBody->businessPeriods as $item) {
            $period = BusinessPeriod::updateOrCreate([
                'external_id' => $item->periodId,
                'business_id' => $gastro['business_id'],
            ], [
                'businessDay' => Carbon::parse($item->businessDay),
                'startPeriodTimestamp' => Carbon::parse($item->startPeriodTimestamp),
                'finishPeriodTimestamp' => isset($item->finishPeriodTimestamp) ? Carbon::parse($item->finishPeriodTimestamp) : NULL,
            ]);
            $items->push($period);
        }
        return $items;
    }

    /**
     * @param int|null $businessPeriod_id If not provided, gets the latest transactions
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @todo try to find out if transactions can change or are ony transmitted if closed.
     *       If they can, we need to either check the orders for uniqueness or do
     *       something completely different.
     */
    public function getNewOrders()
    {
        $new_orders = collect([]);
        foreach (config('services.lightspeed') as $gastro) {
            $responseBody = $this->queryGastrofix('transactions/', 'transaction', $gastro);
            $businessPeriod_id = $responseBody->periodId;
            Log::debug("Got " . sizeof($responseBody->transactions) . " transactions for period $businessPeriod_id");

            $business_period = BusinessPeriod::where('external_id', $businessPeriod_id)->where('business_id', $gastro['business_id'])->first();
            if (!$business_period) {
                // doesn't exist yet.
                Log::debug("no businessPeriod with id $businessPeriod_id yet. Syncing...");
                $this->getBusinessPeriods($gastro);
                $business_period = BusinessPeriod::where('external_id', $businessPeriod_id)->where('business_id', $gastro['business_id'])->first();
            }

            foreach ($responseBody->transactions as $item) {
                $transaction_id = $item->head->uuid;
                $transaction = KassenOrder::where('id', $transaction_id)->first() ?? NULL;
                if ($transaction) {
                    // check if transaction is still the same.
                    Log::debug("transaction $transaction_id already exists");
                } else {
                    $transaction = KassenOrder::create([
                        'id' => $transaction_id,
                        'business_period_id' => $business_period->id
                        ]);
                }

                $new_transaction_orders = collect([]);
                foreach ($item->lineItems as $lineItem) {
                    if (!isset($lineItem->related->itemSku)) {
                        continue;
                    }
                    
                    // check uniqueness.
                    $sequence_no = $lineItem->sequenceNumber;
                    
                    $recordedTimestamp = Carbon::parse($lineItem->timestamps->recordedTimestamp);
                    
                    $items = $transaction->kassenOrderItems()->where('sequenceNumber', $sequence_no)->get();

                    if ($items->count() > 0) {
                        continue;
                    }

                    $order_item = KassenOrderItem::create([
                        'kassen_order_id' => $transaction_id,
                        'itemSku' => $lineItem->related->itemSku,
                        'quantity' => $lineItem->amounts->quantity / 1000,
                        'units' => $lineItem->amounts->units / 1000,
                        'recordedTimestamp' => $recordedTimestamp,
                        'sequenceNumber' => $sequence_no,
                    ]);
                    
                    $new_transaction_orders->push($order_item);
                }

                if ($new_transaction_orders->isEmpty()) {
                    Log::debug("transaction $transaction_id has no orders with associated SKUs. Skipping it.");
                    continue;
                }
                Log::debug("transaction $transaction_id has " . $new_transaction_orders->count() . " orders.", [
                    "order_items" => $new_transaction_orders,
                    "transaction" => $transaction
                ]);

                foreach ($new_transaction_orders as $order_item) {
                    $order_item->save();
                }

                $new_orders= $new_orders->concat($new_transaction_orders);
            }
        }
        return $new_orders;
    }
}
