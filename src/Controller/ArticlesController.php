<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommentaireRepository;
use App\Utils\ServicePersistance;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function articles(ArticlesRepository $articleRepository, PaginatorInterface $pagination, Request $request): Response
    {
        $articleRepository = $articleRepository->findAllArticle();
        $articles = $pagination->paginate($articleRepository, $request->query->getInt('page', 1), 8);
        return $this->render('articles/articles.html.twig', [
            'articles' => $articles,
            'current_menu' => 'articles',
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @author Elessa <elessaspirite@icloud.com>
     */
    public function show(Articles $article, Request $request, ServicePersistance $persist, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $id = $article;
            $persist->persistCommentaire($id, $data);

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'commentaires' => $commentaireRepository->findAllComments($article),
        ]);
    }
}
