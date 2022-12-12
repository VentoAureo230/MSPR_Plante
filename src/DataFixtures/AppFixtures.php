<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Plant;
use App\Entity\Hint;
use App\Entity\Picture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = 'src\DataFixtures\Ressources\data.json';
        $json = file_get_contents($data);
        $decoded = array_values(json_decode($json,true));

        foreach ($decoded as $results) {
            $plante = new Plant();
            $plante->setName($results['name']);
            $plante->setLevel($results['level']);
            $plante->setIsEnableForUser(true);
            $plante->setIsEnable(true);
            $manager->persist($plante);
            
            // Managing photo storage
            $photo = $results['photos'];
            foreach ($photo as $value) {
                for ($i=0; $i < count($photo) ; $i++) { 
                    $pict = new Picture();
                    $pict->setFileName($photo[$i]);
                    $pict->setPlant($plante);
                }
                $manager->persist($pict);
            }
            
            // Managing the before array
            $before = $results['before'];
            foreach ($before as $value) {
                $hint = new Hint();
                $hint->setText($value['text']);
                $hint->setPlante($plante);
                $manager->persist($hint);
            }

            // Managing the after array
            $after = $results['after'];
            foreach ($after as $value) {
                $answer =  new Answer();
                $answer->setText($value['text']);
                if (isset($value['title'])) {
                    $answer->setTitle($value['title']);
                }
                if (isset($value['logo'])) {
                    $answer->setLogo($value['logo']);
                }
                $answer->setPlante($plante);
                $manager->persist($answer);
            }
        }
        $manager->flush();
    }
}
