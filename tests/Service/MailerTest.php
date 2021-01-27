<?php

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\Mailer;
use Knp\Snappy\Pdf;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class MailerTest extends TestCase
{
    public function testSendWelcomeMessage()
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())->method('send');

        $pdf = $this->createMock(Pdf::class);
        $twig = $this->createMock(Environment::class);

        $user = new User();
        $user->setFirstName('Gopi');
        $user->setEmail('gopi@gmail.com');

        $mailer = new Mailer($symfonyMailer, $twig, $pdf);
        $email = $mailer->sendWelcomeMessage($user);

        $this->assertSame('Welcome to Spacebar', $email->getSubject());
        $this->assertCount(1, $email->getTo());

        $address = $email->getTo();
        $this->assertInstanceOf(Address::class, $address[0]);
        $this->assertSame('Wonderful User', $address[0]->getName());
        $this->assertSame('gopi@gmail.com', $address[0]->getAddress());
    }
}
