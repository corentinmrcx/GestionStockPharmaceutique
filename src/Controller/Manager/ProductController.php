<?php

namespace App\Controller\Manager;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manager/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_manager_product')]
    public function index(): Response
    {
        return $this->render('manager/product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/create', name: 'app_manager_product_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('manager/product/create.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/update', name: 'app_manager_product_update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function update(Request $request, Product $product, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('manager/product/update.html.twig', [
            'product' => $product,
            'form' => $form
        ]);
    }

    #[Route('/{id}/delete', name: 'app_manager_product', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function delete(): Response
    {
        return $this->render('manager/product/delete.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
