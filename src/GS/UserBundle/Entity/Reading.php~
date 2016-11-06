<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reading
 *
 * @ORM\Table(name="Lecturas")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\ReadingRepository")
 */
class Reading
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="readings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Counter", inversedBy="readings1")
     * @ORM\JoinColumn(name="counter_id", referencedColumnName="nContador", onDelete="CASCADE")
     */
     
    protected $counter;
    
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
     * @ORM\Column(name="fLectura", type="date")
     */
    private $fLectura;

    /**
     * @var integer
     *
     * @ORM\Column(name="lectura", type="integer")
     */
    private $lectura;


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
     * Set fLectura
     *
     * @param \DateTime $fLectura
     * @return Reading
     */
    public function setFLectura($fLectura)
    {
        $this->fLectura = $fLectura;

        return $this;
    }

    /**
     * Get fLectura
     *
     * @return \DateTime 
     */
    public function getFLectura()
    {
        return $this->fLectura;
    }

    
    /**
     * Set lectura
     *
     * @param integer $lectura
     * @return Reading
     */
    public function setLectura($lectura)
    {
        $this->lectura = $lectura;

        return $this;
    }

    /**
     * Get lectura
     *
     * @return integer 
     */
    public function getLectura()
    {
        return $this->lectura;
    }

    /**
     * Set user
     *
     * @param \GS\UserBundle\Entity\User $user
     * @return Reading
     */
    public function setUser(\GS\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GS\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set counter
     *
     * @param \GS\UserBundle\Entity\Counter $counter
     * @return Reading
     */
    public function setCounter(\GS\UserBundle\Entity\Counter $counter = null)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Get counter
     *
     * @return \GS\UserBundle\Entity\Counter 
     */
    public function getCounter()
    {
        return $this->counter;
    }
}
