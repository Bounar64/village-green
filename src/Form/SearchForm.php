<?php 

namespace App\Form;

use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    // Construction de notre formulaire 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('motCle', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ]);
    }

    // Pour configurer les différentes options liées à ce formulaire
    public function configureOptions(OptionsResolver $resolver) 
    { 
        // On définie différentes valeurs par défaut
        $resolver->setDefaults([ 
            'data_class' => SearchData::class, // la classe qui servira à représenté nos données
            'method' => 'GET', // ce formulaire utilisera la methode 'get' par default
            'csrf_protection' => false // protection csrf désactivé pas besoin dans un formulaire de recherche..

        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}