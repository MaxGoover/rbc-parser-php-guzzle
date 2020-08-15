<?php

namespace app\entities;

use phpQuery;

class Article
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocument($html);
    }

//    public function getDescription()
//    {
//        $description = $this->_phpQuery
//            ->find('meta[name$=escription]')
//            ->attr('content');
//    }

    public function getImageSource()
    {
        return $this->_phpQuery
            ->find('.article__text img')
            ->attr('src');
    }

    public function getText()
    {
        return $this->_phpQuery
            ->find('.article__text p')
            ->text();
//            ->wrap('<div style="width: 690px">');
    }

    public function getTitle()
    {
        return $this->_phpQuery
            ->find('title')
            ->text();
    }
}