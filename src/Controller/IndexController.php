<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $recommendedProducts = $productRepository->findBy(['isRecommended' => true]);
        return $this->render('index/index.html.twig', [
            'recommendedProducts' => $recommendedProducts,
        ]);
    }
}
