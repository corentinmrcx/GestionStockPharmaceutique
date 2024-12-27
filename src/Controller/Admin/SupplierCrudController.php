<?php

namespace App\Controller\Admin;

use App\Entity\Supplier;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SupplierCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Supplier::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Fournisseurs')
            ->setEntityLabelInSingular('Fournisseur')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des fournisseurs')
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du fournisseur'),
            TextField::new('phone', 'Numéro de téléphone'),
            EmailField::new('email', 'Adresse email'),
            TextField::new('address', 'Adresse')
                ->hideOnIndex(),
            TextField::new('city', 'Ville')
                ->hideOnIndex(),
            NumberField::new('postalCode', 'Code postal')
                ->hideOnIndex(),
        ];
    }
}
