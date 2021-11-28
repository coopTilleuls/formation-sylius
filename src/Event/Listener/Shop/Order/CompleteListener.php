<?php

namespace App\Event\Listener\Shop\Order;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class CompleteListener
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(ResourceControllerEvent $event): void
    {
        $email = (new Email())
            ->from(new Address('test@test.com', 'JohnTest'))
            ->to('admin@admin.com')
            ->subject('test')
            ->html('test')
        ;

        $this->mailer->send($email);
    }
}
