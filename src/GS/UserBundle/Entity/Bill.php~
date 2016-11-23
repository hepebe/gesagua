<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bill
 *
 * @ORM\Table(name="Facturas")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\BillRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Bill
{
    /**
     * @ORM\ManyToOne(targetEntity="Contract", inversedBy="bills1")
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
     * @var \DateTime
     *
     * @ORM\Column(name="fFactura", type="date")
     */
    private $fFactura;

    /**
     * @var float
     *
     * @ORM\Column(name="consumo", type="float")
     */
    private $consumo;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="string", columnDefinition="ENUM('Pendiente','Cobrado')")
     */
    private $estado;
    
    

    /**
     * @var float
     *
     * @ORM\Column(name="lectActual", type="float")
     */
    private $lectActual;
    
    /**
     * @var float
     *
     * @ORM\Column(name="lectAnterior", type="float")
     */
    private $lectAnterior;

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
     * Set fFactura
     *
     * @param \DateTime $fFactura
     * @return Bill
     */
    public function setFFactura($fFactura)
    {
        $this->fFactura = $fFactura;

        return $this;
    }

    /**
     * Get fFactura
     *
     * @return \DateTime 
     */
    public function getFFactura()
    {
        return $this->fFactura;
    }

    /**
     * Set consumo
     *
     * @param float $consumo
     * @return Bill
     */
    public function setConsumo($consumo)
    {
        $this->consumo = $consumo;

        return $this;
    }

    /**
     * Get consumo
     *
     * @return float 
     */
    public function getConsumo()
    {
        return $this->consumo;
    }

    /**
     * Set total
     *
     * @param float $total
     * @return Bill
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set contract
     *
     * @param \GS\UserBundle\Entity\Contract $contract
     * @return Bill
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
     * Set estado
     *
     * @param boolean $estado
     * @return Bill
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
     * @ORM\PrePersist 
     */
    public function setfFacturaValue()
    {
        $this->fFactura = new \DateTime();
    }
    
    /**
     * @ORM\PrePersist 
     */
    public function setestadodefaultValue()
    {
        $this->setEstado('Pendiente');
    }

    /**
     * Set lectActual
     *
     * @param float $lectActual
     * @return Bill
     */
    public function setLectActual($lectActual)
    {
        $this->lectActual = $lectActual;

        return $this;
    }

    /**
     * Get lectActual
     *
     * @return float 
     */
    public function getLectActual()
    {
        return $this->lectActual;
    }

    /**
     * Set lectAnterior
     *
     * @param float $lectAnterior
     * @return Bill
     */
    public function setLectAnterior($lectAnterior)
    {
        $this->lectAnterior = $lectAnterior;

        return $this;
    }

    /**
     * Get lectAnterior
     *
     * @return float 
     */
    public function getLectAnterior()
    {
        return $this->lectAnterior;
    }
}
