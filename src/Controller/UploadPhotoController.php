<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Achievement;
use App\Service\RandomPlant;
use App\Form\AchievementType;
use App\Service\ImageLocation;
use App\Service\LevelCalculator;
use App\Repository\UserRepository;
use App\Repository\PlantRepository;
use App\Repository\AchievementRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadPhotoController extends AbstractController
{
    #[Route('/test', name: 'app_upload_photo')]
    public function index(UserRepository $repoUser, LevelCalculator $levelCalculator ,PlantRepository $repoPlant, AchievementRepository $repoAchievement, Request $request, SluggerInterface $slugger, ImageLocation $location): Response
    {
        $user = $repoUser->findOneBy(['id' => 6]);

        $userLevel = $levelCalculator->getLevel($user->getExperience());

        $criteria = new Criteria();
        $criteria->where(Criteria::expr()->lte('Level', $userLevel));

        $listPlant = $repoPlant->matching($criteria);

        //$listPlant = $repoPlant->findBy(['Level' => $userLevel]);

        $indexChosedPlant = rand(0, count($listPlant) - 1);
        $plant = $listPlant[$indexChosedPlant];
        

        $achievement = new Achievement();
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->get('yes')->isClicked()){
            $plantPicture =  $form->get('file')->getData();
            if ($plantPicture) {

                $originaleFilename = pathinfo($plantPicture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originaleFilename);
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $plantPicture->guessExtension();

                try {
                    $plantPicture->move($this->getParameter('app.path.achievement_picture'), $newFileName);
                    $achievement->setFileName($newFileName);
                } catch (FileException $e) {
                    return $this->render('error.html.twig', [
                        'message' => 'Une erreur est survenue pendant l\'upload de l\'image',
                        'url' => '/character/new',
                        'urlname' => 'réessayer'
                    ]);
                }
                $imagepos = $location->get_image_location($this->getParameter('app.path.achievement_picture') . "/" . $newFileName);
                
                
                $achievement->setLatitude($imagepos['latitude']);
                $achievement->setLongitude($imagepos['longitude']);
                $achievement->setCreatedAt(new \DateTime());
                $achievement->setPlant($plant);
                $achievement->setUser($user);
                
                $repoAchievement->save($achievement, true);

                //$message = "wrong answer";
                //echo "<script type='text/javascript'>alert('$message');</script>";

            }
        }

        //$plantPicture = $this->$form->get('PlantPicture')->getData();
/*
        if ($plantPicture){
            
        }

        if ($form->isSubmitted() && $form->isValid()){

        }else{
            
        }
*/
        

        return $this->render('upload_photo/index.html.twig', [
            'AchievementForm' => $form->createView(),
            'Plant' => $plant,
            'PlantPicturePath' => "/uploads/images/plant" . "/",
            'HintLogoPath' => "/uploads/images/hint" . "/",
            'AnswerLogoPath' => "/uploads/images/answer" . "/",
            'AchievementLogoPath' => "/uploads/images/achievement" . "/",
            
        ]);
    }

    
}