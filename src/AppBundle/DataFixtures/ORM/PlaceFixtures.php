<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Place;
use AppBundle\Entity\Price;
use AppBundle\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlaceFixtures extends Fixture
{
    public function Load(ObjectManager $manager)
    {
        // Tour Eiffel
        $eiffel = new Place();
        $eiffel->setName("Tour Eiffel");
        $eiffel->setAddress("5 Avenue Anatole France, 75007 Paris");
        // Prix
        $eiffelPrice1 = new Price();
        $eiffelPrice1->setType("less_than_12");
        $eiffelPrice1->setValue(6.30);
        $eiffelPrice1->setPlace($eiffel);
        $manager->persist($eiffelPrice1);
        $eiffelPrice2 = new Price();
        $eiffelPrice2->setType("for_all");
        $eiffelPrice2->setValue(25);
        $eiffelPrice2->setPlace($eiffel);
        $manager->persist($eiffelPrice2);
        // Themes
        $themeEiffel1 = new Theme();
        $themeEiffel1->setName("architecture");
        $themeEiffel1->setValue(7);
        $themeEiffel1->setPlace($eiffel);
        $manager->persist($themeEiffel1);
        $themeEiffel2 = new Theme();
        $themeEiffel2->setName("history");
        $themeEiffel2->setValue(6);
        $themeEiffel2->setPlace($eiffel);
        $manager->persist($themeEiffel2);
        
        $manager->persist($eiffel);
        
        
        // Musée du Louvre
        $louvre = new Place();
        $louvre->setName("Musée du Louvre");
        $louvre->setAddress("799, rue de Rivoli, 75001 Paris");
        // Prix
        $louvrePrice = new Price();
        $louvrePrice->setType("for_all");
        $louvrePrice->setValue(15);
        $louvrePrice->setPlace($louvre);
        $manager->persist($louvrePrice);
        // Themes
        $themeLouvre1 = new Theme();
        $themeLouvre1->setName("architecture");
        $themeLouvre1->setValue(7);
        $themeLouvre1->setPlace($louvre);
        $manager->persist($themeLouvre1);
        $themeLouvre2 = new Theme();
        $themeLouvre2->setName("art");
        $themeLouvre2->setValue(8);
        $themeLouvre2->setPlace($louvre);
        $manager->persist($themeLouvre2);
        
        $manager->persist($louvre);
        
        
        // Le Mont St Michel
        $montStMichel = new Place();
        $montStMichel->setName("Mont Saint Michel");
        $montStMichel->setAddress("50170 LE MONT SAINT MICHEL");
        // Themes
        $montStMichelTheme1 = new Theme();
        $montStMichelTheme1->setName("history");
        $montStMichelTheme1->setValue(3);
        $montStMichelTheme1->setPlace($montStMichel);
        $manager->persist($montStMichelTheme1);
        $montStMichelTheme2 = new Theme();
        $montStMichelTheme2->setName("art");
        $montStMichelTheme2->setValue(7);
        $montStMichelTheme2->setPlace($montStMichel);
        $manager->persist($montStMichelTheme2);
        
        $manager->persist($montStMichel);
        
        
        // DisneyLand Paris
        $disneyLand = new Place();
        $disneyLand->setName("DisneyLand Paris");
        $disneyLand->setAddress("77777 Marne-la-Vallée");
        $manager->persist($disneyLand);
        
        // Europa Park
        $europaPark = new Place();
        $europaPark->setName("Europa Park");
        $europaPark->setAddress("77977 Rust, ALLEMAGNE");
        // Prix 
        $europaParkPrice1 = new Price();
        $europaParkPrice1->setType("less_than_12");
        $europaParkPrice1->setValue(42.50);
        $europaParkPrice1->setPlace($europaPark);
        $manager->persist($europaParkPrice1);
        $europaParkPrice2 = new Price();
        $europaParkPrice2->setType("for_all");
        $europaParkPrice2->setValue(49.50);
        $europaParkPrice2->setPlace($europaPark);
        $manager->persist($europaParkPrice2);
        
        $manager->persist($europaPark);
        
        
        // Ecriture en BdD
        $manager->flush();

    }
}
