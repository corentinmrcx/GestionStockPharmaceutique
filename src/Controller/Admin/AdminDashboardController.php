<?php

namespace App\Controller\Admin;

use App\Entity\Inventory;
use App\Entity\Order;
use App\Entity\Supplier;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DashBoard - Administrateur')
            ->setDefaultColorScheme('dark')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Inventaire', 'fas fa-warehouse', Inventory::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-cart-flatbed', Order::class);
        yield MenuItem::linkToCrud('Fournisseurs', 'fas fa-truck-field', Supplier::class);
    }
}
