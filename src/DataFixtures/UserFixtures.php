<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // PWD = test
        $pwd = '$2y$13$wiWVplNfdpwyWjWFdTtY..TQvVVHDVkv/PEUtf7dSlvmC2KiqlJHq';

        $object = (new User())
            ->setEmail('user@user.fr')
            ->setPassword($pwd)
            ->setRoles([])
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('admin@user.fr')
            ->setPassword($pwd)
            ->setRoles(["ROLE_ADMIN"])
        ;
        $manager->persist($object);

        $object = (new User())
            ->setEmail('coach@user.fr')
            ->setPassword($pwd)
            ->setRoles(["ROLE_COACH"])
        ;
        $manager->persist($object);

        $manager->flush();
    }
}
