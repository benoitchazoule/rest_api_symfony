<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use AppBundle\Entity\Preference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ContainerAwareInterface
{
    protected $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    
    public function Load(ObjectManager $manager)
    {
        // Encoder password
        $encoder = $this->container->get('security.password_encoder');
        
        // User test
        $testUser = new User();
        $testUser->setFirstname("Test");
        $testUser->setLastname("Pass");
        $testUser->setEmail("test.pass@test.local");
        $testUser->setPlainPassword("test");
        $testUserEncodedPass = $encoder->encodePassword($testUser, $testUser->getPlainPassword());
        $testUser->setPassword($testUserEncodedPass);
        // Preference
        $testUserPreference1 = new Preference();
        $testUserPreference1->setName("history");
        $testUserPreference1->setValue(4);
        $testUserPreference1->setUser($testUser);
        $manager->persist($testUserPreference1);
        $testUserPreference2 = new Preference();
        $testUserPreference2->setName("art");
        $testUserPreference2->setValue(4);
        $testUserPreference2->setUser($testUser);
        $manager->persist($testUserPreference2);
        $testUserPreference3 = new Preference();
        $testUserPreference3->setName("sport");
        $testUserPreference3->setValue(3);
        $testUserPreference3->setUser($testUser);
        $manager->persist($testUserPreference3);
        
        $manager->persist($testUser);
        
        
        // User John Smith
        $johnUser = new User();
        $johnUser->setFirstname("John");
        $johnUser->setLastname("Smith");
        $johnUser->setEmail("john.smith@test.local");
        $johnUser->setPlainPassword("john");
        $johnUserEncodedPass = $encoder->encodePassword($johnUser, $johnUser->getPlainPassword());
        $johnUser->setPassword($johnUserEncodedPass);
        $manager->persist($johnUser);
        
        
        // User vador
        $vadorUser = new User();
        $vadorUser->setFirstname("Dark");
        $vadorUser->setLastname("Vador");
        $vadorUser->setEmail("dark.vador@test.local");
        $vadorUser->setPlainPassword("dark");
        $vadorUserEncodedPass = $encoder->encodePassword($vadorUser, $vadorUser->getPlainPassword());
        $vadorUser->setPassword($vadorUserEncodedPass);
        // Preference
        $vadorUserPreference1 = new Preference();
        $vadorUserPreference1->setName("architecture");
        $vadorUserPreference1->setValue(7);
        $vadorUserPreference1->setUser($vadorUser);
        $manager->persist($vadorUserPreference1);
        $vadorUserPreference2 = new Preference();
        $vadorUserPreference2->setName("sport");
        $vadorUserPreference2->setValue(5);
        $vadorUserPreference2->setUser($vadorUser);
        $manager->persist($vadorUserPreference2);
        
        $manager->persist($vadorUser);
        
        
        // Ecriture en BdD
        $manager->flush();

    }
    
}
