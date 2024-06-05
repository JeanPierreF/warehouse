<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Packagings;
use App\Entity\Parcels;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ParcelsFixtures extends Fixture implements DependentFixtureInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create();
        $results = $this->getDataParcel();

        try{        
            
            foreach ($results as $result) {
                $qtyMax = $result['qtyMax'];
                $orderQty = $result['orderQty'];

                if ($qtyMax === 0) {
                    continue; // Skip if qtyMax is zero to avoid division by zero
                }

                // Calculate the number of fully filled packages
                $numberOfParcels = intdiv($orderQty, $qtyMax);

                // Check if there are any remaining products and add a package if necessary
                $finishParcelQty = $orderQty % $qtyMax;
                $totalOfParcels = $finishParcelQty > 0 ? $numberOfParcels + 1 : $numberOfParcels;

                for ($parcelNum = 1; $parcelNum <= $totalOfParcels; $parcelNum++) {
                    $parcel = new Parcels();
                    $quantity = ($finishParcelQty > 0 && $parcelNum == $totalOfParcels) ? $finishParcelQty : $qtyMax;

                    $parcel->setQuantity($quantity);
                    $parcel->setIdOrder($this->em->getRepository(Orders::class)->find($result['cmdId']));
                    $parcel->setIdPackagings($this->em->getRepository(Packagings::class)->find($result['packId']));
                    $parcel->setEancode($faker->ean13());

                    $manager->persist($parcel);
                }
            }

            $manager->flush();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getDependencies()
    {
        return [OrdersFixtures::class, PackagingsFixtures::class];
    }

    public function getDataParcel()
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('o.id AS cmdId', 'o.quantity_order AS orderQty', 'p.name AS pdtName', 'pa.reference AS refParcel', 'pa.occupancy AS occupancy', 'pa.storage AS storage', 'pack.id AS packId', 'pack.quantity_max AS qtyMax')
            ->from('App\Entity\Orders', 'o')
            ->leftJoin('App\Entity\Products', 'p', 'WITH', 'o.id_products = p.id')
            ->leftJoin('App\Entity\Packages', 'pa', 'WITH', 'p.id_packages = pa.id')
            ->leftJoin('App\Entity\Packagings', 'pack', 'WITH', 'pack.id_packages = pa.id')
            ->where('o.delivered_at IS NULL')
            ->andWhere('pack.id_product = o.id_products')
            ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }
}


/* new sql
SELECT o.id, o.quantity_order, p.occupancy, p.storage, pkg.id, pkg.quantity_max
FROM `orders` as o
	LEFT JOIN `products` ON o.`id_products_id` = `products`.`id` 
	LEFT JOIN `packages` AS p ON `products`.`id_packages_id` = p.`id` 
	LEFT JOIN `packagings` As pkg ON pkg.`id_packages_id` = p.`id`
    
WHERE pkg.id_product_id = o.id_products_id AND o.delivered_at IS NULL
ORDER BY o.id; */