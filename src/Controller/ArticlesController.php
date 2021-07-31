<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function FunctionName(Articles $article, Request $request, EntityManagerInterface $manager): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
         
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $commentaire->setCreatedAt(new \DateTime())
                        ->setArticle($article);
            dump($data);

            $manager->persist($commentaire);
            $manager->flush();

            return $this->redirectToRoute('article_show', ['id'=> $article->getId()]);
        }

        return $this->render('articles/show.html.twig', [
            'article'=>$article,
            'form' => $form->createView(),       
        ]);
    }
}
