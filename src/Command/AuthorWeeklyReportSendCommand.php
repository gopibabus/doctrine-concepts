<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Knp\Snappy\Pdf;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;

class AuthorWeeklyReportSendCommand extends Command
{
    protected static $defaultName = 'app:author-weekly-report:send';
    private $userRepository;
    private $articleRepository;
    private $mailer;
    private $twig;
    private $pdf;

    public function __construct(
        UserRepository $userRepository,
        ArticleRepository $articleRepository,
        Mailer $mailer,
        Environment $twig,
        Pdf $pdf
    )
    {
        parent::__construct(null);
        $this->userRepository = $userRepository;
        $this->articleRepository = $articleRepository;
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->pdf = $pdf;
    }

    protected function configure()
    {
        $this->setDescription('Send Weekly Reports to Authors');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $authors = $this->userRepository->findAllSubscribedToNewsLetter();
        $io->progressStart(count($authors));
        foreach ($authors as $author){
            $io->progressAdvance();
            $articles = $this->articleRepository->findAll();
            if(count($articles) === 0){
                continue;
            }

            $this->mailer->sendAuthorWeeklyReport($author, $articles);
        }
        $io->progressFinish();
        $io->success('Weekly Reports were sent to authors');
    }
}
