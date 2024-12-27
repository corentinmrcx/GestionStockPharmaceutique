<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductInventaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Inventaires')
            ->setEntityLabelInSingular('Inventaire')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Inventaire des produits')
            ->setPaginatorPageSize(20);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Crud::PAGE_NEW, Crud::PAGE_EDIT, Crud::PAGE_DETAIL, Crud::PAGE_DELETE);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du produit'),
            ImageField::new('imageName', 'Image')
                ->setBasePath('images/products')
                ->setLabel('Photo'),
            NumberField::new('stock.quantity', 'Quantité en stock'),
            NumberField::new('stock.alert', 'Seuil d\'alerte'),
        ];
    }
}
