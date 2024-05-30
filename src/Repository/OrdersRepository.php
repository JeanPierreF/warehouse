<?php

namespace App\Repository;

use App\Entity\Orders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Orders>
 *
 * @method Orders|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orders|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orders[]    findAll()
 * @method Orders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Orders::class);
    }


        
    /**
     * getOrderList
     *
     * @param  string $sortField
     * @param  string $sortDirection 
     * @return array Returns an array of string
     */
    public function getOrderList($sortField = 'id', $sortDirection = 'asc'):array
    {
        $entityManager = $this->getEntityManager();
    
        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('o.id', 'o.date_order', 'o.supplier_name', 'o.quantity_order', 'p.name as product_name', 'o.delivered_at')
            ->from('App\Entity\Orders', 'o')
            ->leftJoin('o.id_products', 'p');
    
        if ($sortField === 'product_name') {
            $queryBuilder->orderBy('p.name', $sortDirection);
        } else {
            $queryBuilder->orderBy('o.' . $sortField, $sortDirection);
        }
    
        $results = $queryBuilder->getQuery()->getArrayResult();

        return $results;
    }
    
    
    
 


    //    /**
    //     * @return Orders[] Returns an array of Orders objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Orders
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
