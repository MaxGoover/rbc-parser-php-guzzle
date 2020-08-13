<?php

declare(strict_types=1);

namespace app\controllers;

use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleController
{
    public function __invoke(ServerRequestInterface $request) : ResponseInterface {
        $response = new Response();
        $response->getBody()->write(
            '<h1>Article</h1>
                   <a href="/">
                     <h3>News</h3>
                   </a>'
        );
        return $response;
    }
}