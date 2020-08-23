<?php
require_once __DIR__ . '/vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];

// routes
if($uri === '/') {
    include __DIR__ . '/src/views/news.php';
} elseif(stripos($uri, '/article/') === 0) {
    include __DIR__ . '/src/views/article.php';
}
