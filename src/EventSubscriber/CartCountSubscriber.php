<?php

namespace App\EventSubscriber;

use App\Repository\CartLineRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class CartCountSubscriber implements EventSubscriberInterface
{
    private $cartLineRepository;
    private $security;
    private $twig;

    public function __construct(CartLineRepository $cartLineRepository, Security $security, Environment $twig)
    {
        $this->cartLineRepository = $cartLineRepository;
        $this->security = $security;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $user = $this->security->getUser();
        $itemCount = 0;

        if ($user) {
            $itemCount = $this->cartLineRepository->countItemsByUser($user->getId());
        }

        $this->twig->addGlobal('itemCount', $itemCount);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // Attacher l'événement au cycle de vie du contrôleur
            ControllerEvent::class => 'onKernelController',
        ];
    }
}
