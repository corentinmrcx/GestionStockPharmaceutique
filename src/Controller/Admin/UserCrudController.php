<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle(Crud::PAGE_INDEX, 'Pharmacie - Gestion des utilisateurs')
            ->setPaginatorPageSize(20);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Identifiant')
                ->hideOnForm(),
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            EmailField::new('email', 'Adresse email')
                ->setFormTypeOption('attr', ['readonly' => true]),
            TextField::new('phone', 'Numéro de téléphone'),
            DateField::new('birthdate', 'Date de naissance')
                ->hideOnIndex(),
            TextField::new('address', 'Adresse')
                ->hideOnIndex(),
            TextField::new('city', 'Ville')
                ->hideOnIndex(),
            NumberField::new('postalCode', 'Code postal')
                ->hideOnIndex(),
            ChoiceField::new('roles', 'Rôle(s)')
                ->setChoices([
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Gestionnaire' => 'ROLE_MANAGER',
                ])
                ->allowMultipleChoices(),
            NumberField::new('rppsNumber', 'Numéro RPPS'),
        ];
    }
}
