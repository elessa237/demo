<?php

namespace App\Controller;

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
            'categories' => $categories->findAll(),
        ]);
    }
}
