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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadPhotoController extends AbstractController
{
    #[Route('/test', name: 'game')]
    public function index(RequestStack $requestStack, UserRepository $repoUser, LevelCalculator $levelCalculator ,PlantRepository $repoPlant, AchievementRepository $repoAchievement, Request $request, SluggerInterface $slugger, ImageLocation $location): Response
    {
        // TODO récupérer vrai utilisateur
        $user = $repoUser->findOneBy(['id' => 7]);
        //$user = $this->getUser();
        $achievement = new Achievement();

        $session = $requestStack->getSession();

        echo "<script>console.log('Debug Objects: " . $session->get("plante_id") . "' );</script>";

        if (! $request->isMethod('post'))
        {
            $userLevel = $levelCalculator->getLevel($user->getExperience());

        
            $userId = $user->getId();
            $listAchievement = $repoAchievement->findBy(['user' => $userId]);
            $criteria = new Criteria();
            $criteria->where(Criteria::expr()->lte('Level', $userLevel))->andWhere(Criteria::expr()->eq('is_enable_for_user', 1));
            $listPlant = $repoPlant->matching($criteria);

            $neverDone = false;
            while (!$neverDone){
                $neverDone = true;
                $indexPlant = rand(0,count($listPlant) - 1);
                $plant = $listPlant[$indexPlant];
                foreach ($listAchievement as $a) {
                    if ($plant->getId() == $a->getPlant()->getId()){
                        $neverDone = false;
                    }
                }
            }
            $session->set("plante_id",$plant->getId());
            
        echo "<script>console.log('Debug Objects: " . $session->get("plante_id") . "' );</script>";
            $achievement->setPlant($plant);
        }
        else
        {
            $idPlant = (int)$session->get("plante_id");
            $plant = $repoPlant->findOneBy(["id" => $idPlant]);
            $user->setExperience(10);
        }

        
        $form = $this->createForm(AchievementType::class, $achievement);
        $form->handleRequest($request);

        if ($form->get("yes")->isclicked()){
            $plantPicture =  $form->get('file_name')->getData();
            if ($plantPicture) {
                $originaleFilename = pathinfo($plantPicture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originaleFilename);
                $newFileName = $safeFilename . '-' . uniqid() . '.' . $plantPicture->guessExtension();

                try {
                    $plantPicture->move($this->getParameter('app.path.achievement_picture'), $newFileName);
                    //$plantPicture->move($this->getParameter('app.path.achievement_picture'), $originaleFilename);
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
                //$achievement->setPlant($plant);
                $achievement->setUser($user);

                $user->setExperience($user->getExperience() + 1);
                $repoUser->save($user);
                
                $repoAchievement->save($achievement, true);

                //$message = "wrong answer";
                //echo "<script type='text/javascript'>alert('$message');</script>";
                return $this->redirectToRoute("game");

            }
        }   

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