<?php

namespace App\Traits;

use GuzzleHttp\Client;

/**
 * Trait CallsGastrofixApi
 *
 * @brief General trait that allows calling the Gastrofix API
 * @package App\Traits
 */
trait CallsGastrofixApi {
    /**
     * @brief General call to the Gastrofix API.
     * @param $request string The specific request inside the module
     * @param $module string The module (transactions, employees...)
     * @return mixed The decoded response body.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function queryGastrofix($request, $module, $gastro) {
        $url = "https://cloud.gastrofix.com/api/$module/v3.0/$request";
        $headers = [
            'X-Token' => $gastro['token'],
            'X-Business-Units' => $gastro['business_id'],
        ];
        $client = new Client();
        $response = $client->request('GET', $url, [
            'headers' => $headers,
            'verify'  => false,
        ]);

        return json_decode($response->getBody());
    }

    public function patchGastrofix($articleId, $input, $gastro) {
        $url = "https://cloud.gastrofix.com/api/articles/v3.0/articles/$articleId/";

        $headers = [
            'X-Token' => $gastro['token'],
            'X-Business-Units' => $gastro['business_id'],
        ];
        $client = new Client();
        $response = $client->request('PATCH', $url, [
            'headers' => $headers,
            'verify'  => false,
            'body' =>json_encode([
                'description' => $input,
            ])

        ]);

        return json_decode($response->getBody());
    }
}
