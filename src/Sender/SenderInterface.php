<?php

interface SenderInterface
{
    public function send(string $text): bool;
    public function isUnitary(): bool;
}