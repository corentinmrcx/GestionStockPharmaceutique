<?php

namespace App\Controller\Manager;

use App\Entity\OrderLine;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class OrderLineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderLine::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Lignes de commande')
            ->setEntityLabelInSingular('Ligne de commande')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des lignes de commande')
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Numéro de ligne de commande'),
            AssociationField::new('product', 'Produit')
                ->setFormTypeOption('choice_label', 'name')
                ->formatValue(function ($value, $entity) {
                    return $entity->getProduct()->getName();
                }),
            IntegerField::new('quantity', 'Quantité'),
            MoneyField::new('unitPrice', 'Prix Unitaire')
                ->setCurrency('EUR'),
        ];
    }
}
