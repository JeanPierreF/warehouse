<?php

namespace App\DataFixtures;

use App\Entity\Orders;
use App\Entity\Products;
use App\Services\RandomProducts;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class OrdersFixtures extends Fixture implements DependentFixtureInterface
{
    private RandomProducts $randomProductsService;

    public function __construct(RandomProducts $randomProductsService)
    {
        $this->randomProductsService = $randomProductsService;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($ordr = 1; $ordr <= 50; $ordr++){
            $order = new Orders;

            /* $order->setDateOrder(new \DateTimeImmutable); */
            $order->setSupplierName($faker->company());

            $randomProductsId = $this->randomProductsService->getRandomPackagesId();

            if ($randomProductsId !== null){

                $randomProducts = $manager->getRepository(Products::class)->find($randomProductsId);

                if ($randomProducts !== null) {
                    $order->setIdProducts($randomProducts);
                } else {
                    throw new \RuntimeException('Product not found with ID: ' . $randomProductsId);
                }
            } else {
                throw new \RuntimeException('No Product available to assign to Orders');
            }

            $order->setQuantityOrder($faker->numberBetween(10, 200));

            $manager->persist($order);
        }

        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProductsFixtures::class];
    }
}
