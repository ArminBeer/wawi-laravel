<?php

namespace App\Traits;

use App\Models\Rezept;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Trait GastrofixArticles
 *
 * @brief Allows to put additional article info into Gastrofix through Gastrofix API
 * @package App\Traits
 */
trait GastrofixArticles
{
    use CallsGastrofixApi;

    /**
     * @param int|null $businessPeriod_id If not provided, gets the latest transactions
     * @return Collection
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @todo try to find out if transactions can change or are ony transmitted if closed.
     *       If they can, we need to either check the orders for uniqueness or do
     *       something completely different.
     */
    public function setArticleInfo()
    {
        // Get Articles from ESP
        $articles = Rezept::get();

        // Get Articles from ESP
        $article = Rezept::where('sku', 50012)->first();

        foreach ($articles as $article) {
            //Only go for artikels where sku is set
            if ($article->sku) {
                // Create Array
                $zutaten = $article->zutaten()->get();
                // Search for Allergene without dublicates
                $allergene = [];
                foreach ($zutaten as $zutat) {
                    foreach ($zutat['allergene'] as $allergen)
                        if (!in_array($allergen['name'], $allergene))
                            $allergene[] = $allergen['name'];
                }

                $input = "Allergene:\n" . implode(', ', $allergene) . "\nBeschreibung:\n" . $article->zubereitung()->first()->description_short;

                foreach (config('services.lightspeed') as $gastro) {
                    try {
                        $resp = ($this->patchGastrofix($article->sku, $input, $gastro));
                    } catch (ClientException $e) {
                        // Don't log this, sku is assossiated with other business id
                        // Log::info("Article with sku " . $article->sku . " not in Business " . $gastro['business_id'] . " Exception: " . $e->getMessage());
                    }
                }
            }
        }

        return true;
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
    public function setSingleArticleInfo($article)
    {
        //Only go for articels where sku is set
        if ($article->sku) {
            // Create Array
            $zutaten = $article->rezept()->first()->zutaten()->get();
            // Search for Allergene without dublicates
            $allergene = [];
            foreach ($zutaten as $zutat) {
                foreach ($zutat['allergene'] as $allergen)
                    if (!in_array($allergen['name'], $allergene))
                        $allergene[] = $allergen['name'];
            }

            $input = "Allergene:\n" . implode(', ', $allergene) . "\nBeschreibung:\n" . $article->rezept()->first()->zubereitung()->first()->description_short;

            $con = array();
            foreach (config('services.lightspeed') as $gastro) {
                if ($gastro['business_id'] == $article->business_id)
                    $con = $gastro;
            }


            foreach (config('services.lightspeed') as $gastro) {
                try {
                    $resp = ($this->patchGastrofix($article->sku, $input, $con));
                } catch (ClientException $e) {
                    // Don't log this, sku is assossiated with other business id
                    // Log::info("Article with sku " . $article->sku . " not in Business " . $gastro['business_id'] . " Exception: " . $e->getMessage());
                }
            }
        }

        return true;
    }


    /**
     * @return array Associative array where the sku maps to a pretty-printed name.
     * @throws \GuzzleHttp\Exception\GuzzleException If gastrofix-query fails
     *
     * Value is cached for 12 hours after retrieval
     */
    function get_skus()
    {
        $skus = Cache::get('skus');
        if (!$skus) {
            // Get all Articles from Lightspeed
            $gastro = config('services.lightspeed');
            $articles = [];
            foreach ($gastro as $item) {
                $response = $this->queryGastrofix('articles/', 'articles', $item);
                foreach (json_decode(json_encode($response), true)['articles'] as $article) {
                    $articles[$article['sku']] = $article['name'] . ' (' . $article['sku'] . ')';
                }
            }

            Cache::put('skus', $articles, 12 * 60 * 60);
            return $articles;
        }
        return $skus;
    }

}
