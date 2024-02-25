<?php

namespace App\Repository;

use App\Entity\ProspectType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProspectType>
 *
 * @method ProspectType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProspectType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProspectType[]    findAll()
 * @method ProspectType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProspectType::class);
    }

    //    /**
    //     * @return ProspectType[] Returns an array of ProspectType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProspectType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
