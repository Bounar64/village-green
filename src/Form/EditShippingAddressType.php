<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EditShippingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                ]
            ])
            ->add('address', TextType::class, [
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
            ->add('additionalAddress', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('country', EntityType::class, [
                'label' => false,
                'required' => false,
                // On sélectionne l'entity en relation ici le pays
                'class' => Country::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
