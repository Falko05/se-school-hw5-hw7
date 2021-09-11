<?php

namespace App\Domain;

class ExchangerService implements ExchangerInterface
{

    public $rateSource;
    public $rate;

    public function __construct(RateSource $rateSource)
    {
        $this->rateSource = $rateSource;
    }

    public function getCoinCurrency($base, $target): ?float
    {
        $this->rate = $this->rateSource->getCoinCurrency($base, $target);
        return $this->rate;
    }
}