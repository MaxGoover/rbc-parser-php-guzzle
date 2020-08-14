<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\News;
use app\services\RbcClient;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ArticleController
{
    private Response $_response;

    public function __construct()
    {
        $this->_response = new Response();
    }

    public function __invoke(
        ServerRequestInterface $request,
        array $args = []
    ): ResponseInterface
    {
        $rbcClient = new RbcClient(
            $args['domainName'],
            $args['uri']);
        $html = $rbcClient->sendRequest();
        return $this->_response;
    }
}