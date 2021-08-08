<?php

namespace App\Controller;

use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @author Elessa <elessaspirite@icloud.com>
     */
    public function index(ArticlesRepository $articles, CategorieRepository $categories): Response
    {

        return $this->render('home/index.html.twig', [
            'articles' => $articles->LastTree(),
            'categories' =>$categories->lastTree(),
        ]);
    }
}
