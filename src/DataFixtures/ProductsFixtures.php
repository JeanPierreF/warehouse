<?php

namespace App\DataFixtures;

use App\Entity\Packages;
use App\Entity\Products;
use App\Services\RandomPackages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductsFixtures extends Fixture implements DependentFixtureInterface
{
    private RandomPackages $randomPackagesService;

    public function __construct(RandomPackages $randomPackagesService)
    {
        $this->randomPackagesService = $randomPackagesService;
    }

    public function load(ObjectManager $manager): void
    {   
        $faker = Faker\Factory::create('fr_FR');



        for($pdt = 1; $pdt <= 20; $pdt++){
            
            $product = new Products();
    
            $product->setName($faker->text(20));
    
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
        }



        $manager->flush();
    }

    public function getDependencies()
    {
        return [PackagesFixtures::class];
    }
}
