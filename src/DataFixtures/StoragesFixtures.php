<?php

namespace App\DataFixtures;

use App\Entity\Storages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class StoragesFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        //Emplacements type A (long)

        for($cell = 1; $cell <=1000; $cell++){

            for($rank = 1; $rank <= 4; $rank++ ){

                $cells = new Storages();
    
                $cells->setType('A');
                $cells->setEmplacement('A-'.$cell.'-'.$rank);
                $cells->setQuantity(2);
    
                $manager->persist($cells);

            }
        }

        //Emplacements type B (short)

        for($cell = 1; $cell <=1000; $cell++){

            for($rank = 1; $rank <= 4; $rank++ ){

                $cells = new Storages();
    
                $cells->setType('B');
                $cells->setEmplacement('B-'.$cell.'-'.$rank);
                $cells->setQuantity(2);
    
                $manager->persist($cells);

            }
        }


        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['STORAGES'];
    }
}
