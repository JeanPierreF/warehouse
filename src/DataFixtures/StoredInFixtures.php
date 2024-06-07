<?php

namespace App\DataFixtures;

use App\Entity\StoredIn;
use App\Services\FindCellFree;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StoredInFixtures extends Fixture implements DependentFixtureInterface
{
    private $findCellFree;

    public function __construct(FindCellFree $findCellFree)
    {
        $this->findCellFree = $findCellFree;
    }

    public function load(ObjectManager $manager): void
    {

        
        $stored = new StoredIn;

        $freeCell = $this->findCellFree->findFreeStorage('A', 4, 2);

        // $manager->persist($product);

        $manager->flush();
    }
    
    
    public function getDependencies()
    {
        return [ParcelsFixtures::class, StoragesFixtures::class];
    }
}
