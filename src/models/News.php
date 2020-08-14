<?php

namespace app\models;

use phpQuery;

class News
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocument($html);
    }

    public function getUrl()
    {
        return $this->_phpQuery
            ->find('a')
            ->attr('href');
    }
}