<?php

namespace App\Components;

use App\Repository\HintRepository;
use App\Repository\PlantRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('all_hints')]
class AllHintComponents
{
    public int $id;

    public function __construct(
        private HintRepository $hintRepo
    )
    {}

    public function getAllHints(): array
    {
        return $this->hintRepo->findAll();
    }
}