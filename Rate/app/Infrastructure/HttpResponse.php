<?php

namespace App\Infrastructure;

class HttpResponse implements Response
{

    public $presenter;
    protected $responseCode = 200;

    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    /**
     * @param array $params
     * @return void
     */
    public function response(array $params): void
    {
        http_response_code($this->responseCode);
        echo $this->presenter->present($params);
    }
}