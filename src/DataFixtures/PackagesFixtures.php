<?php

namespace App\DataFixtures;

use App\Entity\Packages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PackagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $this->createPackage('Carton A', 60, 30, 40, false, 2, 'Secteur A',$manager);
        $this->createPackage('Carton B', 40, 30, 40, true, 1, 'Secteur B',$manager);
        $this->createPackage('Carton C', 60, 30, 20, false, 2, 'Secteur A',$manager);
        $this->createPackage('Carton D', 40, 30, 20, true, 1, 'Secteur B',$manager);

        $manager->flush();
    }

    public function createPackage(string $reference, int $length, int $width, int $height, bool $palletizable, int $occupancy, string $storage, ObjectManager $manager )
    {
        $packages = new Packages();
        $packages->setReference($reference);
        $packages->setLength($length);
        $packages->setWidth($width);
        $packages->setHeight($height);
        $packages->setPalletizable($palletizable);
        $packages->setOccupancy($occupancy);
        $packages->setStorage($storage);

        $manager->persist($packages);

        return $packages;
    }
}
