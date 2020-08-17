<?php

namespace app\controllers;

use app\db\RbcDbArticle;

class ArticleController
{
    private int $_articleId;

    public function __construct(int $articleId)
    {
        $this->_articleId = $articleId;
    }

    /**
     * Отрисовывает статью.
     */
    public function displayArticle()
    {
        // Получаем статью из БД
        $rbcDbArticle = new RbcDbArticle();
        $result = $rbcDbArticle->getById($this->_articleId);

        // Отрисовываем статью
        echo $this->_renderArticle($result->fetchArray());
    }

    /**
     * Рендерит статью.
     * @param array $article
     * @return string
     */
    private function _renderArticle(array $article): string
    {
        // Получаем стили для статьи
        $style = file_get_contents(__DIR__ . '/../../public/css/style.css', FILE_USE_INCLUDE_PATH);

        // Проверяем наличие картинки у статьи
        $img = $article[4]
            ? "<img src='$article[4]'>"
            : '<br><span>КАРТИНКА НЕ НАЙДЕНА</span><br>';

        // Рендерим статью
        return <<<HTML
                <style>
                    $style
                </style>
                <div class="background"></div>
                <div class="main">
                    <div class="content">
                        <a href="$article[1]">$article[1]</a>
                        <br><h1>$article[2]</h1>
                        <span>$article[3]</span>
                        $img
                        <p>$article[5]</p>
                    </div>
                </div>
            HTML;
    }
}
