<?php

namespace app\layouts;

use phpQuery;

/**
 * Класс разметки новости.
 * Class NewsLayout
 * @package app\layouts
 */
class NewsLayout
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocument($html);
    }

    /**
     * Обрезает текст статьи.
     * @param string $text
     * @return string
     */
    static public function cutText(string $text): string
    {
        $text = mb_substr($text, 0, 200);
        $text = rtrim($text, "!,.-");
        $text = substr($text, 0, strrpos($text, ' '))."...";
        return nl2br($text);
    }

    /**
     * Возращает URL-ссылку на статью.
     * @return string
     */
    public function getUrl(): string
    {
        return $this->_phpQuery
            ->find('a')
            ->attr('href');
    }
}