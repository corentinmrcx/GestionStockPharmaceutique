<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Product;
use App\Form\CartLineType;
use App\Form\ProductFiltersType;
use App\Repository\CartLineRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = $request->query->get('search');

        $formFilters = $this->createForm(ProductFiltersType::class);
        $formFilters->handleRequest($request);

        if ($formFilters->isSubmitted() && $formFilters->isValid()) {
            $filters = $formFilters->getData();
        } else {
            $filters = [];
        }
        $filters['search'] = $search;

        $queryBuilder = $productRepository->search($search, $filters);

        $products = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            12
        );

        $addCart = [];
        foreach ($products as $product) {
            $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('app_product_add', ['id' => $product->getId()]))
                ->setMethod('POST')
                ->getForm();
            $addCart[$product->getId()] = $form->createView();
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'search' => $search,
            'addCart' => $addCart,
            'formFilters' => $formFilters->createView(),
        ]);

    }



    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/product/addCartProduct/{id}', name: 'app_product_add', methods: ['POST'])]
    public function addCartProduct(CartRepository $cartRepository, EntityManagerInterface $entityManager, CartLineRepository $cartLineRepository, Product $product): Response
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

        return $this->redirectToRoute('app_product');
    }

    #[Route('/product/{id}', name: 'cart_add_show', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function addToCartAndShow(Product $product, EntityManagerInterface $entityManager, Request $request, ProductRepository $productRepository, CartLineRepository $cartLineRepository): Response
    {
        $user = $this->getUser();

        $currentStock = $product->getStock()->getQuantity();

        $cartLine = new CartLine();
        $form = $this->createForm(CartLineType::class, $cartLine, ['max_stock' => $currentStock]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            $existingCartLine = $cartLineRepository->findOneBy(['cart' => $cart, 'product' => $product]);
            if ($existingCartLine) {
                $additionalQuantity = $form->get('quantity')->getData();
                $existingCartLine->setQuantity($existingCartLine->getQuantity() + $additionalQuantity);
            } else {
                $cartLine = new CartLine();
                $cartLine->setCart($cart);
                $cartLine->setProduct($product);
                $cartLine->setQuantity($form->get('quantity')->getData());
                $entityManager->persist($cartLine);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index');
        }

        $similarProducts = $productRepository->findSimilarProducts(
            $product->getCategory(),
            $product->getId(),
            4
        );


        return $this->render('product/show.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'similarProducts' => $similarProducts,
            'user' => $user,
        ]);
    }
}
