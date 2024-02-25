<?php

namespace App\Repository;

use App\Entity\SaleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SaleType>
 *
 * @method SaleType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SaleType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SaleType[]    findAll()
 * @method SaleType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SaleType::class);
    }

    //    /**
    //     * @return SaleType[] Returns an array of SaleType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SaleType
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
