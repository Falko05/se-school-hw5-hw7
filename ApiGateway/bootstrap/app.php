<?php


namespace Bootstrap;

use App\Application\AuthController;
use App\Application\RateController;
use App\Domain\AuthService;
use App\Domain\RateService;
use App\Infrastructure\Response;

class app
{

    public $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
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

        if ($router === "user") {
            $route = new AuthController(new AuthService($_ENV['AUTH_SERVICE']));
        } elseif ($router === 'btcRate') {
            $route = new RateController(new RateService($_ENV['RATES_SERVICE']), new AuthService($_ENV['AUTH_SERVICE']));
        } else {
            $this->response->response([
                'message' => 'Route Not Found'
            ]);
        }
        $route->route($method, $urlData, $formData);
    }
}