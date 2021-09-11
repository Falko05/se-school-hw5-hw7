<?php

namespace App\Domain;

interface RateSource
{

	public function getCoinCurrency(): ?float;
}
