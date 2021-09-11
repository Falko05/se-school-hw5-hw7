<?php

namespace App\Domain;

interface TokenLib
{

    public function createToken(Customer $customer): array;

    public function checkToken(string $token): bool;
}