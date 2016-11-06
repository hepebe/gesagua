<?php

namespace GS\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

/**
 * ClaimsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClaimsRepository extends EntityRepository
{
    public function findByLetters($string){
        return $this->getEntityManager()->createQuery('SELECT c FROM GSUserBundle:Claims c  
                WHERE c.titulo LIKE :string')
                ->setParameter('string','%'.$string.'%')
                ->getResult();
    }
}