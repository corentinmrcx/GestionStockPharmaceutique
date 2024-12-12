<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Stock;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('images')
            ->add('expirationDate', null, [
                'widget' => 'single_text',
            ])
            ->add('reference')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'nameCategory',
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
