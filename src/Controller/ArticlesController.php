<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function articles(ArticlesRepository $articles): Response
    {
        return $this->render('articles/articles.html.twig', [
            'articles' => $articles->findAll(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function FunctionName(): Response
    {
        return $this->render('articles/show.html.twig', []);
    }
}
