<?php

namespace App\Repository;

use App\Entity\EventOrigin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventOrigin>
 *
 * @method EventOrigin|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventOrigin|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventOrigin[]    findAll()
 * @method EventOrigin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventOriginRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventOrigin::class);
    }

    //    /**
    //     * @return EventOrigin[] Returns an array of EventOrigin objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EventOrigin
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
