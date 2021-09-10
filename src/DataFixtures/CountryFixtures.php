<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CountryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création des Pays

        $country= new Country();
        $country
            ->setCodeIso('FR')
            ->setName('FRANCE');

        $manager->persist($country);
        $manager->flush();
    }
}

