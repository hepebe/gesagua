<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Client
 *
 * @ORM\Table(name="Clientes")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\ClientRepository") 
 * @UniqueEntity(fields={"email"}, message="El email ya está registrado")
 */
class Client implements UserInterface
{
   /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="client")
    */
    protected $bills;
   
    /**
     * @ORM\OneToMany(targetEntity="Claims", mappedBy="client")
    */
    protected $claimss;
    
    /**
     * @ORM\OneToMany(targetEntity="Contract", mappedBy="client")
    */
    protected $contracts1;
    
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
     * @ORM\Column(name="apellidos", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Email(message="Este correo no es válido(falta @)")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $telefono;

    /**
     * @var boolean
     *
     * @ORM\Column(name="empadronado", type="string", columnDefinition="ENUM('Sí','No')")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $empadronado;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $direccion;


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
     * @return Client
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Client
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Client
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set empradronado
     *
     * @param boolean $empradronado
     * @return Client
     */
    public function setEmpadronado($empradronado)
    {
        $this->empadronado = $empradronado;

        return $this;
    }

    /**
     * Get empradronado
     *
     * @return boolean 
     */
    public function getEmpadronado()
    {
        return $this->empadronado;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Client
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
    
    public function __construct()
    {
        $this->claimss =  new \Doctrine\Common\Collections\ArrayCollection();
        $this->contracts1 =  new \Doctrine\Common\Collections\ArrayCollection();
        $this->bills =  new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add claimss
     *
     * @param \GS\UserBundle\Entity\Claims $claimss
     * @return Client
     */
    public function addClaimss(\GS\UserBundle\Entity\Claims $claimss)
    {
        $this->claimss[] = $claimss;

        return $this;
    }

    /**
     * Remove claimss
     *
     * @param \GS\UserBundle\Entity\Claims $claimss
     */
    public function removeClaimss(\GS\UserBundle\Entity\Claims $claimss)
    {
        $this->claimss->removeElement($claimss);
    }

    /**
     * Get claimss
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClaimss()
    {
        return $this->claimss;
    }
    
    public function getfullclient()
    {
        return $this-> nombre . " " . $this->apellidos;
    }

    /**
     * Add contracts1
     *
     * @param \GS\UserBundle\Entity\Contract $contracts1
     * @return Client
     */
    public function addContracts1(\GS\UserBundle\Entity\Contract $contracts1)
    {
        $this->contracts1[] = $contracts1;

        return $this;
    }

    /**
     * Remove contracts1
     *
     * @param \GS\UserBundle\Entity\Contract $contracts1
     */
    public function removeContracts1(\GS\UserBundle\Entity\Contract $contracts1)
    {
        $this->contracts1->removeElement($contracts1);
    }

    /**
     * Get contracts1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContracts1()
    {
        return $this->contracts1;
    }

    /**
     * Add bills
     *
     * @param \GS\UserBundle\Entity\Bill $bills
     * @return Client
     */
    public function addBill(\GS\UserBundle\Entity\Bill $bills)
    {
        $this->bills[] = $bills;

        return $this;
    }

    /**
     * Remove bills
     *
     * @param \GS\UserBundle\Entity\Bill $bills
     */
    public function removeBill(\GS\UserBundle\Entity\Bill $bills)
    {
        $this->bills->removeElement($bills);
    }

    /**
     * Get bills
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills()
    {
        return $this->bills;
    }
}
