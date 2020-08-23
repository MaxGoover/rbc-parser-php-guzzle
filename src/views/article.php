<?php

use app\controllers\ArticleController;

$uri = $_SERVER['REQUEST_URI'];

$articleId = (int)explode('/', $uri)[2];
$article = (new ArticleController($articleId))->getArticle();
?>

<!--<template>-->
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="../../public/css/style.css" rel="stylesheet" type="text/css">
  <title>Парсер новостей с сайта РБК</title>
</head>
<body>
<div class="background"></div>
<div class="content">
  <a href="<?= $article['url']; ?>"><?= $article['url']; ?></a>
  <br>
  <h1><?= $article['title']; ?></h1>
  <span><?= $article['description']; ?></span>
  <br>
    <?php if($article['image_source']): ?>
      <img src="<?= $article['image_source']; ?>">
    <?php else: ?>
      <span>КАРТИНКА НЕ НАЙДЕНА</span>
      <br>
    <?php endif; ?>
  <p><?= $article['text']; ?></p>
</div>
</body>
</html>
<!--</template>-->
