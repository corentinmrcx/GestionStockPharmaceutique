<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'required' => false,
                'class' => Category::class,
                'choice_label' => 'nameCategory',
                'label' => 'Catégorie',
                'placeholder' => 'Toutes',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('c')
                        ->orderBy('c.nameCategory', 'ASC');
                },
            ])
            ->add('brand', EntityType::class, [
                'required' => false,
                'class' => Brand::class,
                'choice_label' => 'name',
                'label' => 'Marque',
                'placeholder' => 'Toutes',
                'query_builder' => function (EntityRepository $entityRepository) {
                    return $entityRepository->createQueryBuilder('b')
                        ->orderBy('b.name', 'ASC');
                },
            ])
            ->add('priceMin', NumberType::class, [
                'required' => false,
                'label' => 'Prix Min',
            ])
            ->add('priceMax', NumberType::class, [
                'required' => false,
                'label' => 'Prix Max',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

}
