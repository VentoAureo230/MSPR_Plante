<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use App\Repository\PlantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AchievementController extends AbstractController
{
    #[Route('/achievement', name: 'app_achievement')]
    public function index(AchievementRepository $repoAchievement): Response
    {
        $userId = $this->getUser();
        $listAchievement = $repoAchievement->findBy(["user" => $userId]);

        return $this->render('achievement/index.html.twig', [
            'Achievements' => $listAchievement,
            'AchievementLogoPath' => "/uploads/images/achievement" . "/"
        ]);
    }
    
    #[Route('/achievement/{id}', name: 'app_achievement_show')]
    public function show($id,AchievementRepository $repoAchievement, PlantRepository $repoPlant): Response
    {
        $idPlant = $id;

        $user = $this->getUser();
        $achievement = $repoAchievement->findOneBy(array('plant' => $idPlant, 'user' => $user->getId()));
        $plant = $repoPlant->findOneBy(["id" => $idPlant]);

        return $this->render('achievement/show.html.twig', [
            //'Achievement' => $achievement,
            'Plant' => $plant,
            'User' => $user,
            'Achievement' => $achievement,
            'PlantPicturePath' => $this->getParameter("app.path.plant_picture") . "/",
            'AnswerLogoPath' => $this->getParameter('app.path.answer_logo') . "/",
            'AchievementPicturePath' => $this->getParameter('app.path.achievement_picture') . "/"
        ]);
    }

    #[Route('/achievement/delete/{id}', name: 'app_achievement_delete')]
    public function delete($id,AchievementRepository $repoAchievement, PlantRepository $repoPlant): Response
    {
        $idPlant = $id;

        $userId = $this->getUser()->getId();
        

        $achievement = $repoAchievement->findOneBy(array('plant' => $idPlant, 'user' => $userId));
        
        $repoAchievement->remove($achievement, true);
        

        return $this->redirectToRoute('app_achievement');

    }
}