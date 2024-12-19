<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository, #[MapQueryParameter] ?string $search = null): Response
    {
        $products = $productRepository->search($search);
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(Product $product, ProductRepository $productRepository): Response
    {
        $similarProducts = $productRepository->findBy(['category' => $product->getCategory()->getId()], null, 4);
        return $this->render('product/show.html.twig', [
            'product' => $product,
            'similarProducts' => $similarProducts,
        ]);
    }

}
