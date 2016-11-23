<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contract
 *
 * @ORM\Table(name="Contratos")
 * @ORM\Entity(repositoryClass="GS\UserBundle\Entity\ContractRepository")
 * @UniqueEntity(
 *     fields={"street", "nVivienda"},
 *     message="Esta dirección ya tiene un contrato registrado."
 * )
 * @ORM\HasLifecycleCallbacks()
 */
class Contract
{
    /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="contract")
    */
    
    protected $bills1;
    
    /**
     * @ORM\OneToMany(targetEntity="Incidence", mappedBy="contract")
    */
    
    protected $incidences2;
    
    /**
     * @ORM\ManyToOne(targetEntity="Street", inversedBy="contracts")
     * @ORM\JoinColumn(name="street_id", referencedColumnName="id", onDelete="CASCADE")
     */
     
    protected $street;
    
   
    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="contracts1")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", onDelete="CASCADE")     
     */
     
    protected $client;
    
    /**
     * @ORM\OneToMany(targetEntity="Counter", mappedBy="contract")
    */
    
    protected $counters;
    

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="nVivienda", type="integer")
     */
    private $nVivienda;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var integer
     *
     * @ORM\Column(name="next", type="integer")
     */
    private $next;

    /**
     * @var string
     *
     * @ORM\Column(name="tarifa", type="string", columnDefinition="ENUM('Consumo doméstico','Consumo industrial','Consumo construcciones', 'Consumo municipal')")  
     */
    private $tarifa;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fultimaFactura", type="date")
     */
    private $fultimaFactura;
    
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
     * Set nVivienda
     *
     * @param integer $nVivienda
     * @return Contract
     */
    public function setNVivienda($nVivienda)
    {
        $this->nVivienda = $nVivienda;

        return $this;
    }

    /**
     * Get nVivienda
     *
     * @return integer 
     */
    public function getNVivienda()
    {
        return $this->nVivienda;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Contract
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * Set next
     *
     * @param integer $next
     * @return Contract
     */
    public function setNext($next)
    {
        $this->next = $next;

        return $this;
    }

    /**
     * Get next
     *
     * @return integer 
     */
    public function getNext()
    {
        return $this->next;
    }
    
    /**
     * Set tarifa
     *
     * @param string $tarifa
     * @return Bill
     */
    public function setTarifa($tarifa)
    {
        $this->tarifa = $tarifa;

        return $this;
    }

    /**
     * Get tarifa
     *
     * @return string 
     */
    public function getTarifa()
    {
        return $this->tarifa;
    }
    
    /**
     * Set fultimaFactura
     *
     * @param \DateTime $fultimaFactura
     * @return Zone
     */
    public function setFultimaFactura($fultimaFactura)
    {
        $this->fultimaFactura = $fultimaFactura;

        return $this;
    }

    /**
     * Get fultimaFactura
     *
     * @return \DateTime 
     */
    public function getFultimaFactura()
    {
        return $this->fultimaFactura;
    }
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->counters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->incidences2 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bills1 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set street
     *
     * @param \GS\UserBundle\Entity\Street $street
     * @return Contract
     */
    public function setStreet(\GS\UserBundle\Entity\Street $street = null)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return \GS\UserBundle\Entity\Street 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set client
     *
     * @param \GS\UserBundle\Entity\Client $client
     * @return Contract
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
     * Add counters
     *
     * @param \GS\UserBundle\Entity\Counter $counters
     * @return Contract
     */
    public function addCounter(\GS\UserBundle\Entity\Counter $counters)
    {
        $this->counters[] = $counters;

        return $this;
    }

    /**
     * Remove counters
     *
     * @param \GS\UserBundle\Entity\Counter $counters
     */
    public function removeCounter(\GS\UserBundle\Entity\Counter $counters)
    {
        $this->counters->removeElement($counters);
    }

    /**
     * Get counters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCounters()
    {
        return $this->counters;
    }
    
    public function getfullcontract()
    {
        return $this->id . "- " . $this->street->getfullstreet() . " " . $this->nVivienda;
    }

    /**
     * @ORM\PrePersist 
     */
    public function setactivodefaultValue()
    {
        $this->setActivo(false);
    }

    
    /**
     * Add bills1
     *
     * @param \GS\UserBundle\Entity\Bill $bills1
     * @return Contract
     */
    public function addBills1(\GS\UserBundle\Entity\Bill $bills1)
    {
        $this->bills1[] = $bills1;

        return $this;
    }

    /**
     * Remove bills1
     *
     * @param \GS\UserBundle\Entity\Bill $bills1
     */
    public function removeBills1(\GS\UserBundle\Entity\Bill $bills1)
    {
        $this->bills1->removeElement($bills1);
    }

    /**
     * Get bills1
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBills1()
    {
        return $this->bills1;
    }

    /**
     * Add incidences2
     *
     * @param \GS\UserBundle\Entity\Incidence $incidences2
     * @return Contract
     */
    public function addIncidences2(\GS\UserBundle\Entity\Incidence $incidences2)
    {
        $this->incidences2[] = $incidences2;

        return $this;
    }

    /**
     * Remove incidences2
     *
     * @param \GS\UserBundle\Entity\Incidence $incidences2
     */
    public function removeIncidences2(\GS\UserBundle\Entity\Incidence $incidences2)
    {
        $this->incidences2->removeElement($incidences2);
    }

    /**
     * Get incidences2
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidences2()
    {
        return $this->incidences2;
    }
    
    public function getnCounter()
    {
        for( $i=0; $i<count($this->counters); $i++){
            if($this->counters[$i].fBaja==null){
                return $this->counters[$i].nContador;
            }
        }    
    }
}
