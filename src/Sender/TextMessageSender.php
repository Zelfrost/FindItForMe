<?php

use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Response;

class TextMessageSender implements SenderInterface
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function send(string $message): bool
    {
        $parameters = http_build_query(array_merge(
            Config::get('sms.api_auth_params'),
            [Config::get('sms.api_content_param') => $message]
        ));

        $response = $this->client->get(sprintf(
            "%s?%s",
            Config::get('sms.api_url'),
            $parameters
        ))->send();

        if (Response::HTTP_BAD_REQUEST === $response->getStatusCode()) {
            $this->log("L'appel n'a pu être effectué, il manque des paramètres. Contenu : $message");
        } elseif (Response::HTTP_PAYMENT_REQUIRED === $response->getStatusCode()
            || Response::HTTP_INTERNAL_SERVER_ERROR === $response->getStatusCode()
        ) {
            return false;
        }

        return true;
    }

    public function isUnitary(): bool
    {
        return true;
    }

    private function log(string $error)
    {
        $logFile = Config::getLogFile();

        file_put_contents($logFile, $error . "\n", FILE_APPEND);
    }
}
