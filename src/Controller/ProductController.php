<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\CartLineType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator, #[MapQueryParameter] ?string $search = null): Response
    {
        $queryBuilder = $productRepository->search($search);
        $products = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    #[Route('/product/{id}', name: 'cart_add_show', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function addToCartAndShow(Product $product, EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository, SessionInterface $session): Response
    {


        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $cartRepository = $entityManager->getRepository(Cart::class);
        $cart = $cartRepository->findOneBy(['user' => $user]);

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
            $entityManager->flush();
        }

        $cartLine = new CartLine();
        $cartLine->setCart($cart);
        $cartLine->setProduct($product);

        $form = $this->createForm(CartLineType::class, $cartLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartLine->setQuantity($form->get('quantity')->getData());
            $entityManager->persist($cartLine);
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index');
        }

        $similarProducts = $productRepository->findBy(
            ['category' => $product->getCategory()],
            null,
            4
        );

        return $this->render('product/show.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'similarProducts' => $similarProducts,
        ]);
    }
}
