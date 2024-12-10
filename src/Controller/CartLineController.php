<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartLineController extends AbstractController
{
    #[Route('/cart/line', name: 'app_cart_line')]
    public function index(): Response
    {
        return $this->render('cart_line/index.html.twig', [
            'controller_name' => 'CartLineController',
        ]);
    }
}
