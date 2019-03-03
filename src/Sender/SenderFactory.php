<?php

class SenderFactory
{
    /**
     * @return SenderInterface|null
     */
    public static function buildSender()
    {
        switch (Args::getMode()) {
            case 'sms':
                return new TextMessageSender();
            case 'mail':
                return new MailSender();
        }
    }
}