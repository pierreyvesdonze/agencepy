<?php

namespace App\Repository;

use App\Entity\PostOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostOrder[]    findAll()
 * @method PostOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostOrder::class);
    }

    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :val')
            ->setParameter('val', $user)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
