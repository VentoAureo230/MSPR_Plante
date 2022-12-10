<?php

namespace App\Components;

use App\Entity\Plant;
use App\Repository\PlantRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('plant')]
class PlantComponent
{
    public int $id;

    public function __construct(
        private PlantRepository $plantRepository
    )
    {
        
    }

    public function getPlant(): Plant
    {
        return $this->plantRepository->find($this->id);
    }
}