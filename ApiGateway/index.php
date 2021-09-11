<?php

require_once __DIR__.'/vendor/autoload.php';

use Bootstrap\app;
use Dotenv\Dotenv;
use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new app(new HttpResponse(new JsonPresenter()));

$app->run();