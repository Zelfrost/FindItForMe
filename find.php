<?php

require_once('autoload.php');

$offers = [];

$requester = new Requester();
$crawler = new Crawler();
$database = new Database();
$printer = new Printer();

foreach ($crawler->getOffers($requester->getContent(Args::getParameters())) as $offer) {
    $details = $crawler->getDetails($offer);

    if ($database->offerAlreadyExist($identifier = $details['identifier'])) {
        continue;
    }

    $database->putOffer($identifier);
    unset($details['identifier']);

    if (null === $details['price'] && !Args::authorizeNoPrice()) {
        continue;
    } elseif (null !== Args::getMinPrice() && Args::getMinPrice() > $details['price']) {
        continue;
    } elseif (null !== Args::getMaxPrice() && Args::getMaxPrice() < $details['price']) {
        continue;
    }

    $offers[] = $details;
}

if (empty($offers)) {
    return;
}

if (Args::sendMail()) {
    $renderer = new Renderer();
    $mailer = new Mailer();

    $mailer->send($renderer->render($offers));
}

if (Args::isVerbose()) {
    $printer->print($offers);
}
