<?php

namespace App\Controller;

use App\Repository\AchievementRepository;
use App\Repository\PlantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnswerController extends AbstractController
{
    #[Route('/answer', name: 'app_answer')]
    public function index(Request $request, AchievementRepository $repoAchievement, PlantRepository $repoPlant): Response
    {
        $idPlant = $request->request->get("idPlant");
        echo "<script>console.log('Debug Objects: " . $idPlant . "' );</script>";

        $user = $this->getUser();
        //$achievement = $repoAchievement->findOneBy(array('plant' => $idPlant, 'user' => $user->getId()));
        $plant = $repoPlant->findOneBy(["id" => $idPlant]);

        return $this->render('answer/index.html.twig', [
            //'Achievement' => $achievement,
            'Plant' => $plant,
            'User' => $user,
            'PlantPicturePath' => $this->getParameter("app.path.plant_picture") . "/",
            'AnswerLogoPath' => $this->getParameter('app.path.answer_logo') . "/"
        ]);
    }
}
