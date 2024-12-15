<?php

namespace App\Form;

use App\Entity\CartLine;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'data' => 1, // Valeur par défaut
                'attr' => [
                    'min' => 1,  // Valeur minimale
                    'max' => 99, // Valeur maximale
                    'class' => 'form-control text-center', // Appliquer un style
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CartLine::class,
        ]);
    }
}
