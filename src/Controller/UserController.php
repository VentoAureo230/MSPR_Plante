<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Service\LevelCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/home/user', name: 'app_user_page')]
    public function index(LevelCalculator $levelCalculator)
    {
        $userLevel = $levelCalculator->getLevel($this->getUser()->getExperience());
        return $this->render('user/index.html.twig', [
            'level' => $userLevel
        ]);
    }


    #[Route('/user/edit_profile', name: 'app_edit_user')]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Si le User n'est pas co il est redirigé au login
        }

        $form = $this->createForm(UserType::class, $user = $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setFirstname($form->get('firstname')->getData());
            $user->setLastname($form->get('lastname')->getData());
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/edit_password', name: 'app_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, ManagerRegistry $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); 
        }

        $form = $this->createForm(UserPasswordType::class, $this->getUser());
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user = $form->getData()['plainPassword'])) {
                $user->setCreatedAt(new \DateTimeImmutable()); // on modifie un mdp qui à été créer à une date précise donc il faut lui donner une date d'update pour que la modification est lieu
                $user->setPlainPassword($form->getData()['plainPassword']);

                $em = $manager->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Mot de passe modifié avec succès'
                );

                return $this->redirectToRoute('home');
            } else {
                $this->addFlash(
                    'warning',
                    'Mot de passe incorrect'
                );
            }
        }

        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}