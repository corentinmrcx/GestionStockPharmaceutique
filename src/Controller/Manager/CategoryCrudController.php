<?php

namespace App\Controller\Manager;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories')
            ->setEntityLabelInSingular('Catégorie')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des catégories')
            ->setPaginatorPageSize(20);
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nameCategory', 'Nom de la catégorie'),
        ];
    }
}
