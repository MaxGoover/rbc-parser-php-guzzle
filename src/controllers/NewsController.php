<?php

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
        // Получить 10 новостей
        $rbcClient = new RbcClient(
            'https://rbc.ru',
            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
            . time()
            . '/limit/'
            . 10
            . '?_='
            . time());
        $newsObject = json_decode($rbcClient->sendRequest());

        // Создать таблицу для хранения новостей
        $db = new RbcDb();
//        $db->query("CREATE TABLE articles(
//            'id' INTEGER PRIMARY KEY,
//            'url' STRING,
//            'title' STRING,
//            'image_source' STRING,
//            'text' TEXT
//        )");

        // Очищаем таблицу
        $db->query("DELETE FROM articles");

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
            $title = $article->getTitle();
            $imageSource = $article->getImageSource();
            $text = $article->getText();

            $db->query("
                INSERT INTO articles('url', 'title', 'image_source', 'text')
                VALUES(
                '$url',
                '$title',
                '$imageSource',
                '$text')");
        }

        $result = $db->query('SELECT id, title, text FROM articles');
        $newsList = [];
        $result->reset();
        while ($article = $result->fetchArray()) {
//            $articles['description'] = $this->_cutText($article['text']);
            $newsList[] = $article;
        }

        $db->close();
        $this->_response
            ->getBody()
            ->write($this->_showNews($newsList));
        return $this->_response;
    }

    private function _cutText(string $text): string
    {
        $text = substr($text, 0, 200);
        $text = rtrim($text, "!,.-");
        $text = substr($text, 0, strrpos($text, ' '))."...";
        return nl2br($text);
    }

    private function _showNews(array $newsList): string
    {
        $html = '';
        foreach($newsList as $news) {
            $html .= <<<HTML
                <h1></h1>

            HTML;
        }

        return <<<HTML
            

        HTML;
    }
}