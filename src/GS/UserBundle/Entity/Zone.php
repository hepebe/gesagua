<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
}
