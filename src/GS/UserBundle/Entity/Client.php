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
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\ClientRepository") * 
 * @UniqueEntity(fields={"email"}, message="El email ya está registrado")
 */
class Client implements UserInterface
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
     * @ORM\Column(name="apellidos", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $apellidos;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fNacimiento", type="date")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $fNacimiento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sexo", type="string", columnDefinition="ENUM('H','M')")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Email(message="Este correo no es válido(falta @)")
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="telefono", type="integer")
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
     * Set fNacimiento
     *
     * @param \DateTime $fNacimiento
     * @return Client
     */
    public function setFNacimiento($fNacimiento)
    {
        $this->fNacimiento = $fNacimiento;

        return $this;
    }

    /**
     * Get fNacimiento
     *
     * @return \DateTime 
     */
    public function getFNacimiento()
    {
        return $this->fNacimiento;
    }

    /**
     * Set sexo
     *
     * @param boolean $sexo
     * @return Client
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;

        return $this;
    }

    /**
     * Get sexo
     *
     * @return boolean 
     */
    public function getSexo()
    {
        return $this->sexo;
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
     * @param integer $telefono
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
     * @return integer 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set empadronado
     *
     * @param boolean $empadronado
     * @return Client
     */
    public function setEmpadronado($empadronado)
    {
        $this->empadronado = $empadronado;

        return $this;
    }

    /**
     * Get empadronado
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
