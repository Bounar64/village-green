<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'mapped' => false,
                'label' => false,
                'required'=> false,
                'placeholder'=> '--Choississez une catégorie--',
            ])

            ->add('subCategory', ChoiceType::class, [
                'label' => false,
                'required'=> false,
                'placeholder'=> '--Sélectionner d\'abord une catégorie--'
            ])
        ;

        $formModifier = function(FormInterface $form, Category $category = null) { // $category à null pour l'initialiser
            $subCategory = (null === $category) ? [] : $category->getSubCategory(); // ternaire si categorie est null renvoi un tabelau vide sinon les sous-categorie
            
            // quand on récupère les sous-catégories on les ajoutes au formulaire
            $form->add('subCategory', EntityType::class, [
                'class' => SubCategory::class,
                'label' => false,
                'required'=> false,
                'choices' => $subCategory,
                'choice_label' => 'label',
                'placeholder'=> '--Sélectionner d\'abord une catégorie--'
            ]);
        };

        $builder->get('category')->addEventListener( // on récupère le champ région
            FormEvents::POST_SUBMIT, // POST_SUBMIT = après envoi du formulaire
            function(FormEvent $event) use ($formModifier) { // fonction exécuté au moment de l'envoi du form
                $category = $event->getForm()->getData(); // on récupère la catégorie sélectionné
                $formModifier($event->getForm()->getParent(), $category); // getForm() on aura que la région, getForm()->getParent() on récupère tout le form comme c'est son parent
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class
        ]);
    }
}
