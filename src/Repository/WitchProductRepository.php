<?php

namespace App\Repository;

use App\Entity\WitchProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WitchProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method WitchProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method WitchProduct[]    findAll()
 * @method WitchProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WitchProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WitchProduct::class);
    }

    /**
     * @return Witch[] Returns an array of Witch objects
     */
    public function findProductByName($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.name LIKE :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
