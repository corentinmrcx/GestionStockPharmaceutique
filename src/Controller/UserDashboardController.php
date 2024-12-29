<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_user_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
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
            'user' => $user,
        ]);
    }

    #[Route('/editprofile/profile/{id}', name: 'app_user_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->getUser() !== $user) {
            return $this->redirectToRoute('app_index');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_user_dashboard');
        }

        return $this->render('user_dashboard/editProfile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
