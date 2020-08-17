<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\ArticleController;
use app\controllers\NewsController;
use GuzzleHttp\Exception\GuzzleException;

$uri = $_SERVER['REQUEST_URI'];

// Routes
if ($uri === '/') {
    $news = new NewsController();
    try { $news->displayNews(); }
    catch (GuzzleException $e) { echo 'Ошибка получения списка новостей'; }
}
elseif (stripos($uri, '/article/') === 0) {
    $articleId = (int)explode('/', $uri)[2];
    $article = new ArticleController($articleId);
    $article->displayArticle();
}
