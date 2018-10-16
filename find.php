<?php

require_once('autoload.php');

$offers = [];

$requester = new Requester();
$crawler = new Crawler();
$database = new Database();
$printer = new Printer();
$sender = new Sender();

foreach ($crawler->getOffers($requester->getContent(Args::getParameters())) as $offer) {
    $details = $crawler->getDetails($offer);

    if ($database->offerAlreadyExist($details['identifier'])) {
        continue;
    } elseif (null === $details['price'] && !Args::authorizeNoPrice()) {
        continue;
    } elseif (null !== Args::getMinPrice() && Args::getMinPrice() > $details['price']) {
        continue;
    } elseif (null !== Args::getMaxPrice() && Args::getMaxPrice() < $details['price']) {
        continue;
    }

    $offers[] = $details;

    if (Args::isVerbose()) {
        $printer->print($details);
    }
}

if (empty($offers)) {
    return;
}

$sender->send($offers);
