<?php

namespace App\DataFixtures;

use App\Entity\Products;
use App\Services\RandomPackages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{
    private RandomPackages $randomPackagesService;

    public function __construct(RandomPackages $randomPackagesService)
    {
        $this->randomPackagesService = $randomPackagesService;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer un produit avec un nom factice
        $product = new Products();
        $product->setName('Example Product');

        // Obtenir un ID de carton aléatoire à partir du service
        $randomPackageId = $this->randomPackagesService->getRandomPackagesId();

        if ($randomPackageId !== null) {
            $product->setIdPackages($randomPackageId);
        } else {
            // Gérer le cas où aucun carton n'est disponible
            throw new \RuntimeException('No packages available to assign to product');
        }


        //$manager->persist($product);

        //$manager->flush();
    }
}
