<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['autocomplete' => 'email', 'placeholder' => 'E-mail'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,4})$/',
                        'match' => true,
                        'message' => 'Veuillez saisir un e-mail valide.'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
