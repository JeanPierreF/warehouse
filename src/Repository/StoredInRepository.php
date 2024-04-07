<?php

namespace App\Repository;

use App\Entity\StoredIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StoredIn>
 *
 * @method StoredIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoredIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoredIn[]    findAll()
 * @method StoredIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoredInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoredIn::class);
    }

    //    /**
    //     * @return StoredIn[] Returns an array of StoredIn objects
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

    //    public function findOneBySomeField($value): ?StoredIn
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
