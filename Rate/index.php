<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bootstrap\app;
use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new app();

$app->run();