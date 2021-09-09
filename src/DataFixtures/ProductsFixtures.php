<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de produit
         
        // produits guitares éléctriques_______________________________________
        $product= new Product();
        $product
            ->setLabel('36012FG')
            ->setShortLabel('GRI 36012FG')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('134697')
            ->setColor('Fire')
            ->setMaterial('Érable')
            ->setService('1')
            ->setDiscount('10')
            ->setImage('build/images/GRI-36012FG.png')
            ->setPrice('3389.00')
            ->setStock('30')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('RICKENBACKER');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('C-1 SILVER MOUNTAIN')
            ->setShortLabel('SCH-C-1-SILVERM-SVM')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('333044')
            ->setColor('Silver')
            ->setMaterial('Ébène')
            ->setService('1')
            ->setDiscount('5')
            ->setImage('build/images/HTD+SCH-C-7-SILVERM-MS.png')
            ->setPrice('1449.00')
            ->setStock('20')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('SCHECTER');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('RG350DXZ-WH WHITE')
            ->setShortLabel('RG350DXZWH')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('112608')
            ->setColor('White')
            ->setMaterial('Meranti')
            ->setService('1')
            ->setDiscount('9')
            ->setImage('build/images/HOSHINO+RG350DXZ+WH.png')
            ->setPrice('452.00')
            ->setStock('20')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('IBANEZ');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('CE24 AMBER')
            ->setShortLabel('CE24AMB')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('255728')
            ->setColor('Amber')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('5')
            ->setImage('build/images/ADAGIO+047468.png')
            ->setPrice('2399.00')
            ->setStock('20')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('PRS - PAUL REED');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('SOUTH STATE SHINY BLACK')
            ->setShortLabel('SOUTH STATE C100 BK')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('258444')
            ->setColor('Black')
            ->setMaterial('Tilleul')
            ->setService('1')
            ->setDiscount(NULL)
            ->setImage('build/images/EAGLETONE+SOUTH+STATE+C100+NOIRE+BRILLANT.png')
            ->setPrice('169.00')
            ->setStock('50')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('EAGLETONE');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('EC1000 BLACK VINTAGE')
            ->setShortLabel('GES EC1000-VBK')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('31548')
            ->setColor('Black')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('10')
            ->setImage('build/images/GES+EC1000+VBK.png')
            ->setPrice('979.00')
            ->setStock('30')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('LTD GUITARS');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('S521-BBS BLACKBERRY')
            ->setShortLabel('S521BBS')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('168540')
            ->setColor('Red')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('8')
            ->setImage('build/images/HOSHINO+S521+BBS.png')
            ->setPrice('399.00')
            ->setStock('30')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('IBANEZ');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('SE SANTANA YELLOW')
            ->setShortLabel('GES EC1000-VBK')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('255789')
            ->setColor('Yellow')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('10')
            ->setImage('build/images/ADAGIO+047255.png')
            ->setPrice('990.74')
            ->setStock('9')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('PRS - PAUL REED SMITH');
        $manager->persist($product);

        // produits guitares classique____________________________________________

        $product= new Product();
        $product
            ->setLabel(' ANDORINHA OP OPEN PORES')
            ->setShortLabel('ANDORINHA OP')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('310372')
            ->setColor('Woodwind')
            ->setMaterial('Cèdre')
            ->setService('1')
            ->setDiscount(NULL)
            ->setImage('build/images/EAGLETONE+ANDORINHA+OP+4QUART.png')
            ->setPrice('189.00')
            ->setStock('30')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('EAGLETONE');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('1/2 SUNBURST CS2-SB')
            ->setShortLabel('GEC CS2-SB')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('344714')
            ->setColor('Woodwind')
            ->setMaterial('Epicéa')
            ->setService('1')
            ->setDiscount('15')
            ->setImage('build/images/GEC+CS2+SB.png')
            ->setPrice('70.00')
            ->setStock('30')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('EKO GUITARS');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('BERIA F7 4/4 12')
            ->setShortLabel('CO017')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('152059')
            ->setColor('Woodwind')
            ->setMaterial('Epicéa')
            ->setService('1')
            ->setDiscount('5')
            ->setImage('build/images/cordoba+CO017.png')
            ->setPrice('539.00')
            ->setStock('20')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('CORDOBA');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('ACS NYLON SA NATUREL SG')
            ->setShortLabel('GO032150')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference(' 50985')
            ->setColor('Woodwind')
            ->setMaterial('Cèdre')
            ->setService('1')
            ->setDiscount('15')
            ->setImage('build/images/godin+ACS-NA.png')
            ->setPrice('1849.00')
            ->setStock('15')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('GODIN');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('IBERIA C5 CET NATURAL 4/4')
            ->setShortLabel('CO015')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('255666')
            ->setColor('Woodwind')
            ->setMaterial('Epicéa')
            ->setService('1')
            ->setDiscount(NULL)
            ->setImage('build/images/cordoba+CO015.png')
            ->setPrice('429.00')
            ->setStock('15')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('CORDOBA');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('SLG200NW NATURAL')
            ->setShortLabel('GSLG200NW')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('237596')
            ->setColor('White')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('5')
            ->setImage('build/images/YAMAHA+GSLG200NW.png')
            ->setPrice('900.00')
            ->setStock('9')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('YAMAHA');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('IBERIA C5 CE BLACK 4/4')
            ->setShortLabel('CO046')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('152048')
            ->setColor('Black')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('7')
            ->setImage('build/images/cordoba+CO046.png')
            ->setPrice('459.00')
            ->setStock('15')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('CORDOBA');
        $manager->persist($product);

        $product= new Product();
        $product
            ->setLabel('CN-60S NYLON WLNT NATURAL')
            ->setShortLabel('CO046')
            ->setDescription('Depuis leur apparition en 1958')
            ->setReference('315294')
            ->setColor('Woodwind')
            ->setMaterial('Acajou')
            ->setService('1')
            ->setDiscount('12')
            ->setImage('build/images/FMIC+0970160521.png')
            ->setPrice('219.00')
            ->setStock('15')
            ->setStockAlert('10')
            ->setActived('1')
            ->setBrand('FENDER');
        $manager->persist($product);

        $manager->flush();
    }
}
