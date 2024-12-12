<?php

namespace App\Controller\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_manager_product')]
    public function index(): Response
    {
        return $this->render('manager/product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/create', name: 'app_manager_product_create', methods: ['GET', 'POST'])]
    public function create(): Response
    {
        return $this->render('manager/product/create.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{id}/update', name: 'app_manager_product_update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(): Response
    {
        return $this->render('manager/product/update.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{id}/delete', name: 'app_manager_product', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(): Response
    {
        return $this->render('manager/product/delete.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
