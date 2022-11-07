<?php

namespace App\DataFixtures;

use App\Entity\Hackathon;
use App\Entity\Year;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HackathonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $years = $manager->getRepository(Year::class)->findAll();

        for ($i=0; $i<10; $i++) {
            $object = (new Hackathon())
                ->setName($faker->name)
                ->setDescription($faker->paragraph)
                ->setStartDate($faker->dateTimeBetween('-1 years'))
                ->setYear($faker->randomElement($years))
            ;
            $manager->persist($object);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            YearFixtures::class
        ];
    }
}
