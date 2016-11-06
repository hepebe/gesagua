<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bill
 *
 * @ORM\Table(name="Facturas")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\BillRepository")
 */
class Bill
{
     /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="bills")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $client;
    
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
     * @var integer
     *
     * @ORM\Column(name="consumo", type="integer")
     */
    private $consumo;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float")
     */
    private $total;


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
     * @param integer $consumo
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
     * @return integer 
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
     * Set client
     *
     * @param \GS\UserBundle\Entity\Client $client
     * @return Bill
     */
    public function setClient(\GS\UserBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \GS\UserBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
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
}
