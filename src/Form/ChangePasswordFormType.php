<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    { 
        //On récupère nos option configuré plus bas via $options
        if($options['current_password_is_required']) {
                $builder
                ->add('currentPassword', PasswordType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => ['placeholder' => 'Entrez votre mot de passe actuel'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Ce champ est obligatoire.',
                        ]),
                        new Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*+?&]{8,}$/',
                            'match' => true ,
                            'message' => 'Veuillez saisir au minimun 8 caractères, au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.'
                        ]),
                        new UserPassword([
                            'message' => 'Mot de passe incorrect.'
                        ]), // Cette contrainte vérifie que le mot de passe entré et celui de l'utilisateur courant
                    ],
                    'mapped' => false
                ]);

        }

        $builder
        ->add('newPassword', RepeatedType::class, [
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
                'attr' => ['placeholder' => 'Confirmer votre nouveau mot de passe'],
            ],
            'invalid_message' => 'Les mots de passe doivent être identique.',
            // Instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'label' => false,
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'current_password_is_required' => false // par défaut null -> ajout de cette option pour afficher le mdp courant dans changement de mdp et pas dans réinitialition de mdp.
        ]);
    }
}
