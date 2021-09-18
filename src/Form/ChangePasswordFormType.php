<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('PlainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => false,
                    'attr' => ['placeholder' => 'Entrez votre nouveau mot de passe'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Ce champ est obligatoire.',
                        ]),
                        // new Length([
                        //     'min' => 6,
                        //     'minMessage' => 'Your password should be at least {{ limit }} characters',
                        //     // max length allowed by Symfony for security reasons
                        //     'max' => 4096,
                        // ]),
                        new Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*+?&]{8,}$/',
                            'match' => true ,
                            'message' => 'Veuillez saisir au minimun 8 caractères, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                ]),
                    ],
                ],
                'label' => false,
                'required' => false,

                'second_options' => [
                    'label' => false,
                    'attr' => ['placeholder' => 'Confirmez votre nouveau mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe doivent être identique.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
