<?php

namespace App\Mail\Adapter;

use Sylius\Component\Mailer\Model\EmailInterface;
use Sylius\Component\Mailer\Renderer\RenderedEmail;
use Sylius\Component\Mailer\Sender\Adapter\AdapterInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerAdapter implements AdapterInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(
        array $recipients,
        string $senderAddress,
        string $senderName,
        RenderedEmail $renderedEmail,
        EmailInterface $email,
        array $data,
        array $attachments = [],
        array $replyTo = []
    ): void {
        $email = (new Email())
            ->from(new Address($senderAddress, $senderName))
            ->to(...$recipients)
            ->subject($renderedEmail->getSubject())
            ->html($renderedEmail->getBody())
        ;

        foreach ($attachments as $attachment) {
            $email->attach($attachment);
        }
        $this->mailer->send($email);
    }
}
