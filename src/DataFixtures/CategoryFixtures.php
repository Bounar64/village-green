<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   
        // Création des catégories
         
        $category= new Category();
        $category
            ->setLabel('Guit/Bass');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Batterie');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Clavier');
        $manager->persist($category);
        
        $category= new Category();
        $category
            ->setLabel('Studio');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Sono');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Eclairage');
        $manager->persist($category);
        
        $category= new Category();
        $category
            ->setLabel('DJ');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Case');
        $manager->persist($category);

        $category= new Category();
        $category
            ->setLabel('Accessoires');
        $manager->persist($category);


        $category= new Category();
        $category
            ->setLabel('Vent');
        $manager->persist($category);

        $manager->flush();
    }
}
