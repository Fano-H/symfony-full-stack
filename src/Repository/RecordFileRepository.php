<?php

namespace App\Repository;

use App\Entity\RecordFile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecordFile>
 *
 * @method RecordFile|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecordFile|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecordFile[]    findAll()
 * @method RecordFile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecordFileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecordFile::class);
    }

    //    /**
    //     * @return RecordFile[] Returns an array of RecordFile objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RecordFile
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
