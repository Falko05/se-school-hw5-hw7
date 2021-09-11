<?php

namespace App\Domain;

interface AuthInterface
{
    /**
     * @return Customer
     */
    public function login(): Customer;

    /**
     * @return Customer
     */
    public function register(): Customer;
}
