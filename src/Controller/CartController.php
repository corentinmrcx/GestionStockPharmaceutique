<?php

namespace App\Controller;

use App\Entity\CartLine;
use App\Entity\OrderLine;
use App\Entity\Orders;
use App\Repository\CartLineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart_index', methods : ['POST', 'GET'])]
    public function index(CartLineRepository $cartLineRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        $cartLines = $cartLineRepository->findByUser($user->getId());

        $deleteForms = [];
        $canValidate = true;

        foreach ($cartLines as $cartLine) {
            $form = $this->createFormBuilder()
                ->setAction($this->generateUrl('app_cart_delete', ['id' => $cartLine->getId()]))
                ->setMethod('POST')
                ->add('delete', SubmitType::class, [
                    'label' => '<i class="fa-solid fa-trash"></i>',
                    'attr' => [
                        'class' => 'btn btn-danger',
                        'style' => 'display: inline-flex; align-items: center; justify-content: center;',
                    ],
                    'label_html' => true,
                ])
                ->getForm();
            $deleteForms[$cartLine->getId()] = $form->createView();

            if ($cartLine->getQuantity() > $cartLine->getProduct()->getStock()->getQuantity()) {
                $canValidate = false;
            }
        }
        $formValidate = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_cart_validate'))
            ->getForm();
        $validateCart = $formValidate->createView();

        return $this->render('cart/index.html.twig', ['cartLines' => $cartLines, 'deleteForms' => $deleteForms, 'validateCart' => $validateCart, 'canValidate' => $canValidate]);
    }

    #[Route('/cart/delete/{id}', name: 'app_cart_delete', methods: ['POST'])]
    public function delete(CartLine $cartLine, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($cartLine);
        $entityManager->flush();

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/cart/validate', name: 'app_cart_validate', methods: ['POST'])]
    public function validate(CartLineRepository $cartLineRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $cartLines = $cartLineRepository->findByUser($user->getId());

        $order = new Orders();
        $order->setUser($user);
        $order->setOrderDate(new \DateTimeImmutable());

        $entityManager->persist($order);
        $entityManager->flush();

        foreach ($cartLines as $cartLine) {
            $product = $cartLine->getProduct();
            $quantityInCart = $cartLine->getQuantity();

            $currentStock = $product->getStock()->getQuantity();
            if ($currentStock < $quantityInCart) {
                return $this->redirectToRoute('app_cart_index');
            }
            $product->getStock()->setQuantity($currentStock - $quantityInCart);

            $orderLine = new OrderLine();
            $orderLine->setOrder($order);
            $orderLine->setProduct($product);
            $orderLine->setQuantity($cartLine->getQuantity());
            $orderLine->setUnitPrice($cartLine->getProduct()->getPrice());

            $order->addOrderLine($orderLine);
            $entityManager->persist($orderLine);
            $entityManager->remove($cartLine);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
    }
}
