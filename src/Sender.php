<?php

class Sender
{
    private $renderer;
    private $database;
    private $sender;

    public function __construct()
    {
        $this->renderer = new Renderer();
        $this->database = new Database();

        $this->sender = SenderFactory::buildSender();
    }

    public function send(array $offers)
    {
        if (null === $this->sender) {
            foreach ($offers as $offer) {
                $this->database->putOffer($offer['identifier']);
            }

            return;
        }

        $this->sender->isUnitary()
            ? $this->sendUnitary($offers)
            : $this->sendBatch($offers)
        ;
    }

    public function sendUnitary(array $offers)
    {
        foreach ($offers as $offer) {
            if ($this->sender->send($this->renderer->render([$offer]))) {
                $this->database->putOffer($offer['identifier']);
            }
        }
    }

    public function sendBatch(array $offers)
    {
        if ($this->sender->send($this->renderer->render($offers))) {
            foreach ($offers as $offer) {
                $this->database->putOffer($offer['identifier']);
            }
        }
    }
}
