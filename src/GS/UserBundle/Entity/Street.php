<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Street
 *
 * @ORM\Table(name="Calles")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\StreetRepository") 
 * @UniqueEntity(fields={"nombre"}, message="El nombre ya está registrado")
 */
class Street 
{
    /**
     * @ORM\ManyToOne(targetEntity="Zone", inversedBy="streets")
     * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $zone;
    
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
     * @return Street
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
     * Set zone
     *
     * @param \GS\UserBundle\Entity\Zone $zone
     * @return Street
     */
    public function setZone(\GS\UserBundle\Entity\Zone $zone = null)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return \GS\UserBundle\Entity\Zone 
     */
    public function getZone()
    {
        return $this->zone;
    }
    
}
