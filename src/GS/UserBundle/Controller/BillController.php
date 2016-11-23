<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Bill;
use GS\UserBundle\Form\BillType;
use GS\UserBundle\Entity\Contract;
use GS\UserBundle\Form\ContractType;
use GS\UserBundle\Entity\Client;
use GS\UserBundle\Form\ClientType;

class BillController extends Controller
{
     public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $bills = $gs->getRepository('GSUserBundle:Bill')->findAll();
        
       return $this->render('GSUserBundle:Bill:index.html.twig', array('bills' => $bills));
    }
    
    public function addAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $bill = new Bill();
        $contracts = $gs->getRepository('GSUserBundle:Contract')->findAll();
        
        return $this->render('GSUserBundle:Bill:add.html.twig', array('contracts'=>$contracts));
    }
    
    public function createAction($id)
    {
        $bill = new Bill();        
        
        $gs = $this->getDoctrine()->getManager();
        $counter = $gs->getRepository('GSUserBundle:Bill')->findCounter($id);
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($id);
        $readings = $gs->getRepository('GSUserBundle:Bill')->findReading($counter[0]->getNContador());
        if(count($readings)>1){
            $consumo = $readings[count($readings)-1]->getLectura() - $readings[count($readings)-2]->getLectura();
            $bill->setLectAnterior($readings[count($readings)-2]->getLectura());
        }else{
             $consumo = $readings[count($readings)-1]->getLectura();
        }
        $bill->setLectActual($readings[count($readings)-1]->getLectura());
        $bill->setConsumo($consumo);
        $contract->setFultimaFactura(new \DateTime());
        $bill->setContract($contract);
        switch ($contract->getTarifa()) {
            case 'Consumo doméstico':
                if($consumo>40){
                    $total= $consumo*2.37;
                }elseif($consumo>30){
                    $total= $consumo*2.00;
                }elseif($consumo>20){
                    $total= $consumo*1.44;
                }elseif($consumo>0){
                    $total= $consumo*0.86;
                }
                break;
            case 'Consumo industrial':
                $total= $consumo*2.55;
                break;
            case 'Consumo construcciones':
                $total= $consumo*2.55;
                break;
            case 'Consumo municipal':
                $total= $consumo*1.33;
                break;
            default:
                break;
        }
        $total +=1.35;
        $bill->setTotal($total);
        $gs-> persist($bill);
        $gs-> flush();
        
        $this->addFlash('mensaje','La factura se ha creado correctamente.');
        
        return $this->redirectToRoute('gs_bill_index');
        
        
        
    }
    
    public function editAction($id){
        $gs = $this->getDoctrine()->getManager();
        $bill = $gs->getRepository('GSUserBundle:Bill')->find($id);
        $bill->setEstado("Cobrado");
        $gs-> flush();
        return $this->redirectToRoute('gs_bill_index');
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Bill');
        $bill = $repository->find($id);
        
        if(!$bill)
        {
            throw $this->createNotFoundException('Factura no encontrada');
        }
        
        return $this->render('GSUserBundle:Bill:view.html.twig', array('bill'=>$bill));
        
    }
    
    public function searchbillAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $bills = $gs->getRepository('GSUserBundle:Bill')
                     ->findByLetters($searchParameter);
        $status = 'error';
        $html = '';
        if($bills){
            $data = $this->render('GSUserBundle:Bill:ajax_template.html.twig', array(
                'bills' => $bills,
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
    
    public function searchcontractAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $contracts = $gs->getRepository('GSUserBundle:Bill')
                     ->findByLettersContract($searchParameter);
        
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Bill:ajax_template_contract.html.twig', array(
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
    
}
