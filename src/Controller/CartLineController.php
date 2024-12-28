<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\CartLineType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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

