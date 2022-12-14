<?php

namespace App\Controller;

use App\Entity\Achievement;
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
    #[Route('/seek&find', name: 'game')]
    public function index(RequestStack $requestStack, UserRepository $repoUser, LevelCalculator $levelCalculator ,PlantRepository $repoPlant, AchievementRepository $repoAchievement, Request $request, SluggerInterface $slugger, ImageLocation $location): Response
    {

        

        $user = $this->getUser();
        $achievement = new Achievement();

        $session = $requestStack->getSession();
        echo "<script>console.log('Debug Objects: " . $session->get("plante_id") . "' );</script>";

        if (! $request->isMethod('post'))
        {
            $plant =null;
            if($session->has("plante_id")){
                $plantId = (int)$session->get('plante_id');
                $plant = $repoPlant->findOneBy(['id' => $plantId]);
            }


            // si une plante a été attribué, récupération de l'id dans la session
            if($plant == null){
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
            // sinon atribution d'une plante aléatoire en fonction du niveau de joueur
            }

            
            
        //echo "<script>console.log('Debug Objects: " . $session->get("plante_id") . "' );</script>";
            $achievement->setPlant($plant);
        }
        // si c'est une requête POST, autrement dit, la confirmation que c'est la bonne plante, récupération de l'id de la plante dans la session
        else
        {
            $idPlant = (int)$session->get("plante_id");
            $plant = $repoPlant->findOneBy(["id" => $idPlant]);

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
                $achievement->setUser($user);

                $user->setExperience($user->getExperience() + 1);
                $repoUser->save($user);
                
                $repoAchievement->save($achievement, true);

                
                $session->remove("plante_id");


                return $this->redirectToRoute("app_answer", [
                    'idPlant' => $achievement->getPlant()->getId()
                ]);

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