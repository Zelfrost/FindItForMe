<?php

class Printer
{
    public function print(array $offer)
    {
        echo "${offer['title']}|${offer['price']}|${offer['url']}\n";
    }
}