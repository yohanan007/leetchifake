<?php
// src/OC/UserBundle/DataFixtures/ORM/UserFixtures.php
namespace OC\UserBundle\DataFixtures\ORM;

use OC\UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class UserFixtures implements FixtureInterface
{
   public function load(ObjectManager $manager)
   {
       
       $date = new \DateTime('1981-10-23');
       $user = new User();
       $user -> setUsername("yohanan");
       $user -> setPassword("231081");
       $user -> setMailUser("yohanan_h@yahoo.fr");
       $user -> setNaissance($date);
       $user -> setRoles(array("ROLE_SUPER_ADMIN"));
       $user -> setSalt('');
       $manager -> persist($user);
       
       for($i=0; $i<10; $i++)
        {
               $user = new User();
               $user -> setUsername("UTILISATEUR" .$i);
               $user -> setPassword("mdp");
               $user -> setMailUser("mdph@mdp.fr" .$i);
               $user -> setNaissance($date);
               $user -> setRoles(array("ROLE_USER"));
               $user -> setSalt('');
               $manager -> persist($user);
        }
        $manager -> flush();
   }
}