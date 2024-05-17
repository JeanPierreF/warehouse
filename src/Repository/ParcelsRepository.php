<?php

namespace App\Repository;

use App\Entity\Parcels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parcels>
 *
 * @method Parcels|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcels|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcels[]    findAll()
 * @method Parcels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcels::class);
    }

    public function parcelsList(): array
    {
        // Création du QueryBuilder
        $queryBuilder = $this->createQueryBuilder('parcels');

        // Construction de la requête
        $queryBuilder
            ->select('parcels.id AS parcelId', 'packages.occupancy AS occupancy', 'packages.storage AS package')
            ->leftJoin('App\Entity\Packagings', 'packagings', 'WITH', 'parcels.id_packagings = packagings.id')
            ->leftJoin('App\Entity\Packages', 'packages', 'WITH', 'packagings.id_packages = packages.id')
            ->orderBy('parcelId', 'ASC');
        
        // Exécution de la requête et retour du résultat
        return $queryBuilder->getQuery()->getResult();
    }

    //    /**
    //     * @return Parcels[] Returns an array of Parcels objects
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

    //    public function findOneBySomeField($value): ?Parcels
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
