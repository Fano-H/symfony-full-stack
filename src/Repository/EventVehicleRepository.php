<?php

namespace App\Repository;

use App\Entity\EventVehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventVehicle>
 *
 * @method EventVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventVehicle[]    findAll()
 * @method EventVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventVehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventVehicle::class);
    }

    //    /**
    //     * @return EventVehicle[] Returns an array of EventVehicle objects
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

    //    public function findOneBySomeField($value): ?EventVehicle
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
