<?php

namespace app\controllers;

use app\db\RbcDb;
use app\entities\Article;
use app\entities\News;
use app\services\RbcClient;

class NewsController
{
    public function __construct()
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

        $result = $db->query('SELECT id, url, title, text FROM articles');
        $newsList = [];
        $result->reset();
        while ($article = $result->fetchArray()) {
            $newsList[] = $article;
        }
        $result->reset();
        echo $this->_showNews($newsList);
    }

    private function _cutText(string $text): string
    {
        $text = mb_substr($text, 0, 200);
        $text = rtrim($text, "!,.-");
        $text = substr($text, 0, strrpos($text, ' '))."...";
        return nl2br($text);
    }

    private function _showNews(array $newsList): string
    {
        $html = '';
        foreach($newsList as $news) {
            $description = $this->_cutText($news[3]);
            $html .= <<<HTML
                <div class="background"></div>
                <div class="content">
                    <br><a href="$news[1]">$news[1]</a>
                    <br><h1>$news[2]</h1>
                    <p>$description</p>
                    <a href='/article/$news[0]'>
                        <button class="btn-more">Подробнее</button>
                    </a><br><hr><br>
                </div>
            HTML;
        }
        return $html;
    }
}
