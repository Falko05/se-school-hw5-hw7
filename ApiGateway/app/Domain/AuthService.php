<?php

namespace App\Domain;

class AuthService
{

    public $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function login($formData)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->baseUrl  . '/user/login');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        return json_decode($response);
    }

    public function checkToken($formData, $tokenValue)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->baseUrl  . '/user/checkToken');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Authorization: ' . $tokenValue
        ]);

        $response = curl_exec($curl);
        return json_decode($response) ?? ['status' => false];
    }

    public function register($formData)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->baseUrl  . '/user/create');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $formData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        return json_decode($response);
    }
}