<?php

namespace app\db;

use app\layouts\ArticleLayout;
use SQLite3Result;

/**
 * Класс подключения к таблице 'articles'.
 * Class RbcDbArticle
 * @package app\db
 */
class RbcDbArticle extends RbcDb
{
    private string $_tableName = 'articles';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Очищает таблицу.
     */
    public function clearTable()
    {
        $this->exec("DELETE FROM " . $this->_tableName);
    }

    /**
     * Получает статью по ID.
     * @param int $articleId
     * @return SQLite3Result
     */
    public function getById(int $articleId): SQLite3Result
    {
        return $this->query("
                SELECT * FROM " . $this->_tableName . "
                WHERE `id` = " . $articleId);
    }

    /**
     * Получает новости из таблицы.
     * @return SQLite3Result
     */
    public function getNews(): SQLite3Result
    {
        return $this->query("SELECT id, url, title, text FROM " . $this->_tableName);
    }

    /**
     * Нормализует новости (из SQLite3Result в массив),
     * чтобы с ними можно было работать.
     * @param SQLite3Result $result
     * @return array
     */
    public function normalizeNews(SQLite3Result $result): array
    {
        $newsList = [];
        while ($article = $result->fetchArray()) {
            $newsList[] = $article;
        }
        $result->reset();
        return $newsList;
    }

    /**
     * Сохраняет статью в таблицу.
     * @param string $url
     * @param ArticleLayout $articleLayout
     */
    public function save(string $url, ArticleLayout $articleLayout)
    {
        $title = $articleLayout->getTitle();
        $description = $articleLayout->getDescription();
        $imageSource = $articleLayout->getImageSource();
        $text = $articleLayout->getText();
        $this->exec("
                INSERT INTO " . $this->_tableName . "
                ('url','title','description','image_source','text')
                VALUES
                ('$url','$title','$description','$imageSource','$text')");
    }
}