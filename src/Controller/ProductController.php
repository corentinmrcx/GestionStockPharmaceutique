<?php

namespace App\Controller;

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
        $similarProducts = $productRepository->findBy(['category' => $product->getCategory()->getId()], null, 4);


        $newCartLine = new CartLine();


        $form = $this->createForm(CartLineType::class, $newCartLine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCartLine->setProduct($product);

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
