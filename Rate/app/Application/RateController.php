<?php

namespace App\Application;

use App\Domain\ExchangerInterface;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;

class RateController
{

    public $exchangerService;

    public function __construct(ExchangerInterface $exchangerService)
    {
        $this->exchangerService = $exchangerService;
    }

    public function route($method): void
    {
        if ($method === 'GET') {
            $result = $this->exchangerService->getCoinCurrency('btc', 'uah');

            (new HttpResponse(new JsonPresenter()))->response([
                'result' => $result,
                'massage' => 'Successed'
            ]);
        }
        else {
            (new HttpResponse(new JsonPresenter()))->response([
                'massage' => 'Bad Request.'
            ]);
        }
    }




}
