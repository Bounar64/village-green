<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // On récupère nos option configuré plus bas via $options : Pour rendre non obligatoire la modification de l'image
        if($options['image_file_no_required']) {
            $builder
             // n'existe que dans le form 
             ->add('image_file', FileType::class, [
                'mapped' => false,
                'label' => false,
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        "maxSize" => "5M",
                        "mimeTypes" => [
                            "image/png",
                            "image/jpg",
                            "image/jpeg"
                        ],
                        "mimeTypesMessage" => "Veuillez envoyer une image au format png, jpg ou jpeg, de 5 Mo maximum"
                    ])
                ]
            ]);
        }

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
                        'pattern' => '/^[a-zA-Z0-9-\'":áàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._ ()\/\s]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide.'
                    ]),
                    new Length( [
                        'min' => 5,
                        'max'=> 5000,
                        'minMessage' => 'Veuillez saisir au minimum {{ limit }} caractères',
                        'maxMessage' => 'Veuillez saisir au maximum {{ limit }} caractères'
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
                        'message' => 'Veuillez saisir au minimum 4 chiffres et au maximum 6 chiffres.'
                    ]),
                ]

            ])
            ->add('color', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide (Premier caractère en majuscule).'
                    ])
                ]
            ])
            ->add('material', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide (Premier caractère en majuscule).'
                    ])
                ]
            ])
            ->add('service', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices'  => [
                    'Vente' => 1,
                    'Location' => 0
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ])
                ]
            ])
            ->add('discount', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[0-9]{1,2}$/',
                        'match' => true,
                        'message' => 'Saisie invalide.'
                    ])
                ]
            ])
            // n'existe que dans le form 
            ->add('image_file', FileType::class, [
                'mapped' => false,
                'label' => false,
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    // new NotBlank([
                    //     'message' => 'Ce champ est obligatoire.',
                    // ]),
                    new File([
                        "maxSize" => "5M",
                        "mimeTypes" => [
                            "image/png",
                            "image/jpg",
                            "image/jpeg"
                        ],
                        "mimeTypesMessage" => "Veuillez envoyer une image au format png, jpg ou jpeg, de 5 Mo maximum"
                    ])
                ]
            ])
            ->add('price', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^([0-9]+).([0-9]{2})/',
                        'match' => true,
                        'message' => 'Veuillez saisir un prix au format 0000.00'
                    ])
                ]
            ])
            ->add('stock', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'match' => true,
                        'message' => 'Sasie invalide.'
                    ])
                ]
            ])
            ->add('stockAlert', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]+$/',
                        'match' => true,
                        'message' => 'Sasie invalide.'
                    ])
                ]
            ])
            ->add('actived', CheckboxType::class, [
                'label' => 'Activer le produit',
                'required' => false,
                'attr' => ['checked' => 'checked'],
            ])
            ->add('brand', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'match' => true,
                        'message' => 'Saisie invalide.'
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                // On sélectionne l'entity en relation
                'class' => Category::class,
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                ]
            ])
            ->add('subCategory', EntityType::class, [
                // On sélectionne l'entity en relation
                'class' => SubCategory::class,
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoire.',
                    ]),
                ]
            ])   
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'image_file_no_required' => false
        ]);
    }
}
