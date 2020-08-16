<?php

declare(strict_types=1);

namespace app\controllers;

use app\db\RbcDb;
use app\entities\Article;
use app\entities\News;
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
            'https://rbc.ru',
            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
            . time()
            . '/limit/'
            . 10
            . '?_='
            . time());
        $newsObject = json_decode($rbcClient->sendRequest());
//        $newsList = [];
        $db = new RbcDb();
        $db->query("CREATE TABLE articles(
            'id' INTEGER,
            'title' STRING,
            'image_source' STRING,
            'text' TEXT
        )");

        foreach($newsObject->items as $key => $news) {
            $news = new News($news->html);
            $url = $news->getUrl();
            $parseUrl = parse_url($url);
            $list[$key] = $parseUrl;
            $rbcClient = new RbcClient(
                $parseUrl['scheme'] . '://' . $parseUrl['host'],
                $parseUrl['path'] . '?' . $parseUrl['query']
            );
            $html = $rbcClient->sendRequest();
            $article = new Article($html);
//            $newsList[$key]['url'] = $url;
//            $newsList[$key]['title'] = $article->getTitle();
//            $newsList[$key]['imageSrc'] = $article->getImageSource();
//            $newsList[$key]['text'] = $article->getText();

            $db->query("INSERT INTO articles VALUES('$key', 'title', 'imageSrc','text')");
        }

        $result = $db->query('SELECT * FROM articles');
        $this->_response->getBody()->write(json_encode($result->fetchArray()));
        return $this->_response;
    }
}