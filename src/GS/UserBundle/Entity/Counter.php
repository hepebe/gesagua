<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Counter
 *
 * @ORM\Table(name="Contadores")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\CounterRepository")
 */
class Counter
{
     /**
     * @ORM\ManyToOne(targetEntity="Contract", inversedBy="counters")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $contract;
    

    /**
     * @var integer
     *
     * @ORM\Column(name="nContador", type="integer")
     * @ORM\Id
     */
    private $nContador;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fAlta", type="date")
     */
    private $fAlta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fBaja", type="date")
     */
    private $fBaja;


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
     * Set nContador
     *
     * @param integer $nContador
     * @return Counter
     */
    public function setNContador($nContador)
    {
        $this->nContador = $nContador;

        return $this;
    }

    /**
     * Get nContador
     *
     * @return integer 
     */
    public function getNContador()
    {
        return $this->nContador;
    }

    /**
     * Set fAlta
     *
     * @param \DateTime $fAlta
     * @return Counter
     */
    public function setFAlta($fAlta)
    {
        $this->fAlta = $fAlta;

        return $this;
    }

    /**
     * Get fAlta
     *
     * @return \DateTime 
     */
    public function getFAlta()
    {
        return $this->fAlta;
    }

    /**
     * Set fBaja
     *
     * @param \DateTime $fBaja
     * @return Counter
     */
    public function setFBaja($fBaja)
    {
        $this->fBaja = $fBaja;

        return $this;
    }

    /**
     * Get fBaja
     *
     * @return \DateTime 
     */
    public function getFBaja()
    {
        return $this->fBaja;
    }

    /**
     * Set contract
     *
     * @param \GS\UserBundle\Entity\Contract $contract
     * @return Counter
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
