<?php
// src/OC/LeetchifakeBundle/DataFixtures/ORM/typeFixtures.php
namespace OC\LeetchifakeBundle\DataFixtures\ORM;

use OC\LeetchifakeBundle\Entity\type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class typeFixtures  implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0; $i<10; $i++)
        {
            $type = new type();
            $type -> setNom('categorie' .$i);
            $manager -> persist($type);
        }
        $manager -> flush();
    }
}


