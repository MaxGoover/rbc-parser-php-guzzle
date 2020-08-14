<?php

namespace app\services;

use GuzzleHttp\Client;

class RbcClient
{
    private Client $_guzzleClient;
    public string $_uri;

    public function __construct(string $domainName, string $uri)
    {
        $this->_uri = $uri;
        $this->_guzzleClient = new Client([
            'base_uri' => 'https://' . $domainName
        ]);
    }

    public function sendRequest()
    {
        $response = $this->_guzzleClient->request('GET', $this->_uri);
        return $response->getBody()->getContents();
    }
}