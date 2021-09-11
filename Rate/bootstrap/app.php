<?php


namespace Bootstrap;

use App\Application\RateController;
use App\Domain\ExchangerService;
use App\Infrastructure\CryptonatorRateSource;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;

class app
{

    public $response;

    public function __construct()
    {
        $this->response = new HttpResponse(new JsonPresenter());
    }

    public function getFormData($method): array
    {

        // GET или POST
        if ($method === 'GET') {
            return $_GET;
        }
        if ($method === 'POST') {
            return $_POST;
        }

        // PUT, PATCH или DELETE
        $formData = [];
        $explodedData = explode('&', file_get_contents('php://input'));

        foreach ($explodedData as $keyValue) {
            $item = explode('=', $keyValue);
            if (count($item) === 2) {
                $formData[urldecode($item[0])] = urldecode($item[1]);
            }
        }

        return $formData;
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $formData = $this->getFormData($method);

        $url = $_SERVER['REQUEST_URI'] ?? '';
        $url = ltrim($url, '/');
        $urls = explode('/', $url);

        $router = $urls[0];
        $urlData = array_slice($urls, 1);

        if ($router === 'btcRate') {
            $route = new RateController(new ExchangerService(new CryptonatorRateSource('btc', 'uah')));
        } else {
            $this->response->response([
                'message' => 'Route Not Found'
            ]);
        }
        $route->route($method, $urlData, $formData);
    }
}