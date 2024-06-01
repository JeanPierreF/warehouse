<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Products>
 *
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }


    public function findProductsWithPackage($sortField = 'id', $sortDirection = 'asc')
    {
        try {
            $query = $this->createQueryBuilder('p')
                ->select('p.id', 'p.name', 'p.created_at', 'pkg.reference as package_reference')
                ->leftJoin('p.id_packages', 'pkg');

                if ($sortField === 'package_reference') {
                    $query->orderBy('pkg.reference', $sortDirection);
                } else {
                    $query->orderBy('p.' . $sortField, $sortDirection);
                }
                
            return $query->getQuery()->getResult();
        } catch (\Exception $e) {
            // Gérer l'exception ici
            $this->addFlash('danger',$e->getMessage(), "\n");
        }
    }


}
