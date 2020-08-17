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