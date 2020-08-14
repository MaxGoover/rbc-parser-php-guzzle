<?php

namespace app\models;

use phpQuery;

class Article
{
    private $_phpQuery;

    public function __construct(string $html)
    {
        $this->_phpQuery = phpQuery::newDocumentFileHTML($html);
    }

    public function getDescription()
    {
        $description = $this->_phpQuery
            ->find('meta[name$=escription]')
            ->attr('content');
        echo "<div style='width: 690px'><p>$description</p></div>";

        echo "<button>Подробнее</button><br><br><hr><br>";
    }

    public function getImageSource()
    {
        $src = $this->_phpQuery
            ->find('.article__text img')
            ->attr('src');
        echo "<br>
                <div style='width: 690px'>
                  <img src='{$src}' style='height: auto; max-width: 100%;'>
                </div>
              <br>";
//        echo "<br><div style='width: 690px'><img='$src'></div><br>";
        //<img src='$src'>
        //.article__text
        //..article__main-image__wrap img
        //     height: auto;
        //    max-width: 100%;
    }

    public function getText()
    {
        $text = $this->_phpQuery
            ->find('.article__text_free p')
            ->wrap('<div style="width: 690px">');
        $this->print_arr($text);
    }

    public function getTitle()
    {
        $title = $this->_phpQuery
            ->find('title')
            ->text();
        echo "<div style='width: 690px'><h1>$title</h1></div>";
    }

    function print_arr($array)
    {
        echo '<pre>' . print_r($array, true) . '</pre>';
    }
}