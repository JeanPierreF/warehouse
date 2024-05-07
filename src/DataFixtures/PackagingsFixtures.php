<?php

namespace App\DataFixtures;

use App\Entity\Packagings;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PackagingsFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    
    public function load(ObjectManager $manager ): void
    {
        $faker = Faker\Factory::create();

        $productRepository = $manager->getRepository(Products::class);

        $products = $productRepository->findAll();


        foreach($products as $product){
            $packaging = new Packagings();

            $packaging->setIdProduct($product);
            $packaging->setIdPackages($product->getIdPackages());
            $packaging->setQuantityMax($faker->numberBetween(10, 200));

            $manager->persist($packaging);
        }


        $manager->flush();
    }

     public function getDependencies()
    {
        return [ProductsFixtures::class, PackagesFixtures::class ];
    }

    public static function getGroups(): array
    {
        return ['packagings'];
    }
}
