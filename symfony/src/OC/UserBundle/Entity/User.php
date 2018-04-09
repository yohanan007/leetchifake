<?php

namespace OC\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="oc_user")
 * @ORM\Entity(repositoryClass="OC\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\OneToMany(targetEntity="OC\LeetchifakeBundle\Entity\cagnotte", mappedBy="user")
     */
     private $cagnottes;

    
    protected $salt;

   
    
    public function __construct()
    {
         $this->cagnottes = new ArrayCollection();
        parent::__construct();
       
    }

    
    
    public function eraseCredentials()
    {
 
    }

    


    /**
     * Add cagnotte
     *
     * @param \OC\LeetchifakeBundle\Entity\cagnotte $cagnotte
     *
     * @return User
     */
    public function addCagnotte(\OC\LeetchifakeBundle\Entity\cagnotte $cagnotte)
    {
        $this->cagnottes[] = $cagnotte;

        return $this;
    }

    /**
     * Remove cagnotte
     *
     * @param \OC\LeetchifakeBundle\Entity\cagnotte $cagnotte
     */
    public function removeCagnotte(\OC\LeetchifakeBundle\Entity\cagnotte $cagnotte)
    {
        $this->cagnottes->removeElement($cagnotte);
    }

    /**
     * Get cagnottes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCagnottes()
    {
        return $this->cagnottes;
    }
}
