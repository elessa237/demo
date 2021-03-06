<?php

namespace App\Repository;

use App\Entity\Articles;
use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @author Elessa <elessaspirite@icloud.com>
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function LastTree()
    {
        return $this->query()
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findAllArticlesInCategorie(Categorie $id): array
    {
        return $this->query()
            ->where(':categorie MEMBER OF a.categorie')
            ->setParameter('categorie', $id)
            ->getQuery()
            ->getResult();
    }


    public function findAllArticle() : array
    {
        return $this->query()
            ->getQuery()
            ->getResult();
    }

    private function query()
    {
         return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC');
    }
    // /**
    //  * @return Articles[] Returns an array of Articles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articles
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
