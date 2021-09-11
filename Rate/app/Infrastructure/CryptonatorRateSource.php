<?php

namespace App\Infrastructure;

use App\Domain\RateSource;

class CryptonatorRateSource implements RateSource
{

    private $apiUrl;
    private $base;
    private $target;

    public function __construct($base, $target)
    {
        $this->base = $base;
        $this->target = $target;
        $this->apiUrl = $_ENV["RATE_API_URL"];
    }

    public function getCoinCurrency(): ?float
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiUrl . $this->base . '-' . $this->target);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);

        $response = curl_exec($curl);
        $result = json_decode($response);

        $result_price = $result->ticker->price ?? null;

        return ($result_price);
    }
}