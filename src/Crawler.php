<?php

use Symfony\Component\DomCrawler\Crawler as BaseCrawler;

class Crawler
{
    public function getOffers(string $html) : BaseCrawler
    {
        $crawler = new BaseCrawler($html);

        return $crawler->filterXPath('//li[@itemtype="http://schema.org/Offer"]');
    }

    public function getDetails(DOMElement $crawler) : array
    {
        $crawler = new BaseCrawler($crawler);

        $url = $crawler
            ->filterXPath('//a[@href]')->getNode(0)
            ->attributes->getNamedItem('href')->nodeValue
        ;

        preg_match('/^\/[a-z_]+\/(\d+)\.htm\/$/', $url, $identifiers);

        $priceNode = $crawler->filterXPath('//span[@itemprop="priceCurrency"]')->getNode(0);
        $price = null !== $priceNode ? (int) $priceNode->nodeValue : null;

        return [
            'identifier' => $identifiers[1],
            'title' => $crawler->filterXPath('//span[@itemprop="name"]')->getNode(0)->nodeValue,
            'price' => $price,
            'url' => sprintf('%s%s', 'https://www.leboncoin.fr', $url),
        ];
    }
}