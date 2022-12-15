<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use App\Service\LevelCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/home/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_page')]
    public function index(LevelCalculator $levelCalculator)
    {

        $userLevel = $levelCalculator->getLevel($this->getUser()->getExperience());
        return $this->render('user/index.html.twig', [
            'level' => $userLevel,
            'user' => $this->getUser(),
        ]);
    }


    #[Route('/edit_profile', name: 'app_edit_user')]
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

    #[Route('/edit_password', name: 'app_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(Request $request,EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher,): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirect('/home');
        }
        return $this->render('user/edit_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete_account/{id}', name: 'app_delete_account')]
    public function deleteAccount(User $user, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_login');
    }
}