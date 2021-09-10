<?php

namespace App\DataFixtures;

use App\Entity\SubCategory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création des sous-catégories
         
        // catégorie Guitares
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Guitares Electriques')
            ->setBackground('build/images/background_guitare_electrique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Guitare Classiques')
            ->setBackground('build/images/background_guitare_classique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Guitare Acoustiques & Electro-Acoustiques')
            ->setBackground('build/images/background_guitare_acoustique.png');
        $manager->persist($sub_category);
        
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Basse Electriques')
            ->setBackground('build/images/background_basse_electrique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Basse Acoustiques')
            ->setBackground('build/images/background_basse_acoustique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Basse Semi-Acoustiques')
            ->setBackground('build/images/background_basse_semi_acoustique.png');
        $manager->persist($sub_category);
        
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Ukulélés')->setBackground('build/images/background_ukulele.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Autres instruments à cordes pincées')
            ->setBackground('build/images/background_autre.png');
        $manager->persist($sub_category);

        // catégorie Batterie___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Batterie Acoustiques')
            ->setBackground('build/images/background_batterie_acoustique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Batterie Electroniques')
            ->setBackground('build/images/background_batterie_electronique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Caisses claire')
            ->setBackground('build/images/background_marching.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Cymbales')
            ->setBackground('build/images/background_cymbale.png');
        $manager->persist($sub_category);
        
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Marching & fanfare')
            ->setBackground('build/images/background_marching.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Percussions Africaines')
            ->setBackground('build/images/background_percussion_africaine.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Percussions Brésiliennes')
            ->setBackground('build/images/background_percussion_bresilienne.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Percussions orchestre')
            ->setBackground('build/images/background_percussion_orchestre.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Xylophones-carillons')
            ->setBackground('build/images/background_xylophone.png');
        $manager->persist($sub_category);

        // Catégorie Clavier___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Piano Numériques')
            ->setBackground('build/images/background_piano_numerique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Clavier Arrangeurs')
            ->setBackground('build/images/background_clavier_arrangeur.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Clavier Maîtres')
            ->setBackground('build/images/background_clavier_maître.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Orgues')
            ->setBackground('build/images/background_orgues.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Arccodéons')
            ->setBackground('build/images/background_accordeon.png');
        $manager->persist($sub_category);

        // Catégorie Studio___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Microphones')
            ->setBackground('build/images/background_microphone.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Péamplificateurs Studio')
            ->setBackground('build/images/background_preampli_studio.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Controleur daw')
            ->setBackground('build/images/background_daw.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Enceintes Monitoring')
            ->setBackground('build/images/background_monitoring.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Enregisteurs')
            ->setBackground('build/images/background_enregistreur.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Interfaces Audio')
            ->setBackground('build/images/background_interface_audio.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Matériaux de traitement acoustique')
            ->setBackground('build/images/background_materiaux_acoustique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Mobilier de studio')
            ->setBackground('build/images/background_mobilier_studio.png');
        $manager->persist($sub_category);

        // Catégorie Sono___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Ampli de puissance')
            ->setBackground('build/images/background_ampli_puissance.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Ampli base')
            ->setBackground('build/images/background_ampli_basse.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Ampli Electro-Acoustiques')
            ->setBackground('build/images/background_ampli_electro_acoustique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Ampli Guitare Electriques')
            ->setBackground('build/images/background_ampli_electrique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Diffusion')
            ->setBackground('build/images/background_diffusion.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Enceintes Actives')
            ->setBackground('build/images/background_enceinte_active.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Enceintes Passives')
            ->setBackground('build/images/background_enceinte_passive.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Mixage & production')
            ->setBackground('build/images/background_mixage.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Sonorisations Portables')
            ->setBackground('build/images/background_sono_portable.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Périphériques Analogiques')
            ->setBackground('build/images/background_perph_analogique.png');
        $manager->persist($sub_category);

        // Catégorie Eclairage___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Dmx')
            ->setBackground('build/images/background_dmx.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Lasers')
            ->setBackground('build/images/background_laser.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Lumières de soirées')
            ->setBackground('build/images/background_lumiere_soiree.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Lumière Noire')
            ->setBackground('build/images/background_lumiere_noire.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Machine & liquides')
            ->setBackground('build/images/background_machine_liquide.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Projecteurs')
            ->setBackground('build/images/background_projecteur.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Scan & lyres')
            ->setBackground('build/images/background_scan_lyres.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Stroboscopes')
            ->setBackground('build/images/background_stroboscope.png');
        $manager->persist($sub_category);

        // Catégorie DJ___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Casque')
            ->setBackground('build/images/background_casque.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Effets Dj')
            ->setBackground('build/images/background_effet_dj.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Groovebox & Samplers')
            ->setBackground('build/images/background_groover.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Interface pour vinyles timecodés')
            ->setBackground('build/images/background_vinyle_timecode.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Karaoke')
            ->setBackground('build/images/background_vinyle_timecode.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Cellules & Diamants')
            ->setBackground('build/images/background_diamant.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Mixeurs Numériques')
            ->setBackground('build/images/background_mixeur_numerique.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Platines CD')
            ->setBackground('build/images/background_platine_cd.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Platines vinyles')
            ->setBackground('build/images/background_platine_vinyle.png');
        $manager->persist($sub_category);

        // Catégorie Cases___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Cases Batterie & Percusions')
            ->setBackground('build/images/background_case_percussion.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Case Dj')
            ->setBackground('build/images/background_case_dj.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Case Lumières')
            ->setBackground('build/images/background_case_lumiere.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Case Sono')
            ->setBackground('build/images/background_case_sono.png');
        $manager->persist($sub_category);

        // Catégorie Accessoires___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires Guitares')
            ->setBackground('build/images/background_accessoire_guitare.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires Batteries')
            ->setBackground('build/images/background_accessoire_batterie.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires Claviers')
            ->setBackground('build/images/background_accessoire_clavier.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires Vents')
            ->setBackground('build/images/background_accessoire_vent.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires dj-sono-home-studio')
            ->setBackground('build/images/background_accessoire_studio.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Accessoires gérériques')
            ->setBackground('build/images/background_accessoire_generique.png');
        $manager->persist($sub_category);

        // Catégorie Vent___________________________________________________________________________
        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Bugles')
            ->setBackground('build/images/background_bugles.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Clarinette')
            ->setBackground('build/images/background_clarinette.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Cors')
            ->setBackground('build/images/background_cors.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('flûte à bec')
            ->setBackground('build/images/background_flute_bec.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('flûte traversière')
            ->setBackground('build/images/background_flute_traversiere.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Gros cuivre')
            ->setBackground('build/images/background_gros_cuivre.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Harmonica')
            ->setBackground('build/images/background_harmonica.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Saxophone')
            ->setBackground('build/images/background_saxophone.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Trambone')
            ->setBackground('build/images/background_trambone.png.png');
        $manager->persist($sub_category);

        $sub_category= new SubCategory();
        $sub_category
            ->setLabel('Trompette')
            ->setBackground('build/images/background_trompette.png');
        $manager->persist($sub_category);

        $manager->flush();
    }
}
