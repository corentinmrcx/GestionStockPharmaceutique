<?php

namespace App\Controller\Manager;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                ->setEntityLabelInPlural('Produits')
                ->setEntityLabelInSingular('Produit')
                ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des produits')
                ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reference', 'Référence'),
            TextField::new('name', 'Nom du produit'),
            TextField::new('description', 'Description')
                ->hideOnIndex(),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            ImageField::new('imageName', 'Image')
                ->setBasePath('images/products')
                ->setUploadDir('public/images/products')
                ->setRequired(false),
            AssociationField::new('category', 'Catégorie')
                ->setFormTypeOption('choice_label', 'name_category')
                ->formatValue(function ($value, $entity) {
                    return $entity->getCategory()->getNameCategory();
                }),
            AssociationField::new('brand', 'Marque')
                ->setFormTypeOption('choice_label', 'name')
                ->formatValue(function ($value, $entity) {
                    return $entity->getBrand()->getName();
                }),
            DateField::new('expirationDate', 'Date d\'expiration'),
        ];
    }
}
