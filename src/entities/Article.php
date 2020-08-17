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

    public function getImageSource(): ?string
    {
        $src = $this->_phpQuery
            ->find('.article__text img')
            ->attr('src');
        return $src ?: null;
    }

    public function getText(): string
    {
        $text = $this->_phpQuery
            ->find('.article__text p')
            ->text();
        return $text ?: 'ТЕКСТ НЕ НАЙДЕН';
    }

    public function getTitle(): string
    {
        $title = $this->_phpQuery
            ->find('title')
            ->text();
        return $title ?: 'Заголовок статьи не найден';
    }
}