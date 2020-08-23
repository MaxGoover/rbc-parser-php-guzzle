<?php

namespace app\controllers;

use app\db\RbcDbArticle;

/**
 * Класс работы со статьёй.
 * Class ArticleController
 * @package app\controllers
 */
class ArticleController
{
    private int $_articleId;

    public function __construct(int $articleId)
    {
        $this->_articleId = $articleId;
    }

    /**
     * Получает статью.
     */
    public function getArticle(): array
    {
        // Получаем статью из БД
        $rbcDbArticle = new RbcDbArticle();
        $result = $rbcDbArticle->getById($this->_articleId);

        // Отдаем статью
        return $result->fetchArray();
    }

//    /**
//     * Рендерит статью.
//     * @param array $article
//     * @return string
//     */
//    private function _renderArticle(array $article): string
//    {
//        // Проверяем наличие картинки у статьи
//        $img = $article[4]
//            ? "<img src='$article[4]'>"
//            : '<br><span>КАРТИНКА НЕ НАЙДЕНА</span><br>';
//
//        // Рендерим статью
//        return <<<HTML
//                <style>
//                    $style
//                </style>
//                <div class="background"></div>
//                <div class="main">
//                    <div class="content">
//                        <a href="$article[1]">$article[1]</a>
//                        <br><h1>$article[2]</h1>
//                        <span>$article[3]</span>
//                        $img
//                        <p>$article[5]</p>
//                    </div>
//                </div>
//            HTML;
//    }
}
