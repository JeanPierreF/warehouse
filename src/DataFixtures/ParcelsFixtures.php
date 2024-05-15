<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Parcels;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

use function PHPUnit\Framework\isEmpty;

class ParcelsFixtures extends Fixture implements DependentFixtureInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager): void
    {
        
        $orderRepository = $manager->getRepository(Orders::class);

        $orders = $orderRepository->findBy( [], ['id' => 'ASC'], $limit = 4, $offset = null);
        
        
        $parcel = new Parcels();



        $results = $this->getDataParcel();

        $qtyMax = $results['qtyMax'];
        $orderQty = $results['orderQty'];


        // Calcul du nombre de cartons par rapport à la quantité commandée et au nombre de produits en emballage standard
        if (!isEmpty($qtyMax) && $qtyMax !== 0){
            $numberOfParcels = floor($orderQty / $qtyMax);
        }else{
            // traitement erreur
        }

        // Modulo pour rechercher si il faut créer un carton avec le reste des produits
        $finishParcel = $orderQty % $qtyMax;

        if ($finishParcel > 0){
            $totalOfParcels = $numberOfParcels++ ;
        }else{
            $totalOfParcels = $numberOfParcels; 
        }




    
        $manager->flush();
    }

    public function getDependencies()
    {
        return [OrdersFixtures::class, PackagingsFixtures::class];
    }

    public function getDataParcel()
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('o.id AS cmdId', 'o.quantity_order AS   ', 'p.name AS pdtName', 'pa.reference AS refParcel', 'pa.occupancy AS occupancy', 'pa.storage AS storage','pack.id AS packId' ,'pack.quantity_max AS qtyMax')
           ->from('App\Entity\Orders', 'o')
           ->leftJoin('App\Entity\Products', 'p', 'WITH', 'o.id_products = p.id')
           ->leftJoin('App\Entity\Packages', 'pa', 'WITH', 'p.id_packages = pa.id')
           ->leftJoin('App\Entity\Packagings', 'pack', 'WITH', 'pack.id_packages = pa.id')
           ->where('o.delivered_at IS NULL')
           ->andWhere('pack.id_product = o.id_products')
           ->setMaxResults(4);

        $query = $qb->getQuery();

        return $query->getResult();
    }
}
