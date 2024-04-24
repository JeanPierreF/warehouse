<?php

namespace App\DataFixtures;

use App\Entity\Packages;
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
        $product = new Products();
        $product->setName('Example Product');

        $randomPackageId = $this->randomPackagesService->getRandomPackagesId();

        if ($randomPackageId !== null) {
            $randomPackage = $manager->getRepository(Packages::class)->find($randomPackageId);

            if ($randomPackage !== null) {
                $product->setIdPackages($randomPackage);
            } else {
                throw new \RuntimeException('Package not found with ID: ' . $randomPackageId);
            }
        } else {
            throw new \RuntimeException('No packages available to assign to product');
        }

        $manager->persist($product);
        $manager->flush();
    }
}
