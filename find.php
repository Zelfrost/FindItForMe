<?php

require_once('autoload.php');

$offers = [];

$requester = new Requester();
$crawler = new Crawler();
$database = new Database();

foreach ($crawler->getOffers($requester->getContent(Args::getParameters())) as $offer) {
    $details = $crawler->getDetails($offer);

    if ($database->offerAlreadyExist($identifier = $details['identifier'])) {
        continue;
    }

    $database->putOffer($identifier);
    unset($details['identifier']);

    if (null === $details['price'] && !Args::authorizeNoPrice()) {
        continue;
    } elseif (Args::getMinPrice() > $details['price']) {
        continue;
    } elseif (Args::getMaxPrice() < $details['price']) {
        continue;
    }

    $offers[] = $details;
}

if (Args::sendMail() && !empty($offers)) {
    $renderer = new Renderer();
    $mailer = new Mailer();

    $mailer->send($renderer->render($offers));
}
