<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_user_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user){
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();
        $role = 'ROLE_USER';

        if (in_array('ROLE_ADMIN', $roles, true)) {
            $role = 'ROLE_ADMIN';
        } elseif (in_array('ROLE_MANAGER', $roles, true)) {
            $role = 'ROLE_MANAGER';
        }

        return $this->render('user_dashboard/index.html.twig', [
            'role' => $role,
        ]);
    }
}
