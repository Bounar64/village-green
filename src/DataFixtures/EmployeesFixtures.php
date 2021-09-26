<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Employee;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EmployeesFixtures extends Fixture
{
    public function __construct(UserPasswordHasherInterface $hasher) {
        
        $this->hasher= $hasher;
    }
    
    public function load(ObjectManager $manager)
    {
         // On utilise Factory pour créer une instance Faker\Generator 
         $faker= Factory::create('fr_FR');

         $employee= new Employee();

         // Création de l'admin
         $employee
                ->setRoles(["ROLE_ADMIN"])
                ->setSocialSecurityNumber($faker->numberBetween(100000000000000, 200000000000000))
                ->setFirstName('John')
                ->setLastName('Doe')
                ->setEmail('JohnDoeAdmin@gmail.com')
                ->setSex(1)
                ->setMaritalStatus('marier')
                ->setDependentChild(1)
                ->setDegree('BAC+3')
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setZipCode($faker->postcode)
                ->setPhone($faker->phoneNumber)
                ->setSalary(('5000.00'))
                ->setRib($faker->iban('FR'))
                ->setFirstNameContactPerson($faker->firstName)
                ->setLastNameContactPerson($faker->lastName)
                ->setAddressContactPerson($faker->address)
                ->setZipCodeContactPerson($faker->postcode)
                ->setCountryContactPerson('FR')     
                ->setPhoneContactPerson($faker->phoneNumber)
                ->setPassword($this->hasher->hashPassword($employee, 'secret'));

            $manager->persist($employee);



         for($i= 0; $i < 20; $i++) {

            // Création des employées
            $employee= new Employee();

            $employee
                ->setRoles(["ROLE_USER"])
                ->setSocialSecurityNumber($faker->numberBetween(100000000000000, 200000000000000))
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setSex($faker->numberBetween(0, 1))
                ->setMaritalStatus('marier')
                ->setDependentChild($faker->numberBetween(0, 5))
                ->setDegree('BAC+3')
                ->setAddress($faker->address)
                ->setCity($faker->city)
                ->setZipCode($faker->postcode)
                ->setPhone($faker->phoneNumber)
                ->setSalary('2000.00')
                ->setRib($faker->iban('FR'))
                ->setFirstNameContactPerson($faker->firstName)
                ->setLastNameContactPerson($faker->lastName)
                ->setAddressContactPerson($faker->address)
                ->setZipCodeContactPerson($faker->postcode)
                ->setCountryContactPerson('FR')     
                ->setPhoneContactPerson($faker->phoneNumber)
                ->setPassword($this->hasher->hashPassword($employee, 'password'));

            $manager->persist($employee);
        }

        $manager->flush();
    }
}
