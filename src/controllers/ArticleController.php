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
}
