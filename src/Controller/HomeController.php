<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
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
    public function home(UserRepository $userRepo): Response
    {
        $firstname = null;
        return $this->render('home/index.html.twig', [
            'firstname' => $firstname,
        ]);
    }
}
