<?php

namespace app\controllers;

use app\db\RbcDb;

class ArticleController
{
    public function __construct(int $articleId)
    {
        $db = new RbcDb();
        $result = $db
            ->query('SELECT * FROM articles WHERE `id` = ' . $articleId);
        echo $this->_showArticle($result->fetchArray());
    }

    /**
     * @param array $article
     * @return string
     */
    private function _showArticle(array $article): string
    {
        $style = file_get_contents(__DIR__ . '/../../public/css/style.css', FILE_USE_INCLUDE_PATH);
        $img = $article[4]
            ? "<img src='$article[4]'>"
            : '<br><span>КАРТИНКА НЕ НАЙДЕНА</span><br>';
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
