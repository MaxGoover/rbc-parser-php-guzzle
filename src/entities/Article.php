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

    /**
     * Возвращает описание статьи.
     * @return string
     */
    public function getDescription(): string
    {
        $text = $this->_phpQuery
            ->find('.article__text span')
            ->text();
        return $text;
    }

    /**
     * Возвращает ссылку на картинку.
     * @return string|null
     */
    public function getImageSource(): ?string
    {
        $src = $this->_phpQuery
            ->find('.article__text img')
            ->attr('src');
        return $src ?: null;
    }

    /**
     * Возвращает текст статьи.
     * @return string
     */
    public function getText(): string
    {
        $text = $this->_phpQuery
            ->find('.article__text p')
            ->text();
        return $text ?: 'ТЕКСТ СТАТЬИ НЕ НАЙДЕН';
    }

    /**
     * Возвращает заголовок статьи.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->_phpQuery
            ->find('title')
            ->text();
    }
}