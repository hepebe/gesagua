<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Counter
 *
 * @ORM\Table(name="Contadores")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\CounterRepository")
 * @UniqueEntity(fields={"nContador"}, message="Este número de contador ya está registrado")
 * @ORM\HasLifecycleCallbacks()
 */
class Counter
{
    /**
     * @ORM\OneToMany(targetEntity="Reading", mappedBy="counter")
    */
    
    protected $readings1;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Contract", inversedBy="counters")
     * @ORM\JoinColumn(name="contract_id", referencedColumnName="id", onDelete="CASCADE")
     * @Assert\NotBlank(message="Este campo es obligatorio")
     */
     
    protected $contract;

    /**
     * @var integer
     *
     * @ORM\Column(name="nContador", type="integer")
     * @ORM\Id
     * @Assert\NotBlank(message="Este campo es obligatorio")
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

    public function __construct()
    {
        $this->readings1 = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    /**
     * @ORM\PrePersist 
     */
    public function setactivoValue()
    {
        $this->contract->setActivo(1);
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setinactivoValue()
    {
        $this->contract->setActivo(0);
    }

    /**
     * Add readings1
     *
     * @param \GS\UserBundle\Entity\Reading $readings1
     * @return Counter
     */
    public function addReadings1(\GS\UserBundle\Entity\Reading $readings1)
    {
        $this->readings1[] = $readings1;

        return $this;
    }

    /**
     * Remove readings1
     *
     * @param \GS\UserBundle\Entity\Reading $readings1
     */
    public function removeReadings1(\GS\UserBundle\Entity\Reading $readings1)
    {
        $this->readings1->removeElement($readings1);
    }

    /**
     * Get readings1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReadings1()
    {
        return $this->readings1;
    }
}
