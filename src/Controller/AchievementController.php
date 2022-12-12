<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AchievementController extends AbstractController
{
    #[Route('/achievement', name: 'app_achievement')]
    public function index(AchievementRepository $repoAchievement): Response
    {

        // TODO récupérer vrai utilisateur
        $userId = 7;

        $listAchievement = $repoAchievement->findBy(["user" => $userId]);

        return $this->render('achievement/index.html.twig', [
            'Achievements' => $listAchievement,
            'AchievementLogoPath' => "/uploads/images/achievement" . "/"
        ]);
    }
}
