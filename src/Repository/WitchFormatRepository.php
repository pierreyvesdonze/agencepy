<?php

namespace App\Repository;

use App\Entity\WitchFormat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WitchFormat|null find($id, $lockMode = null, $lockVersion = null)
 * @method WitchFormat|null findOneBy(array $criteria, array $orderBy = null)
 * @method WitchFormat[]    findAll()
 * @method WitchFormat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WitchFormatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WitchFormat::class);
    }

    // /**
    //  * @return WitchFormat[] Returns an array of WitchFormat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WitchFormat
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
