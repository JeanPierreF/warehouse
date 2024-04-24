<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new Users();

        $user->setEmail('admin@demo.fr');
        $user->setPassword('$2y$13$5L7EgTG/duE9mjIDvB1JbuJD4/ReWzk4rnLvGyQeKjLdOHM3YItE6');
        $user->setActive(true);

        $manager->persist($user);
        $manager->flush();
    }
}
