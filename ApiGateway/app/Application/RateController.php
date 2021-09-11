<?php

namespace App\Application;

use App\Domain\AuthService;
use App\Domain\RateService;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;

class RateController
{

    public $exchangerService;
    public $authService;

    public function __construct(RateService $exchangerService, AuthService $authService)
    {
        $this->exchangerService = $exchangerService;
        $this->authService = $authService;
    }

    public function route($method, $urlData, $formData): void
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        if ($method === 'GET' && !empty($authHeader))
        {
            $explodedAuthHeader = explode(" ", $authHeader);
            $tokenValue = $explodedAuthHeader[1];
            $isLogged = $this->authService->checkToken($formData, $tokenValue);

            if($isLogged['status'] === true) {
                $result = $this->exchangerService->getCoinCurrency();
                (new HttpResponse(new JsonPresenter()))->response((array) $result);
            } else {
                (new HttpResponse(new JsonPresenter()))->response([
                    'massage' => 'Unauthorized.'
                ]);
            }
        }
        else {
            (new HttpResponse(new JsonPresenter()))->response([
                'massage' => 'Bad Request.'
            ]);
        }
    }




}
