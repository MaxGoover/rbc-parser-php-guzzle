<?php

namespace app\controllers;

use app\db\RbcDb;

class ArticleController
{
    public function __construct(int $articleId)
    {
        $db = new RbcDb();
        $result = $db->query('SELECT * FROM articles WHERE `id` = ' . $articleId);
        echo $this->_showArticle($result->fetchArray());
    }

    private function _showArticle(array $article): string
    {
        return <<<HTML
                <br><h1>$article[2]</h1>
                <img src="$article[3]">
                <p>$article[4]</p>
            HTML;
    }
}
