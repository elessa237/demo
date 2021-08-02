<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticlesRepository;
use App\Repository\CategorieRepository;
use App\Utils\ServicePersistance;
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
            'articles' => $articles->findAllArticle(),
        ]);
    }

    /**
     * @Route("/article/create", name="create_article")
     * @Route("/article/{id}/edit", name="edit_article")
     */
    public function edit(Articles $article = null, Request $request, CategorieRepository $categories, ServicePersistance $persist): Response
    {
        if (!$article) {
            $article = new Articles();
        }
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $id = $request->request->get('categorie');
            $persist->persistArticle($data, $id);

            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/create_article.html.twig', [
            'categories' => $categories->findAllCategorie(),
            'ModeCreation' => $article->getId() == null,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     * @author Elessa <elessaspirite@icloud.com>
     */
    public function FunctionName(Articles $article, Request $request, ServicePersistance $persist): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $persist->persistCommentaire($article);

            return $this->redirectToRoute('article_show', ['id' => $article->getId()]);
        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
}
