<?php

use app\controllers\NewsController;
use app\layouts\NewsLayout;
use GuzzleHttp\Exception\GuzzleException;

try {
    $newsList = (new NewsController())->getNewsList();
}
catch (GuzzleException $e) {
    echo 'Ошибка получения списка новостей';
}
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
  <?php foreach($newsList as $news): ?>
    <a href="<?= $news['url']; ?>"><?= $news['url']; ?></a>
    <br>
    <h1><?= $news['title']; ?></h1>
    <p><?= NewsLayout::cutText($news['text']); ?></p>
    <a href="/article/<?= $news['id']; ?>">
      <button class="cursor-pointer">Подробнее</button>
    </a>
    <br><br><hr><br>
  <?php endforeach; ?>
</div>
</body>
</html>
<!--</template>-->