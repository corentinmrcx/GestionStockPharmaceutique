<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderLineController extends AbstractController
{
    #[Route('/order/line', name: 'app_order_line')]
    public function index(): Response
    {
        return $this->render('order_line/index.html.twig', [
            'controller_name' => 'OrderLineController',
        ]);
    }
}
