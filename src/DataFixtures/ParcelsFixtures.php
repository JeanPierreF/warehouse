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

        $qb->select('o.id AS cmdId', 'o.quantity_order AS orderQty', 'pa.occupancy AS occupancy', 'pa.storage AS storage', 'pkg.id AS packId', 'pkg.quantity_max AS qtyMax')
            ->from('App\Entity\Orders', 'o')
            ->leftJoin('App\Entity\Products', 'pdt' ,'WITH', 'o.id_products = pdt.id')
            ->leftJoin('App\Entity\Packages', 'pa', 'WITH', 'pdt.id_packages = pa.id')
            ->leftJoin('App\Entity\Packagings', 'pkg', 'WITH', 'pkg.id_packages = pa.id')
            ->where('o.delivered_at IS NULL')
            ->andWhere('pkg.id_product = o.id_products')
            ->setMaxResults(4);

        return $qb->getQuery()->getResult();
    }
}

