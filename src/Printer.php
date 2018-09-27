<?php

class Printer
{
    public function print(array $offers)
    {
        foreach ($offers as $offer) {
            echo "${offer['title']}|${offer['price']}|${offer['url']}\n";
        }
    }
}