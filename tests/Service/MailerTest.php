<?php

namespace App\Tests\Service;

use App\Entity\Article;
use App\Entity\User;
use App\Service\Mailer;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class MailerTest extends kernelTestCase
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

    public function testIntegrationSendAuthorWeeklyReportMessage()
    {
        self::bootKernel();

        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects($this->once())->method('send');

        $pdf = self::$container->get(Pdf::class);
        $twig = self::$container->get(Environment::class);

        $user = new User();
        $user->setFirstName('Gopi');
        $user->setEmail('gopi@gmail.com');
        $article = new Article();
        $article->setTitle('Black Hole: Real');

        $mailer = new Mailer($symfonyMailer, $twig, $pdf);
        $email = $mailer->sendAuthorWeeklyReport($user, [$article]);
        $this->assertCount(1, $email->getAttachments());
    }
}
