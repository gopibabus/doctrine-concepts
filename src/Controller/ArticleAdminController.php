<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     * @param EntityManagerInterface $em
     * @param Request                $request
     * @return Response
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            /** @var Article $article */
            $article = $form->getData();
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article is created 😀');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit")
     * @IsGranted("MANAGE", subject="article")
     * @param Article $article
     */
    public function edit(Article $article)
    {
        if (!$this->isGranted('MANAGE', $article)) {
            throw $this->createAccessDeniedException('No Access!!');
        }

        // Manually verifying the user
        // $this->denyAccessUnlessGranted('MANAGE', $article);

        //TODO: This will be replaced by Symfony Forms
        dd($article);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     * @param ArticleRepository $articleRepo
     * @return Response
     */
    public function list(ArticleRepository $articleRepo): Response
    {
        $articles = $articleRepo->findAll();

        return $this->render('article_admin/list.html.twig', [
           'articles' => $articles
        ]);
    }
}
