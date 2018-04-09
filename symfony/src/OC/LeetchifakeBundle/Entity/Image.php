<?php

namespace OC\LeetchifakeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="oc_image")
 * @ORM\Entity(repositoryClass="OC\LeetchifakeBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
    
     /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    
    
    
    private $file; 
    
    private $tempFilename;
    
    public function getFile()
    {
        return $this->file;
    }
    
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        
        // on verifie si on avait deja un fichier pour cette entité
        if (null !== $this->url)
        {
            // on sauvegarde l'extension du fichier pour le supprimer plus tard 
            $this -> tempFilename = $this->url;
            // on réinitialise les attributs url et alt du fichier
            $this->url = null;
            $this->alt = null;
        }
    }


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
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        // si jamais il n'y a pas de fichier
        if (null === $this->file)
        {
            return;
        }
        // le nom du fichier est son id , on doit juste stocker egalemnt son extension
        // pour faire propre , on devrait renommer cet attribut en "extension", plutôt que "url"
        $this->url = $this->file->guessExtension();
        // et on genere la valeur de l'attribt alt de la balise <img>, à la valeur du nom de fichier sur le pc de l'internaute
        $this->alt = $this->file->getClientOriginalName();
    }
    
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * 
     */
    public function upload()
    {
                    if (null === $this->file)
                    {
                        // si il n'y a pas de fichier on ne fait rien
                        return;
                    }
    
    // si on avait un ancien fichier on le supprime 
    
                if (null !== $this->tempFilename)
                {
                    $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
                    if (file_exists($oldFile)){
                        unlink($oldFile);
                    }
                }
                
        
                    
                        $this->file->move($this->getUploadRootDir(),//le repertoire de destinantion
                        $this->id.'.'.$this->url);// le nom du fichier à créer, ici  "id.extension"
    } 
    
    /**
     * @ORM\PreRemove()
     */ 
     public function preRemoveUpload()
     {
         //on sauvegarde temporairement le nom du fichier, car il depend de l'id
         $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
     }
    
    
    /**
     * @ORM\PostRemove()
     */ 
     public function removeUpload()
     {
        //en PostRemove on n'a pas accés à l'id, on utilise notre nom sauvegardé
        if (file_exists($this->tempFilename))
        {
            // on supprime le fichier
            unlink($this->tempFilename);
        }
     }
     
     public function getWebPath()
     {
         return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
     }
     
    public function getUploadDir()
    {
        // on retourne le chemi relatif vers l'image pour un navigateur
        return 'uploads/img';
    }
    
    protected function getUploadRootDir()
    {
        // on retourne le chemin relatif vers l'image pour notre code php
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
}
