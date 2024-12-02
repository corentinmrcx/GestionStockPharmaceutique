<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SupplyController extends AbstractController
{
    #[Route('/supply', name: 'app_supply')]
    public function index(): Response
    {
        return $this->render('supply/index.html.twig', [
            'controller_name' => 'SupplyController',
        ]);
    }
}
