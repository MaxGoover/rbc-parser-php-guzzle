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
            . 15
            . '?_='
            . time());
        $newsObject = json_decode($rbcClient->sendRequest());

        // Создать таблицу для хранения новостей
        $db = new RbcDb();

        // Очищаем таблицу
        $db->clearTable('articles');

        foreach($newsObject->items as $key => $news) {
            $news = new News($news->html);
            $url = $news->getUrl();
            $parseUrl = parse_url($url);
            $rbcClient = new RbcClient(
                $parseUrl['scheme'] . '://' . $parseUrl['host'],
                $parseUrl['path'] . '?' . $parseUrl['query']
            );
            $html = $rbcClient->sendRequest();
            $article = new Article($html);
            $db->saveArticle($url, $article);
        }

        $result = $db->getNewsFromTable('articles');
        $newsList = $db->normalizeNews($result);
        echo $this->_showNews($newsList);
    }

    /**
     * Обрезает текст (например, текст статьи).
     * @param string $text
     * @return string
     */
    private function _cutText(string $text): string
    {
        $text = mb_substr($text, 0, 200);
        $text = rtrim($text, "!,.-");
        $text = substr($text, 0, strrpos($text, ' '))."...";
        return nl2br($text);
    }

    /**
     * Отрисовывает список новостей.
     * @param array $newsList
     * @return string
     */
    private function _showNews(array $newsList): string
    {
        $style = file_get_contents(__DIR__ . '/../../public/css/style.css', FILE_USE_INCLUDE_PATH);
        $html = "<style>$style</style><div class='background'></div>";
        foreach($newsList as $news) {
            $description = $this->_cutText($news[3]);
            $html .= <<<HTML
                <div class="content">
                    <a href="$news[1]">$news[1]</a>
                    <br><h1>$news[2]</h1>
                    <p>$description</p>
                    <a href='/article/$news[0]'>
                        <button class="cursor-pointer">Подробнее</button>
                    </a><br><br><hr><br>
                </div>
            HTML;
        }
        return $html;
    }
}
