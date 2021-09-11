<?php

namespace App\Application;


use App\Domain\AuthService;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;

class AuthController
{

    public $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function route($method, $urlData, $formData): void
    {
        /**
         * POST /users/login
         */
        if ($method === 'POST' && $urlData[0] === "login") {

            $result = $this->authService->login($formData);
            (new HttpResponse(new JsonPresenter()))->response((array) $result);
        }

        /**
         * POST /users/checkToken
         */
        if ($method === 'POST' && $urlData[0] === "checkToken") {

            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if ($method === 'GET' && !empty($authHeader)) {
                $explodedAuthHeader = explode(" ", $authHeader);
                $tokenValue = $explodedAuthHeader[1];
            }

            $result = $this->authService->checkToken($formData, $tokenValue);
            (new HttpResponse(new JsonPresenter()))->response((array) $result);
        }

        /**
         * POST /users/create
         */
        if ($method === 'POST' && $urlData[0] === "create") {
            $result = $this->authService->register($formData);
            (new HttpResponse(new JsonPresenter()))->response((array) $result);
        }
    }
}