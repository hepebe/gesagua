<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Contract;
use GS\UserBundle\Form\ContractType;

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
        $contract = new Contract();
        $form = $this->createCreateForm($contract);
        
        return $this->render('GSUserBundle:Contract:add.html.twig', array('form'=>$form->createView()));
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
            $gs-> persist($contract);
            $gs-> flush();
            
            $this->addFlash('mensaje','El contrato se ha creado correctamente.');
            
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
    
}
