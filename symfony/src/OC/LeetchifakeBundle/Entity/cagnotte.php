<?php

namespace OC\LeetchifakeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * cagnotte
 *
 * @ORM\Table(name="oc_cagnotte")
 * @ORM\Entity(repositoryClass="OC\LeetchifakeBundle\Repository\cagnotteRepository")
 */
class cagnotte
{
    
    /**
     * @ORM\ManyToMany(targetEntity="OC\LeetchifakeBundle\Entity\Don", cascade={"persist"})
     * @ORM\JoinTable(name="oc_cagnotte_don")
     */
     private $dons;
    
    
   /**
    * @ORM\ManyToOne(targetEntity="OC\UserBundle\Entity\User", inversedBy="cagnottes")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
    */
    private $user;
    

    /**
     * @ORM\OneToOne(targetEntity="OC\LeetchifakeBundle\Entity\Image", cascade={"persist","remove"})
     */
     private $image;
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

   

    /**
     * @var string
     *
     * @ORM\Column(name="sommetotal", type="string", length=255)
     */
    private $sommetotal;
    
     /**
     * @ORM\ManyToMany(targetEntity="OC\LeetchifakeBundle\Entity\type", cascade={"persist"})
     * @ORM\JoinTable(name="oc_cagnotte_type")
     */
    private $types;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="oc_confirme", type="boolean", nullable=true)
     */
     private $confirme;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return cagnotte
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return cagnotte
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

   

    /**
     * Set sommetotal
     *
     * @param string $sommetotal
     *
     * @return cagnotte
     */
    public function setSommetotal($sommetotal)
    {
        $this->sommetotal = $sommetotal;

        return $this;
    }

    /**
     * Get sommetotal
     *
     * @return string
     */
    public function getSommetotal()
    {
        return $this->sommetotal;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dons = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \Datetime();
    }

    /**
     * Set image
     *
     * @param \OC\LeetchifakeBundle\Entity\Image $image
     *
     * @return cagnotte
     */
    public function setImage(\OC\LeetchifakeBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\LeetchifakeBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add type
     *
     * @param \OC\LeetchifakeBundle\Entity\type $type
     *
     * @return cagnotte
     */
    public function addType(\OC\LeetchifakeBundle\Entity\type $type)
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * Remove type
     *
     * @param \OC\LeetchifakeBundle\Entity\type $type
     */
    public function removeType(\OC\LeetchifakeBundle\Entity\type $type)
    {
        $this->types->removeElement($type);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Set user
     *
     * @param \OC\UserBundle\Entity\User $user
     *
     * @return cagnotte
     */
    public function setUser(\OC\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \OC\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Add don
     *
     * @param \OC\LeetchifakeBundle\Entity\Don $don
     *
     * @return cagnotte
     */
    public function addDon(\OC\LeetchifakeBundle\Entity\Don $don)
    {
        $this->dons[] = $don;

        return $this;
    }

    /**
     * Remove don
     *
     * @param \OC\LeetchifakeBundle\Entity\Don $don
     */
    public function removeDon(\OC\LeetchifakeBundle\Entity\Don $don)
    {
        $this->dons->removeElement($don);
    }

    /**
     * Get dons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDons()
    {
        return $this->dons;
    }
    

    /**
     * Set confirme
     *
     * @param boolean $confirme
     *
     * @return cagnotte
     */
    public function setConfirme($confirme)
    {
        $this->confirme = $confirme;

        return $this;
    }

    /**
     * Get confirme
     *
     * @return boolean
     */
    public function getConfirme()
    {
        return $this->confirme;
    }
}
