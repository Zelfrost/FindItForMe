<?php

use Guzzle\Http\Client;

class TextMessenger
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function send(string $message)
    {
        $parameters = http_build_query(array_merge(
            Config::get('sms.api_auth_params'),
            [Config::get('sms.api_content_param') => $message]
        ));

        $this->client->get(sprintf(
            "%s?%s",
            Config::get('sms.api_url'),
            $parameters
        ))->send();
    }
}