<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Products();

        $product->setName('');
        $product->setIdPackages($product->getId());

        // $manager->persist($product);

        $manager->flush();
    }
}
