<?php

namespace App\Controller;

use App\Repository\CartLineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_index', methods : ['GET'])]
    public function index(CartLineRepository $cartLineRepository): Response
    {
        $cartLines = $cartLineRepository->findAll();

        return $this->render('cart/index.html.twig', ['cartLines' => $cartLines]);
    }
}
