<?php

namespace App\Repository;

use App\Entity\OrderBackup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderBackup|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderBackup|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderBackup[]    findAll()
 * @method OrderBackup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderBackupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderBackup::class);
    }

    // /**
    //  * @return OrderBackup[] Returns an array of OrderBackup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderBackup
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
