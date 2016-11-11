<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Incidence
 *
 * @ORM\Table(name="Incidencias")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\IncidenceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Incidence
{
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="incidences")
     * @ORM\JoinColumn(name="userReg_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $userReg;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="incidences1")
     * @ORM\JoinColumn(name="userRes_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $userRes;
    
    /**
     * @ORM\ManyToOne(targetEntity="Contract", inversedBy="incidences2")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $contract;
    
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
     * @ORM\Column(name="tipo", type="string", columnDefinition="ENUM('Parado','Cambio de contador','Avería fontanero','Consumo elevado','Manipulado', 'Consumo negativo', 'Cambio de dirección', 'Colocar contador')", length=255)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="gravedad", type="string", columnDefinition="ENUM('Alta','Media', 'Baja')", length=255)
     */
    private $gravedad;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="string", columnDefinition="ENUM('Pendiente','Resuelto')")
     */
    private $estado;

    /**
     * @var \Date
     *
     * @ORM\Column(name="fIncidencia", type="date")
     */
    private $fIncidencia;

    /**
     * @var string
     *
     * @ORM\Column(name="información", type="string", length=255)
     */
    private $informacion;

    /**
     * @var string
     *
     * @ORM\Column(name="resolucion", type="string", length=255)
     */
    private $resolucion;


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
     * Set tipo
     *
     * @param string $tipo
     * @return Incidence
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
     * Set gravedad
     *
     * @param string $gravedad
     * @return Incidence
     */
    public function setGravedad($gravedad)
    {
        $this->gravedad = $gravedad;

        return $this;
    }

    /**
     * Get gravedad
     *
     * @return string 
     */
    public function getGravedad()
    {
        return $this->gravedad;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return Incidence
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fIncidencia
     *
     * @param \DateTime $fIncidencia
     * @return Incidence
     */
    public function setFIncidencia($fIncidencia)
    {
        $this->fIncidencia = $fIncidencia;

        return $this;
    }

    /**
     * Get fIncidencia
     *
     * @return \DateTime 
     */
    public function getFIncidencia()
    {
        return $this->fIncidencia;
    }

    /**
     * Set informacion
     *
     * @param string $informacion
     * @return Incidence
     */
    public function setInformacion($informacion)
    {
        $this->informacion = $informacion;

        return $this;
    }

    /**
     * Get informacion
     *
     * @return string 
     */
    public function getInformacion()
    {
        return $this->informacion;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     * @return Incidence
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string 
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }

    /**
     * Set userReg
     *
     * @param \GS\UserBundle\Entity\User $userReg
     * @return Incidence
     */
    public function setUserReg(\GS\UserBundle\Entity\User $userReg = null)
    {
        $this->userReg = $userReg;

        return $this;
    }

    /**
     * Get userReg
     *
     * @return \GS\UserBundle\Entity\User 
     */
    public function getUserReg()
    {
        return $this->userReg;
    }

    /**
     * Set userRes
     *
     * @param \GS\UserBundle\Entity\User $userRes
     * @return Incidence
     */
    public function setUserRes(\GS\UserBundle\Entity\User $userRes = null)
    {
        $this->userRes = $userRes;

        return $this;
    }

    /**
     * Get userRes
     *
     * @return \GS\UserBundle\Entity\User 
     */
    public function getUserRes()
    {
        return $this->userRes;
    }

    /**
     * Set contract
     *
     * @param \GS\UserBundle\Entity\Contract $contract
     * @return Incidence
     */
    public function setContract(\GS\UserBundle\Entity\Contract $contract = null)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \GS\UserBundle\Entity\Contract 
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * @ORM\PrePersist 
     */
    public function setFIncidenciaValue()
    {
        $this->fIncidencia = new \DateTime();
    }
}
