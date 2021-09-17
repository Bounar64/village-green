<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                                'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*+?&]{8,}$/',
                                'match' => true ,
                                'message' => 'Veuillez saisir au minimun 8 caractères, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                    ]),
                ],
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ])
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ])
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ])
                ],
            ])
            ->add('address', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('additionalAddress', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('zipCode', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('country', EntityType::class, [
                // On sélectionne l'entity en relation
                'class' => Country::class,
                'label' => false,
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('phoneFixe',TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Veuillez accepter nos conditions d\'utilisation et politique de confidentialité.',
                'required' => false,
                'row_attr' => ['class' => 'agreeTerms'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Ce champ est obligatoire.",
                    ]),
                ],
            ])

            ->add('type',HiddenType::class, [
                'data' => 1
            ])
            ->add('reference', HiddenType::class, [
                'data' => '#' . 1 . rand(100, 999)
            ])
            ->add('coeff', HiddenType::class, [
                'data' => 10
            ])
            ->add('compagny', HiddenType::class)
            ->add('vtaNumber', HiddenType::class)
            ->add('rcsNumber', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
