<?php

require_once __DIR__ . '/../bootstrap.php';
//require_once __DIR__ . '/../src/router/router.php';

use app\controllers\ArticleController;
use app\controllers\NewsController;

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/') {
    new NewsController();
}
if (stripos($uri, '/article/') === 0) {
    $articleId = (int)explode('/', $uri)[2];
    new ArticleController($articleId);
}
