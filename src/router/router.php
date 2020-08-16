<?php

declare(strict_types=1);

//use app\controllers\ArticleController;
use app\controllers\NewsController;

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

// map a route
$router->map('GET', '/', NewsController::class);
$router->map('GET', '/article/{id:\d+}', ArticleController::class);

$response = $router->dispatch($request);

// send the response to the browser
(new Laminas\HttpHandlerRunner\Emitter\SapiEmitter)->emit($response);
