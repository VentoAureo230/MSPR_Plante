<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use App\Form\UserPasswordType;

class UserController extends AbstractController
{
    #[Route('/home/user', name: 'app_user_page')]
    public function index()
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/collection', name: 'app_stats')]
    public function collection(): Response
    {
        return $this->render('stats/index.html.twig');
    }

    /**
     * Fonction de modification des informations de l'utilisateur
     */
    #[Route('/user/edit_profile', name: 'app_edit_user')]
    public function edit(Request $request, ManagerRegistry $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Si le User n'est pas co il est redirigé au login
        }

        $form = $this->createForm(UserType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($form->getData()->getPlainPassword())) {
                $user = $form->getData();
                $em = $manager->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Les infos ont bien été modifiés.'
                );

                return $this->redirectToRoute('home');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Fonction de modification du mot de passe de l'utilisateur
     */
    #[Route('/user/edit_password', name: 'app_edit_password', methods: ['GET', 'POST'])]
    public function editPassword(User $user, Request $request, ManagerRegistry $manager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login'); // Si le User n'est pas co il est redirigé au login
        }

  
        $form = $this->createForm(UserPasswordType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user = $form->getData()['plainPassword'])) {
                $user->setUpdatedAt(new \DateTimeImmutable()); // on modifie un mdp qui à été créer à une date précise donc il faut lui donner une date d'update pour que la modification est lieu
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