<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label')
            ->add('shortLabel')
            ->add('description')
            ->add('reference')
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
