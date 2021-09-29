<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9-_ \/]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide (seule les caractères -_ / sont autorisés).'
                    ])
                ]
            ])
            ->add('shortLabel', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9-_ \/]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide (seule les caractères -_ / sont autorisés).'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._ \/-s]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide.'
                    ]),
                    new Length( [
                        'min' => 10,
                        'max'=> 500,
                        'minMessage' => 'Veuillez saisir au minimum 10 caractères',
                        'maxMessage' => 'Veuillez saisir au minimum 500 caractères'
                    ])
                ]
            ])
            ->add('reference', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{4,6}+$/',
                        'match' => true,
                        'message' => '(Veuillez saisir au minimum 4 chiffres et au maximum 6 chiffres).'
                    ]),
                    new Length( [
                        'min' => 10,
                        'max'=> 500,
                        'minMessage' => 'Veuillez saisir au minimum 10 caractères',
                        'maxMessage' => 'Veuillez saisir au minimum 500 caractères'
                    ])
                ]

            ])
            ->add('color')
            ->add('material')
            ->add('service')
            ->add('discount')
            ->add('image')
            ->add('price')
            ->add('stock')
            ->add('stockAlert')
            ->add('actived')
            ->add('brand')
            ->add('createdAt', HiddenType::class)
            ->add('updatedAt', HiddenType::class)
            ->add('category')
            ->add('subCategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
