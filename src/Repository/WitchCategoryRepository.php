<?php

namespace App\Repository;

use App\Entity\WitchCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WitchCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method WitchCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method WitchCategory[]    findAll()
 * @method WitchCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WitchCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WitchCategory::class);
    }

    /**
     * @return WitchCategory[] Returns an array of WitchCategory objects
     */

    public function findByCategory($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.witchProductCategoryId = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
