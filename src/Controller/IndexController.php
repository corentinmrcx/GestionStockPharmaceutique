<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Repository\CartLineRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $recommendedProducts = $productRepository->findRecommendedProducts(6);

        $addCartIndex = [];
        foreach ($recommendedProducts as $product) {
            $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('app_index_addcartindex', ['id' => $product->getId()]))
                ->setMethod('POST')
                ->getForm();
            $addCartIndex[$product->getId()] = $form->createView();
        }

        return $this->render('index/index.html.twig', [
            'addCartIndex' => $addCartIndex,
            'recommendedProducts' => $recommendedProducts,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/addCartIndex/{id}', name: 'app_index_addcartindex', methods: ['POST'])]
    public function addCartIndex(CartRepository $cartRepository, EntityManagerInterface $entityManager, CartLineRepository $cartLineRepository, Product $product): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $cart = $cartRepository->findOneBy(['user' => $user]);

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
            $entityManager->flush();
        }

        $cartLine = $cartLineRepository->findOneBy(['cart' => $cart, 'product' => $product]);
        if ($cartLine) {
            $currentQuantity = $cartLine->getQuantity();
        }

        if ($cartLine) {
            $cartLine->setQuantity($currentQuantity + 1);
        } else {
            $cartLine = new CartLine();
            $cartLine->setCart($cart);
            $cartLine->setProduct($product);
            $cartLine->setQuantity(1);
        }

        $entityManager->persist($cartLine);
        $entityManager->flush();

        return $this->redirectToRoute('app_index');
    }
}
