<?php

namespace App\Domain;

class RateService
{

    public $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getCoinCurrency()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->baseUrl  . 'btcRate');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

        $response = curl_exec($curl);
        return json_decode($response);
    }
}