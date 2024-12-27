<?php

namespace App\Controller\Manager;

use App\Entity\Orders;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Orders::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Commandes')
            ->setEntityLabelInSingular('Commande')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des commandes')
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Numéro de la commande'),
            DateField::new('orderDate', 'Date de la commande'),
            AssociationField::new('user', 'Utilisateur')
                ->setFormTypeOption('choice_label', 'email')
                ->formatValue(function ($value, $entity) {
                    return $entity->getUser()->getEmail();
                }),
            AssociationField::new('orderLines', 'Nombre d\'articles')
                ->setCrudController(OrderLineCrudController::class)
                ->setFormTypeOption('by_reference', false),
        ];
    }
}
