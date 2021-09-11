<?php

namespace App\Infrastructure;

use App\Domain\Customer;
use App\Domain\TokenLib;
use Dotenv\Dotenv;
use Exception;
use Firebase\JWT\JWT;

class JwtTokenLib implements TokenLib
{
    private $secretKey;
    private $issuerClaim;
    private $audienceClaim;

    public function __construct()
    {
        $this->secretKey = $_ENV['JWT_SECRET_KEY'];
        $this->issuerClaim = "genesisapi/";
        $this->audienceClaim = "genesisapi/";
    }

    /**
     * @param Customer $customer
     * @return array
     */
    public function createToken(Customer $customer): array
    {
        $issueDateClaim = time();
        $notBeforeClaim = $issueDateClaim;
        $expireClaim = $issueDateClaim + (60 * 20);
        $token = [
            "iss" => $this->issuerClaim,
            "aud" => $this->audienceClaim,
            "iat" => $issueDateClaim,
            "nbf" => $notBeforeClaim,
            "exp" => $expireClaim,
            "data" => [
                "email" => $email
            ]
        ];

        $jwt = JWT::encode($token, $this->secretKey);
        return ['jwt' => $jwt, 'expireAt' => $expireClaim];
    }

    /**
    * @param string $token
    * @return bool
    */
    public function checkToken(string $token): bool
    {
        try {
            JWT::decode($token, $this->secretKey, ['HS256']);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}