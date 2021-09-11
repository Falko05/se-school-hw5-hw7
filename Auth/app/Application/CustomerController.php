<?php

namespace App\Application;

use App\Domain\AuthInterface;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;
use Exception;

class CustomerController
{
    public $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws Exception
     */
    public function route($method, $urlData, $formData): void
    {
        if($method === 'POST' && !empty($formData)) {
            $this->authService->customer->setEmail($formData['email']);
            $this->authService->customer->setPassword($formData['password']);
        }

        /**
         * Авторизация юзера
         * POST /users/login
         */
        if ($method === 'POST' && $urlData[0] === "login") {
            $this->loginAction();
        }

        /**
         * Добавление нового юзера
         * POST /users/create
         */
        if ($method === 'POST' && $urlData[0] === "create") {
            $this->registerAction();
        }

        /**
         * Проверка токена
         * POST /users/checkToken
         */
        if($method === 'POST' && $urlData[0] === "checkToken") {
            $this->checkTokenAction();
        }
    }

    /**
     * @return void
     */
    public function loginAction(): void
    {
        try {
            $response = $this->authService->login();
            (new HttpResponse(new JsonPresenter()))->response([
                'result' => $response
            ]);
        } catch (Exception $exception) {
            (new HttpResponse(new JsonPresenter()))->response([
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return void
     */
    public function registerAction(): void
    {
        try {
            $response = $this->authService->register();
            (new HttpResponse(new JsonPresenter()))->response([
                'result' => $response
            ]);
        } catch (Exception $exception) {
            (new HttpResponse(new JsonPresenter()))->response([
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @return void
     */
    public function checkTokenAction(): void
    {
        try {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if (!empty($authHeader)) {
                $explodedAuthHeader = explode(" ", $authHeader);
                $tokenValue = $explodedAuthHeader[1];
                $response = $this->authService->tokenLib->checkToken($tokenValue);
                (new HttpResponse(new JsonPresenter()))->response([
                    'status' => $response
                ]);
            }
        } catch (Exception $exception) {
            (new HttpResponse(new JsonPresenter()))->response([
                'message' => $exception->getMessage()
            ]);
        }
    }
}
