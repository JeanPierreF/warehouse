<?php

namespace App\Repository;

use App\Entity\Packagings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Packagings>
 *
 * @method Packagings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Packagings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Packagings[]    findAll()
 * @method Packagings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PackagingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Packagings::class);
    }

//    /**
//     * @return Packagings[] Returns an array of Packagings objects
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

//    public function findOneBySomeField($value): ?Packagings
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
