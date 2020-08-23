<?php

namespace app\controllers;

use app\db\RbcDbArticle;
use app\layouts\ArticleLayout;
use app\layouts\NewsLayout;
use app\services\RbcClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Класс работы с новостями.
 * Class NewsController
 * @package app\controllers
 */
class NewsController
{
    /**
     * Получает список новостей.
     * @throws GuzzleException
     */
    public function getNewsList()
    {
        // Получаем список новостей
        $rbcClient = new RbcClient();
        $newsList = $rbcClient->getNewsLayouts();

        // Подключаемся к БД
        $rbcDbArticle = new RbcDbArticle();

        // Очищаем таблицу статей в БД
        $rbcDbArticle->clearTable();

        // У каждой новости получаем статью и сохраняем её в БД
        foreach($newsList as $key => $news) {
            $news = new NewsLayout($news->html);
            $url = $news->getUrl();
            $html = $rbcClient->getArticleLayoutByUrl($url);
            $article = new ArticleLayout($html);
            $rbcDbArticle->save($url, $article);
        }

        // Получаем список новостей из БД
        $result = $rbcDbArticle->getNews();
        return $rbcDbArticle->normalizeNews($result);
    }
}
