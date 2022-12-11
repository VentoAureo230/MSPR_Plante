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
        // TODO récupérer vrai utilisateur
        //$user = $repoUser->findOneBy(['id' => 7]);
        $user = $this->getUser();
        $plant = null;

        $userLevel = $levelCalculator->getLevel($user->getExperience());

        $criteria = new Criteria();
        $criteria->where(Criteria::expr()->lte('Level', $userLevel));

        $listPlant = $repoPlant->matching($criteria);
        $userId = $user->getId();
        $listAchievement = $repoAchievement->findBy(['user' => $userId]);

        /*
        foreach ($listPlant as $PlantToRemove) {
            foreach($listAchievement as $achievementAlreadyAchived){
                if ($PlantToRemove->getId() == $achievementAlreadyAchived->getPlant()->getId()){
                    
                    $listPlant->removeElement($PlantToRemove);
                }
            }
        }*/

        //$listPlant = $repoPlant->findBy(['Level' => $userLevel]);

        
        //$message = count($listPlant);
        //echo "<script type='text/javascript'>alert('$message');</script>";

        if ($plant == null){
            $indexChosedPlant = rand(0, count($listPlant) - 1);
            $plant = $listPlant[$indexChosedPlant];
        }

        

        $message = $plant->getId();
        echo "<script type='text/javascript'>alert('$message');</script>";

        /*
        if (count($listPlant) == 1){
            $plant = $listPlant[0];
        }else{
            $indexChosedPlant = rand(0, count($listPlant) - 1);
            $plant = $listPlant[$indexChosedPlant];
        }*/

        /*
        $plant = null;

        while ($plant == null){
            $indexChosedPlant = rand(0, count($listPlant) - 1);
            $plant = $listPlant[$indexChosedPlant];
        }*/

        
        

        $achievement = new Achievement();
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
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
                $message = $plant->getId();
        echo "<script type='text/javascript'>alert('$message');</script>";
                $achievement->setUser($user);

                $user->setExperience($user->getExperience() + 1);
                $repoUser->save($user);
                
                $repoAchievement->save($achievement, true);

                //$message = "wrong answer";
                //echo "<script type='text/javascript'>alert('$message');</script>";
                return $this->redirectToRoute("admin");

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