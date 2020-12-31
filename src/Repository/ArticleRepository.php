<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article
     */
    public function findByFormatAndUserCart($cart, $witchFormat)
    {
        return $this->createQueryBuilder('a')
            ->where('a.cart = :valCart')
            ->having('a.witchFormatId = :valFormatId')
            ->setParameter('valCart', $cart)
            ->setParameter('valFormatId', $witchFormat)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    public function countNbProducts($cart): int
    {
        $articles = $this->createQueryBuilder('a')
            ->select('SUM(a.quantity) AS totalQuantity')
            ->where('a.cart = :cart')
            ->setParameter('cart', $cart)
            ->getQuery()
            ->getResult();

        if (null !== $articles) {
            if (null != $articles[0]['totalQuantity']) {
                return $articles[0]['totalQuantity'];
            }
        }

        return 0;
    }

    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
