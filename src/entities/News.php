<?php

namespace app\entities;

use phpQuery;

class News
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocument($html);
    }

    public function getUrl(): string
    {
        return $this->_phpQuery
            ->find('a')
            ->attr('href');
    }
}