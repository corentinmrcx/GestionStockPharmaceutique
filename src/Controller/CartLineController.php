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

    #[Route('/product/{id}', name: 'cart_add_show', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function addToCartAndShow(Product $product, EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository, SessionInterface $session): Response
    {
        $similarProducts = $productRepository->findBy(['category' => $product->getCategory()->getId()], null, 4);

        $newCartLine = new CartLine();
        $newCartLine->setProduct($product);



        $form = $this->createForm(CartLineType::class, $newCartLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCartLine = $form->getData();
            $entityManager->persist($newCartLine);
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index');
        }

        return $this->render('product/show.html.twig', [
            'form' => $form->createView(), 'cartLine' => $newCartLine, 'product' => $product,  'similarProducts' => $similarProducts,
        ]);
    }
}
