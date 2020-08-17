<?php

namespace app\db;

use app\entities\Article;
use SQLite3;
use SQLite3Result;

class RbcDb extends SQLite3
{
    function __construct()
    {
        $this->open(__DIR__ . 'rbcDb.db');
    }

    /**
     * Очищает таблицу БД.
     * @param string $tableName
     */
    public function clearTable(string $tableName)
    {
        $this->exec("DELETE FROM " . $tableName);
    }

    /**
     * Получает новости из таблицы БД.
     * @param string $tableName
     * @return SQLite3Result
     */
    public function getNewsFromTable(string $tableName): SQLite3Result
    {
        return $this->query('SELECT id, url, title, text FROM ' . $tableName);
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
     * Сохраняет статью в таблицу БД.
     * @param string $url
     * @param Article $article
     */
    public function saveArticle(string $url, Article $article)
    {
        $title = $article->getTitle();
        $description = $article->getDescription();
        $imageSource = $article->getImageSource();
        $text = $article->getText();
        $this->exec("
                INSERT INTO articles('url','title','description','image_source','text')
                VALUES('$url','$title','$description','$imageSource','$text')");
    }
}