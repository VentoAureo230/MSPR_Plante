<?php

namespace App\Components;

use App\Entity\Plant;
use App\Repository\PlantRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('all_plant')]
class AllPlantComponents
{
    public int $id;

    public function __construct(
        private PlantRepository $plantRepository
    )
    {
        
    }

    public function getAllPlant(): array
    {
        return $this->plantRepository->findAll();
    }
}