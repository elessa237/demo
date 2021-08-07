<?php

namespace App\Utils;

use App\Entity\Articles;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServicePersistance
{
    public function __construct(EntityManagerInterface $manager, CategorieRepository $categorieRepository)
    {
        $this->manager = $manager;
        $this->categorieRepository = $categorieRepository;
    }

    public function persistArticle(Articles $article, $id): void
    {
    
        if (!$article->getId()) 
        {
            $categorie = new Categorie();
            $categorie = $this->categorieRepository->findOneBy(['id' => $id]);
            $article->addCategorie($categorie);
            // $article->setCreatedAt(new \DateTime('now'));
        }


        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function persistCommentaire(Articles $id, Commentaire $commentaire)
    {

        $commentaire->setCreatedAt(new \DateTime('now'))
            ->setArticle($id);

        $this->manager->persist($commentaire);
        $this->manager->flush();
    }

}