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
        $src = $this->_phpQuery
            ->find('.article__text img')
            ->attr('src');
        return $src ?: null;
    }

    public function getText()
    {
        $text = $this->_phpQuery
            ->find('.article__text p')
            ->text();
        return $text ?: 'Текст статьи не найден';
//            ->wrap('<div style="width: 690px">');
    }

    public function getTitle()
    {
        $title = $this->_phpQuery
            ->find('title')
            ->text();
        return $title ?: 'Заголовок статьи не найден';
    }
}