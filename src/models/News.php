<?php

namespace app\models;

class News
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocument($html);
    }

    public function getUrl()
    {
        $url = $this->_phpQuery
            ->find('a')
            ->attr('href');
        $this->print_arr($url);
        return $url;
    }

    function print_arr($array)
    {
        echo '<pre>' . print_r($array, true) . '</pre>';
    }
}