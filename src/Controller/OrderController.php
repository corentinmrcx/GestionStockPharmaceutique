<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Repository\OrderLineRepository;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(OrderRepository $orderRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $orders = $orderRepository->findByUser($user->getId());

        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
            'orders' => $orders,
        ]);
    }
    #[Route('/order/{id}', name: 'app_order_show')]
    public function show(int $id, OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->find($id);

        if (!$orders) {
            throw $this->createNotFoundException('Order not found');
        }
        return $this->render('order/show.html.twig', [
            'orders' => $orders,
        ]);
    }
}
