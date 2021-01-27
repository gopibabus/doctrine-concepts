<?php
namespace App\Service;

use App\Entity\User;
use Knp\Snappy\Pdf;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Twig\Environment;

class Mailer
{
    private $mailer;
    private $twig;
    private $pdf;

    public function __construct(MailerInterface $mailer, Environment $twig, Pdf $pdf)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    public function sendWelcomeMessage(User $user): TemplatedEmail
    {
        $email = (new TemplatedEmail())
            ->from(new Address('s.gopibabu@gmail.com', 'Gopibabu'))
            ->to(new Address($user->getEmail(), 'Wonderful User'))
            ->subject('Welcome to Spacebar')
            ->htmlTemplate('email/welcome.html.twig')
            ->context(['user' =>$user]);
        $this->mailer->send($email);

        return $email;
    }

    public function sendAuthorWeeklyReport(User $author, array $articles): TemplatedEmail
    {
        $html = $this->twig->render('email/author-weekly-report-pdf.html.twig', [
            'articles' => $articles
        ]);
        $pdf = $this->pdf->getOutputFromHtml($html);

        $email = (new TemplatedEmail())
            ->from(new Address('s.gopibabu@gmail.com', 'Gopibabu'))
            ->to(new Address($author->getEmail(), 'Wonderful User'))
            ->subject('Your weekly Report on Spacebar')
            ->htmlTemplate('email/author-weekly-report.html.twig')
            ->context([
                'author' =>$author,
                'articles' => $articles
            ])
            ->attach($pdf, sprintf('weekly-report-%s.pdf', date('Y-m-d')));
        $this->mailer->send($email);

        return $email;
    }
}