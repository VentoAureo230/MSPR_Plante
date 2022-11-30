<?php

namespace App\DataFixtures;

use App\Entity\Plant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i <10; $i++) {
            $plante = new Plant();

            $plante->setName($faker->firstName);
            $plante->setLevel($faker->numberBetween($min = 1, $max = 15));
            $plante->setIsEnableForUser($faker->boolean);
            $plante->setIsEnable($faker->boolean);

            $manager->persist($plante);
        };

        $manager->flush();
    }
}
