<?php

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $transport = new Swift_SmtpTransport(
            Config::get('smtp.url'),
            Config::get('smtp.port'),
            Config::get('smtp.encryption')
        );

        $transport->setAuthMode(Config::get('smtp.auth_mode'));
        $transport->setUsername(Config::get('smtp.username'));
        $transport->setPassword(Config::get('smtp.password'));

        $this->mailer = new Swift_Mailer($transport);
    }

    public function send(string $body)
    {
        $mail = new Swift_Message(Config::get('mail.title'));
        $mail->setFrom(Config::get('mail.from'));
        $mail->setTo(Config::get('mail.to'));

        $mail->setBody($body, 'text/html');

        $this->mailer->send($mail);
    }
}