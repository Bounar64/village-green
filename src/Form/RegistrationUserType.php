<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
                'required' => false
            ])
            ->add('confirm_password', PasswordType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('firstName', TextType::class, [
                'label' => false,
                'required' => false
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

            ->add('type',HiddenType::class, [
                'data' => 1
            ])
            ->add('reference', HiddenType::class, [
                'data' => '#' . 1 . rand(100, 900)
            ])
            ->add('coeff', HiddenType::class, [
                'data' => 10
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
