<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     * @author Elessa <elessaspirite@icloud.com>
     */
    public function categorie(CategorieRepository $categories): Response
    {
        return $this->render('categorie/categories.html.twig', [
            'categories' => $categories->findAllCategorie(),
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie_show_article")
     */
    public function show(Categorie $categories, ArticlesRepository $articlesRepository): Response
    {
        return $this->render('categorie/categorie_show.html.twig', [
            'articles' => $articlesRepository->findAllArticlesInCategorie($categories),
            'categorie'=> $categories
        ]);
    }
}
