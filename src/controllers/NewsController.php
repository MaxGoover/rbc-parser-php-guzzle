<?php

declare(strict_types=1);

namespace app\controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewsController
{
    public function __invoke(ServerRequestInterface $request) : ResponseInterface {
        $response = new Response();
        $response->getBody()->write(
            '<h1>News</h1>
                   <a href="/article">
                     <h3>Article</h3>
                   </a>'
        );
        return $response;
    }
}