<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles')
            ->add('reference')
            ->add('password')
            ->add('confirm_password')
            ->add('lastName')
            ->add('firstName')
            ->add('compagny')
            ->add('vtaNumber')
            ->add('rcsNumber')
            ->add('type')
            ->add('coeff')
            ->add('sex')
            ->add('address')
            ->add('city')
            ->add('zipCode')
            ->add('phone')
            ->add('createdAt')
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
