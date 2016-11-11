<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Contract;
use GS\UserBundle\Form\ContractType;
use GS\UserBundle\Entity\Incidence;
use GS\UserBundle\Form\IncidenceType;

class ContractController extends Controller
{
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $contracts = $gs->getRepository('GSUserBundle:Contract')->findAll();
        
        return $this->render('GSUserBundle:Contract:index.html.twig', array('contracts' => $contracts));
    }
    
    public function addAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $contract = new Contract();
        $form = $this->createCreateForm($contract);
        $clients = $gs->getRepository('GSUserBundle:Client')->findAll();
        $streets = $gs->getRepository('GSUserBundle:Street')->findAll();
        
        return $this->render('GSUserBundle:Contract:add.html.twig', array('clients'=>$clients, 'streets'=>$streets, 'form'=>$form->createView()));
    }
    
    private function createCreateForm(Contract $entity)
    {
        $form = $this->createForm(new ContractType(), $entity, array(
            'action' => $this->generateUrl('gs_contract_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $contract = new Contract();
        $form = $this->createCreateForm($contract);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $incidence = new Incidence();
            $incidence ->setTipo("Colocar contador");
            $incidence ->setGravedad("Alta");
            $incidence ->setEstado("Pendiente");
            $incidence -> setContract($contract);
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $incidence->setUserReg($user);
            $incidence->setInformacion("Colocar un nuevo contador");
            $gs->persist($incidence);
            $gs-> persist($contract);
            $gs-> flush();
            
            $inicio = $contract->getStreet()->getZone()->getInicio();
            $fin = $contract->getStreet()->getZone()->getFin();
            $lastid = $contract->getId();
            if(is_null($inicio) && is_null($fin)){
               $contract->getStreet()->getZone()->setInicio($lastid);
               $contract->getStreet()->getZone()->setFin($lastid);
              
            }else{
                $lastContract = $gs->getRepository('GSUserBundle:Contract')->find($fin);
                $lastContract->setNext($lastid);
                $contract->getStreet()->getZone()->setFin($lastid);
            }
             $gs-> flush();
            
            $this->addFlash('mensaje','El contrato se ha creado correctamente.');
            //$this->addFlash('mensaje',$lastid . 'El contrato se ha creado correctamente.' . $inicio);
            
            return $this->redirectToRoute('gs_contract_index');
        }
        
        return $this->render('GSUserBundle:Contract:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $contracts = $gs->getRepository('GSUserBundle:Contract')->find($id);
        
        if(!$contracts)
        {
            throw $this->createNotFoundException('Contrato no encontrada');
        }
        
        $form = $this->createEditForm($contracts);
        return $this->render('GSUserBundle:Contract:edit.html.twig', array('contracts' => $contracts, 'form' => $form->createView()));
    }
    
    private function createEditForm(Contract $entity)
    {
         $form = $this->createForm(new ContractType(), $entity, array('action' => $this->generateUrl('gs_contract_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $contract = $gs->getRepository('GSUserBundle:Contract')->find($id);
        
        if(!$contract)
        {
            throw $this->createNotFoundException('contrato no encontrada');
        }
        
        $form = $this->createEditForm($contract);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $gs->flush();
            $this->addFlash('mensaje','El contrato se ha editado correctamente.');
            return $this->redirectToRoute('gs_contract_edit', array('id'=> $contract->getId()));
        }
        
        return $this->render('GSUserBundle:Contract:edit.html.twig', array('contract'=>$contract, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Contract');
        $contract = $repository->find($id);
        
        if(!$contract)
        {
            throw $this->createNotFoundException('contrato no encontrado');
        }
        
        
        return $this->render('GSUserBundle:Contract:view.html.twig', array('contract'=>$contract));
        
    }
    
    public function searchcontractAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $contracts = $gs->getRepository('GSUserBundle:Contract')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Contract:ajax_template.html.twig', array(
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
    
    public function selectclientAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        
        $searchParameter = $request->request->get('text');
        $clients = $gs->getRepository('GSUserBundle:Contract')
                     ->findClient($searchParameter);
        
        $status = 'error';
        $html = '';
        if($clients){
            $data = $this->render('GSUserBundle:Contract:ajax_template_selectClient.html.twig', array(
                'clients' => $clients,
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
    
    public function selectstreetAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        
        $searchParameter = $request->request->get('text');
        $streets = $gs->getRepository('GSUserBundle:Contract')
                     ->findStreet($searchParameter);
        
        $status = 'error';
        $html = '';
        if($streets){
            $data = $this->render('GSUserBundle:Contract:ajax_template_selectStreet.html.twig', array(
                'streets' => $streets,
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
