<?php

namespace App\Components;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('user_level')]
class UserLevelComponent
{
    public int $id;

    public function __construct(private UserRepository $userRepo)
    {}

    public function getExperience(): User
    {
        return $this->userRepo->find($this->id);
    }
}