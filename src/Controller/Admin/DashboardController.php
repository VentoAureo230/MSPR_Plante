<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Plant;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // if($this->getUser()->getRoles() == ['ROLES_USER']){return $this->redirectToRoute('home');} else {return $this->redirectToRoute('admin');}

        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(PlantCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MSPR Plante');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'home');
        yield MenuItem::linkToCrud('Plantes', 'fas fa-map-marker-alt', Plant::class);
        yield MenuItem::linkToCrud('Administrateurs', 'fas fa-map-marker-alt', User::class)->setQueryParameter("is_admin",true);
        
    }
}
