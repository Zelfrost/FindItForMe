<?php

use Guzzle\Http\Client;

class Requester
{
    const HTML_HEADERS = [
        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        'Accept-Encoding' => 'gzip, deflate, br',
        'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
        'Connection' => 'keep-alive',
        'Host' => 'www.leboncoin.fr',
        'Upgrade-Insecure-Requests' => '1',
        'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36',
    ];

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getContent($parameters) : string
    {
        if (-1 !== ($region = Config::get('leboncoin.region', -1))) {
            $parameters['locations'] = $region;
        }

        $parameters = http_build_query($parameters);

        $request = $this->client->get(sprintf('%s?%s', Config::get('leboncoin.url'), $parameters));
        $request->setHeaders(self::HTML_HEADERS);

        return $request->send()->getBody('true');
    }
}