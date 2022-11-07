<?php

namespace App\DataFixtures;

use App\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class YearFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dates = ['2019-2022', '2020-2021', '2021-2022'];

        foreach ($dates as $date) {
            $object = (new Year())
                ->setDate($date)
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }
}
