<?php

declare(strict_types=1);

namespace app\controllers;

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
        $newsLinks = [];
        foreach($newsObject->items as $news) {
            $news = new News($news->html);
        }

//        $this->_response->getBody()->write($news);
//        return $this->_response;
    }

    // Поля для БД
    // id (для роута), title, img, text

//    static public function getLastNews(ServerRequestInterface $request): ResponseInterface
//    {
//        $rbcClient = new RbcClient(
//            'rbc.ru',
//            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
//            . time()
//            . '/limit/'
//            . 10
//            . '?_='
//            . time());
//        $response = new Response();
//        $response->getBody()->write($rbcClient->getResponse());
//        return $response;
//    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
//        echo '<pre>';
//        print_r(get_class_methods($this->_response->getBody()));
//        echo '</pre>';
//        $response = $this->_guzzleClient->request(
//            'GET', '');

        $response = new Response();
        $response->getBody()->write(file_get_contents('news.php', true));
        return $response;

    }

//    private function _getNews()
//    {
//        $response = $this->_guzzleClient->request(
//            'GET',
//            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
//            . time()
//            . '/limit/'
//            . $this->_quantityNews
//            . '?_='
//            . time());
//        return $response->getBody()->getContents();
//
////    public function getNews(ServerRequestInterface $request): ResponseInterface {
////
////        $response = new Response();
////        $response->getBody()->write(
////            '<h1>News</h1>
////                   <a href="/article/2">
////                     <h3>Article</h3>
////                   </a>'
////        );
////        return $response;
//    }
}