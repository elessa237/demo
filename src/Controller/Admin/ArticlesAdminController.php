<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

/**
 * @Route("/admin/articles")
 */
class ArticlesAdminController extends AbstractController
{
    /**
     * @Route("/", name="articles_index", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository, PaginatorInterface $pagination, Request $request): Response
    {
        $articles = $pagination->paginate(
            $articlesRepository->findAllArticle(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/articles/index.html.twig', [
            'articles' => $articles,
            'current_page' => 'articles',
        ]);
    }

    /**
     * @Route("/new", name="articles_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime('now'));
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('articles_index');
        }

        return $this->render('admin/articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="articles_show", methods={"GET"})
     */
    public function show(Articles $article): Response
    {
        return $this->render('admin/articles/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}", name="articles_delete", methods={"POST"})
     */
    public function delete(
        Request $request,
        Articles $article,
        EntityManagerInterface $manager,
        CacheManager $cacheManager,
        UploaderHelper $helper
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            
            $cacheManager->remove($helper->asset($article, 'imageFile'));

            $manager->remove($article);
            $manager->flush();
        }

        return $this->redirectToRoute('articles_index');
    }
}
