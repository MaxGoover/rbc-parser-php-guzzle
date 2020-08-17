<?php

namespace app\controllers;

use app\db\RbcDbArticle;
use app\layouts\ArticleLayout;
use app\layouts\NewsLayout;
use app\services\RbcClient;
use GuzzleHttp\Exception\GuzzleException;

class NewsController
{
    /**
     * Отрисовывает список новостей.
     * @throws GuzzleException
     */
    public function displayNews()
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
        $newsList = $rbcDbArticle->normalizeNews($result);

        // Отрисовываем список новостей
        echo $this->_renderNews($newsList);
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
     * Рендерит список новостей.
     * @param array $newsList
     * @return string
     */
    private function _renderNews(array $newsList): string
    {
        // Получаем стили для новостей
        $style = file_get_contents(__DIR__ . '/../../public/css/style.css', FILE_USE_INCLUDE_PATH);

        // Подключаем стили
        $html = "<style>$style</style><div class='background'></div>";

        // Рендерим список новостей
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
