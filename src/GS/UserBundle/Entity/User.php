<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="Usuarios")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\UserRepository")
 * @UniqueEntity(fields={"usuario"}, message="El usuario ya está registrado")
 * @UniqueEntity(fields={"email"}, message="El email ya está registrado")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @ORM\Column(name="Nombre", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="Apellidos", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $apellidos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FNacimiento", type="date")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $fNacimiento;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Sexo", type="string", columnDefinition="ENUM('H','M')")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $sexo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Email(message="Este correo no es válido(falta @)")
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="Telefono", type="integer")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="Tipo", type="string", columnDefinition="ENUM('Gestor','Administrador','Lecturista','Fontanero','Auxiliar')", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     * @Assert\Choice(choices={"Gestor","Administrador","Lecturista","Fontanero","Auxiliar"})
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="Usuario", type="string", length=255)
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    private $password;


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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * Set tipo
     *
     * @param string $tipo
     * @return User
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return User
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getUsername()
    {
        return $this->usuario;
    }
    
    public function getRoles()
    {
       return array($this->tipo); 
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
        
    }
    
     /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->usuario,
            $this->password
        ));
    }
    
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->usuario,
            $this->password
        ) = unserialize($serialized);
    } 
    
     public function isAccountNonExpired()
    {
        return true;
    }
    
    public function isAccountNonLocked()
    {
        return true;
    }
    
    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    public function isEnabled()
    {
        return true;
    }
}
