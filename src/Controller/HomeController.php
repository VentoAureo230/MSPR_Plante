<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->redirectToRoute('home');
    }
    
    #[Route('/home', name: 'home')]
    public function home(UserRepository $user): Response
    {
        $user = $this->getUser();
        $firstname = $user->getFirstname();
        return $this->render('home/index.html.twig', [
            'firstname' => $firstname,
        ]);
    }
}
