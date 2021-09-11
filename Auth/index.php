<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Infrastructure\HttpResponse;
use App\Infrastructure\JsonPresenter;
use Bootstrap\app;

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new app(new HttpResponse(new JsonPresenter()));

$app->run();