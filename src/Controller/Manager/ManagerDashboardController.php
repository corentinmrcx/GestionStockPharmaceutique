<?php

namespace App\Controller\Manager;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/manager')]
#[IsGranted('ROLE_MANAGER')]
class ManagerDashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'app_manager_index')]
    public function index(): Response
    {
        return $this->render('manager/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DashBoard - Gestionnaire')
            ->setDefaultColorScheme('dark')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Produits', 'fas fa-capsules', Product::class);
        yield MenuItem::linkToCrud('Marques', 'fas fa-certificate', Brand::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-layer-group', Category::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-cart-flatbed', Order::class);
    }
}
