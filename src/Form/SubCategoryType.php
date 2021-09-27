<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SubCategoryType extends AbstractType
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
                    'pattern' => '/^[a-zA-Z- éè]+$/',
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
        ->add('imageFile', VichImageType::class, [
            'label' => false,
            'required' => false,
            //'allow_delete' => false, // permet la suppression de l'image
            //'delete_label' => 'Delete ?',
            // 'download_label' => 'Download', // permet de télécharger l'image
            // 'constraints' => [
            //     new NotBlank([
            //         'message' => 'Ce champ est obligatoire.',
            //     ]),
            // ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SubCategory::class,
        ]);
    }
}
