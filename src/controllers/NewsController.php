<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\News;
use app\services\RbcClient;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewsController
{
    private Response $_response;

    public function __construct()
    {
        $this->_response = new Response();
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $rbcClient = new RbcClient(
            'rbc.ru',
            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
            . time()
            . '/limit/'
            . 10
            . '?_='
            . time());
        $newsObject = json_decode($rbcClient->sendRequest());
        foreach($newsObject->items as $news) {
            $news = new News($news->html);
            $url = $news->getUrl();
            $parseUrl = parse_url($url);

        }
    }
}