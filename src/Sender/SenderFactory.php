<?php

class SenderFactory
{
    public static function buildSender()
    {
        return 'sms' === Args::getMode()
            ? new TextMessageSender()
            : new MailSender()
        ;
    }
}