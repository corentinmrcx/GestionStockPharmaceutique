<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le prénom ne doit pas être inférieur à {{ limit }} caractères.',
                        'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom ne doit pas être inférieur à {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adresse email est obligatoire.',
                    ]),
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone *',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le numéro de téléphone est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{10}$/',
                        'message' => 'Le numéro de téléphone doit contenir 10 chiffres.',
                    ]),
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'L\'adresse ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La ville ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{5}$/',
                        'message' => 'Le code postal doit contenir exactement 5 chiffres.',
                    ]),
                ],
            ])
            ->add('rppsNumber', NumberType::class, [
                'label' => 'Numéro RPPS',
                'label_attr' => [
                    'class' => 'form-label',
                ],
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'Le numéro RPPS doit contenir exactement 11 chiffres.',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier',
                'attr' => [
                    'class' => 'btn btn-custom w-100 mt-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
