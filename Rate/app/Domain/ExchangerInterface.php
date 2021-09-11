<?php

namespace App\Domain;

interface ExchangerInterface
{

    public function getCoinCurrency($base, $target): ?float;
}