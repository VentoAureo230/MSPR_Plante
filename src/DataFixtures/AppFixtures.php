<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Hint;
use App\Entity\User;
use App\Entity\Plant;
use App\Entity\Answer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        # $faker = Factory::create('fr_FR');
        $string = file_get_contents(dirname(__FILE__).'/Ressources/data.json');
        $plante = json_decode($string, true);
        
        $name->name();

        $manager->persist($plante);
        $manager->flush();
        # for ($i=0; $i <10; $i++) {
            # $plante = new Plant();

            # $plante->setName($faker->firstName);
            # $plante->setLevel($faker->numberBetween($min = 1, $max = 15));
            # $plante->setIsEnableForUser($faker->boolean);
            # $plante->setIsEnable($faker->boolean);

            # $manager->persist($plante);
        # };

        # for ($i=0; $i <10; $i++) {
            #$user = new User();

        #    #$user->setFirstname($faker->firstName);
        #    #$user->setLastname($faker->numberBetween($min = 1, $max = 15));
        #    #$user->setEmail($faker->freeEmail());
        #    #$user->setRoles(['ROLE_USER']);
        #    #$user->setExperience($faker->numberBetween($min = 1, $max = 80));
        #    #$user->setPassword($faker->password(4,10));
        #    
        #    $manager->persist($user);
        #};
            
        # for ($i=0; $i <10; $i++) {
            # $hint = new Hint();

            # $hint->setText($faker->text());
            # $hint->setLogo($faker->imageUrl(200, 400, 'plante', true));

            # $manager->persist($hint);
        # };

        # for ($i=0; $i <10; $i++) {
           #  $answer = new Answer();

            # $answer->setTitle($faker->title());
            # $answer->setText($faker->text());
           #  $answer->setLogo($faker->imageUrl(200, 400, 'plante', true));
           #  $answer->setPlante($faker->);
            
           #  $manager->persist($answer);
        # };
    }
}
