<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartLine;
use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CartLineRepository;
use App\Repository\CartRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/{id}', name: 'app_category_show')]
    public function show(ProductRepository $productRepository, Category $category, PaginatorInterface $paginator, Request $request): Response
    {
        $queryBuilder = $productRepository->findBy(['category' => $category]);
        $products = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            12
        );

        foreach ($products as $product) {
            $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('app_category_add', ['id' => $product->getId()]))
                ->setMethod('POST')
                ->getForm();
            $addCartCategories[$product->getId()] = $form->createView();
        }

        return $this->render('category/show.html.twig', [
            'products' => $products,
            'category' => $category,
            'addCartCategories' => $addCartCategories,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/category/addCartIndex/{id}', name: 'app_category_add', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function addCartCategories(CartRepository $cartRepository, EntityManagerInterface $entityManager, CartLineRepository $cartLineRepository, Product $product, Request $request): Response
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

        $referer = $request->headers->get('referer');

        return $this->redirect($referer ?: $this->generateUrl('app_category'));
    }
}
