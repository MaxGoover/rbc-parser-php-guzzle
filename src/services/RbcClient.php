<?php

namespace app\services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Класс подключения к API РБК.
 * Class RbcClient
 * @package app\services
 */
class RbcClient
{
    public string $_uri;
    private Client $_guzzleClient;

    /**
     * Получает HTML-разметку статьи.
     * @param string $url
     * @return string
     * @throws GuzzleException
     */
    public function getArticleLayoutByUrl(string $url)
    {
        $parseUrl = parse_url($url);
        $this->_guzzleClient = new Client([
            'base_uri' => $parseUrl['scheme'] . '://' . $parseUrl['host']
        ]);
        $this->_uri = $parseUrl['path'] . '?' . $parseUrl['query'];
        return $this->_sendRequest();
    }

    /**
     * Получает список новостей (вместе с разметкой).
     * @return array
     * @throws GuzzleException
     */
    public function getNewsLayouts(): array
    {
        $this->_guzzleClient = new Client([
            'base_uri' => 'https://rbc.ru'
        ]);
        $this->_uri =
            'v10/ajax/get-news-feed/project/rbcnews/lastDate/'
            . time() . '/limit/' . 15 . '?_='. time();
        $newsObject = json_decode($this->_sendRequest());
        return $newsObject->items;
    }

    /**
     * Делает запрос к API РБК.
     * @return string
     * @throws GuzzleException
     */
    private function _sendRequest()
    {
        $response = $this->_guzzleClient->request('GET', $this->_uri);
        return $response->getBody()->getContents();
    }
}