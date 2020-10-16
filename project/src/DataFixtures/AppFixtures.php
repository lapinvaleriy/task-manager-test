<?php

namespace App\DataFixtures;

use App\Entity\User\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 4; $i++) {
            $user = new User();
            $user->setName("user_$i");
            $user->setEmail("user$i@test.com");

            $manager->persist($user);
        }

        $manager->flush();
    }
}