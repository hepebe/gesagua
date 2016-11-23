<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Reading;
use GS\UserBundle\Entity\Contract;
use GS\UserBundle\Entity\Zone;
use GS\UserBundle\Form\ReadingType;
use GS\UserBundle\Form\ContractType;
use GS\UserBundle\Form\ZoneType;

class ReadingController extends Controller
{
    public function adminroutesAction(){
        $gs = $this->getDoctrine()->getManager();
        $contracts = $gs->getRepository('GSUserBundle:Contract')->findAll();
        $zones = $gs->getRepository('GSUserBundle:Zone')->findAll();
        
        return $this->render('GSUserBundle:Reading:adminroutes.html.twig', array('contracts' => $contracts, 'zones' => $zones));
   
    }
    
    public function searchzoneAction()
    {
        
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        
        $searchParameter = $request->request->get('id');
        $contracts = array();
        if($searchParameter != 0){
            $zone = $gs->getRepository('GSUserBundle:Zone')->find($searchParameter);
            $contract = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
            array_push($contracts, $contract);
            while(!is_null($contract->getNext())){
                $next = $contract->getNext();
                $contract = $gs->getRepository('GSUserBundle:Contract')->find($next);
                array_push($contracts, $contract);
            }
        }
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Reading:ajax_template.html.twig', array(
                'contracts' => $contracts,
            ));
            $status = 'success';
            $html = $data->getContent();
        }
        $jsonArray = array(
            'status' => $status,
            'data' => $html,
        );
        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
        
    }
    
    public function downcontractAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $idContract = $request->request->get('id');
        
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($idContract);
        $secondcontract = $gs->getRepository('GSUserBundle:Contract')->find($contract->getNext());
        $zone = $gs->getRepository('GSUserBundle:Zone')->find($contract->getStreet()->getZone()->getId());
        
        
        if($idContract == $zone->getInicio()){
            $zone->setInicio($contract->getNext());
            $contract->setNext($secondcontract->getNext());
            $secondcontract->setNext($idContract);
        }else{
            $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
            while($contractwhile->getNext() != $idContract){
                $next = $contractwhile->getNext();
                $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($next);
            }
            $contractbefore = $contractwhile;
            if($secondcontract->getId() == $zone->getFin()){
                $zone->setFin($idContract);
                $contractbefore->setNext($contract->getNext());
                $contract->setNext($secondcontract->getNext());
                $secondcontract->setNext($idContract);
                
            }else{
                $contractbefore->setNext($contract->getNext());
                $contract->setNext($secondcontract->getNext());
                $secondcontract->setNext($idContract);
            }
            
        }
        
            
        $gs-> flush();
        
        $contracts = array();
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
        array_push($contracts, $contract);
        while(!is_null($contract->getNext())){
            $next = $contract->getNext();
            $contract = $gs->getRepository('GSUserBundle:Contract')->find($next);
            array_push($contracts, $contract);
        }
        
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Reading:ajax_template.html.twig', array(
                'contracts' => $contracts,
            ));
            $status = 'success';
            $html = $data->getContent();
        }
        $jsonArray = array(
            'status' => $status,
            'data' => $html,
        );
        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
        
    }
    
    public function upcontractAction(){
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $idContract = $request->request->get('id');
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($idContract);
        
        $zone = $gs->getRepository('GSUserBundle:Zone')->find($contract->getStreet()->getZone()->getId());
        
            
        $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
        while($contractwhile->getNext() != $idContract){
            $next = $contractwhile->getNext();
            $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($next);
        }
        $contractbefore = $contractwhile;
       
        if($contractbefore->getId() == $zone->getInicio()){
                $zone->setInicio($idContract);
                $contractbefore->setNext($contract->getNext());
                $contract->setNext($contractbefore->getId());
        
        }else{
            $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
            while($contractwhile->getNext() != $contractbefore->getId()){
                $next = $contractwhile->getNext();
                $contractwhile = $gs->getRepository('GSUserBundle:Contract')->find($next);
            }
            $contractsecondbefore = $contractwhile;
            if($idContract == $zone->getFin()){
                $zone->setFin($contractbefore->getId());
                $contractbefore->setNext($contract->getNext());
                $contract->setNext($contractbefore->getId());
                $contractsecondbefore->setNext($idContract);
            }else{
                $contractbefore->setNext($contract->getNext());
                $contract->setNext($contractbefore->getId());
                $contractsecondbefore->setNext($idContract); 
            }
            
        }
        $gs-> flush();
        
        $contracts = array();
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($zone->getInicio());
        array_push($contracts, $contract);
        while(!is_null($contract->getNext())){
            $next = $contract->getNext();
            $contract = $gs->getRepository('GSUserBundle:Contract')->find($next);
            array_push($contracts, $contract);
        }
        
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Reading:ajax_template.html.twig', array(
                'contracts' => $contracts,
            ));
            $status = 'success';
            $html = $data->getContent();
        }
        $jsonArray = array(
            'status' => $status,
            'data' => $html,
        );
        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }
    
    
    public function viewzonesAction(){
        $gs = $this->getDoctrine()->getManager();
        $zones = $gs->getRepository('GSUserBundle:Zone')->findAll();
        
        return $this->render('GSUserBundle:Reading:viewzones.html.twig', array('zones' => $zones));
    }
    
    public function readzoneAction($id){
        $gs = $this->getDoctrine()->getManager();
        $zones = $gs->getRepository('GSUserBundle:Zone')->find($id);
        $contracts = $gs->getRepository('GSUserBundle:Contract')->find($zones->getInicio());
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Counter');
        
        $query = $repository->createQueryBuilder('c')
        ->innerJoin('c.contract','cc')
        ->where('cc.id = :contract_id AND c.fBaja IS NULL')
        ->setParameter('contract_id', $zones->getInicio())
        ->getQuery();
     
        $counters = $query->getResult();
       
        return $this->render('GSUserBundle:Reading:readzone.html.twig', array('contracts' => $contracts, 'counters'=>$counters, 'zones'=>$zones));
    }
    
   public function returnIncidenceAction($id, $zone){
        $gs = $this->getDoctrine()->getManager();
        $zones = $gs->getRepository('GSUserBundle:Zone')->find($zone);
        $contracts = $gs->getRepository('GSUserBundle:Contract')->find($id);
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Counter');
        
        $query = $repository->createQueryBuilder('c')
        ->innerJoin('c.contract','cc')
        ->where('cc.id = :contract_id AND c.fBaja IS NULL')
        ->setParameter('contract_id',$id)
        ->getQuery();
     
        $counters = $query->getResult();
        
        return $this->render('GSUserBundle:Reading:readzone.html.twig', array('contracts' => $contracts, 'counters'=>$counters, 'zones'=>$zones));
    }
    
    public function savereadingAction(){
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $ncontador = $request->request->get('ncontador');
        $lectura = $request->request->get('lectura');
        $zoneId = $request->request->get('zone');
        $zones = $gs->getRepository('GSUserBundle:Zone')->find($zoneId);
        $counter = $gs->getRepository('GSUserBundle:Counter')->find($ncontador);
        $contracts = $counter->getContract();
        
        
        $reading = new Reading();
        $reading->setCounter($counter);
        
        $reading->setLectura($lectura);
        $reading->setfLectura (new \DateTime());
        
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reading->setuser($user);
        
        $gs-> persist($reading);
        $gs-> flush();
        
        
        $status = 'error';
        $html = '';
        if($zones->getFin() != $contracts->getId()){
            $contracts1 = $gs->getRepository('GSUserBundle:Contract')->find($contracts->getNext());
            $repository = $this->getDoctrine()->getRepository('GSUserBundle:Counter');
        
            $query = $repository->createQueryBuilder('c')
            ->innerJoin('c.contract','cc')
            ->where('cc.id = :contract_id AND c.fBaja IS NULL')
            ->setParameter('contract_id', $contracts1->getId())
            ->getQuery();
         
            $counters = $query->getResult();
            $data = $this->render('GSUserBundle:Reading:ajax_template_read.html.twig', array(
                'contracts' => $contracts1, 'counters' =>$counters, 'zones'=>$zones));
            $status = 'success';
            $html = $data->getContent();
        }else{
            $zones->setFultimaLectura(new \DateTime());
            $gs-> flush();
        }
        $jsonArray = array(
            'status' => $status,
            'data' => $html,
        );
        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');
        return $response;
    }

}

