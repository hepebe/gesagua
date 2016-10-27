<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Zone
 *
 * @ORM\Table(name="Zonas")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\ZoneRepository") 
 * @UniqueEntity(fields={"nombre"}, message="El nombre ya está registrado")
 */
class Zone implements UserInterface
{
    /**
     * @ORM\OneToMany(targetEntity="Street", mappedBy="zone")
    */
    
    protected $streets;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="municipio", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $municipio;

    /**
     * @var integer
     *
     * @ORM\Column(name="inicio", type="integer")
     */
    private $inicio;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Zone
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set municipio
     *
     * @param string $municipio
     * @return Zone
     */
    public function setMunicipio($municipio)
    {
        $this->municipio = $municipio;

        return $this;
    }

    /**
     * Get municipio
     *
     * @return string 
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }
    
    /**
     * Set inicio
     *
     * @param integer $inicio
     * @return Zone
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return integer 
     */
    public function getInicio()
    {
        return $this->inicio;
    }
    
    public function __construct()
    {
        $this->streets =  new ArrayCollection();
    }
    
    public function getPassword()
    {
        
    }
    
    public function getUsername()
    {
        
    }
    
    public function getRoles()
    {
       
    }
    
    public function getSalt()
    {
       
    }
    
    public function eraseCredentials()
    {
        
    }

    /**
     * Add streets
     *
     * @param \GS\UserBundle\Entity\Street $streets
     * @return Zone
     */
    public function addStreet(\GS\UserBundle\Entity\Street $streets)
    {
        $this->streets[] = $streets;

        return $this;
    }

    /**
     * Remove streets
     *
     * @param \GS\UserBundle\Entity\Street $streets
     */
    public function removeStreet(\GS\UserBundle\Entity\Street $streets)
    {
        $this->streets->removeElement($streets);
    }

    /**
     * Get streets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStreets()
    {
        return $this->streets;
    }
    
    public function getfullzone()
    {
        return $this-> nombre . " " . $this->municipio;
    }
}
