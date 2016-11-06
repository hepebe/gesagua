<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Claims;
use GS\UserBundle\Form\ClaimsType;

class ClaimsController extends Controller
{
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $claimss = $gs->getRepository('GSUserBundle:Claims')->findAll();
        
        $deleteFormAjax = $this->createCustomForm(':CLAIMS_ID', 'DELETE', 'gs_claims_delete');
        
        return $this->render('GSUserBundle:Claims:index.html.twig', array('claimss' => $claimss, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }
    
    public function addAction()
    {
        $claims = new Claims();
        $form = $this->createCreateForm($claims);
        
        return $this->render('GSUserBundle:Claims:add.html.twig', array('form'=>$form->createView()));
    }
    
    private function createCreateForm(Claims $entity)
    {
        $form = $this->createForm(new ClaimsType(), $entity, array(
            'action' => $this->generateUrl('gs_claims_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $claims = new Claims();
        $form = $this->createCreateForm($claims);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $claims->setUser($user);
            $gs-> persist($claims);
            $gs-> flush();
            
            $this->addFlash('mensaje','La reclamación se ha creado correctamente.');
            
            return $this->redirectToRoute('gs_claims_index');
        }
        
        return $this->render('GSUserBundle:Claims:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $claims = $gs->getRepository('GSUserBundle:Claims')->find($id);
        
        if(!$claims)
        {
            throw $this->createNotFoundException('Reclamación no encontrada');
        }
        
        $form = $this->createEditForm($claims);
        return $this->render('GSUserBundle:Claims:edit.html.twig', array('claims' => $claims, 'form' => $form->createView()));
    }
    
    private function createEditForm(Claims $entity)
    {
         $form = $this->createForm(new ClaimsType(), $entity, array('action' => $this->generateUrl('gs_claims_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $claims = $gs->getRepository('GSUserBundle:Claims')->find($id);
        
        if(!$claims)
        {
            throw $this->createNotFoundException('Reclamación no encontrada');
        }
        
        $form = $this->createEditForm($claims);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $gs->flush();
            $this->addFlash('mensaje','La reclamación se ha editado correctamente.');
            return $this->redirectToRoute('gs_claims_index', array('id'=> $claims->getId()));
        }
        
        return $this->render('GSUserBundle:Claims:edit.html.twig', array('claims'=>$claims, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Claims');
        $claims = $repository->find($id);
        
        if(!$claims)
        {
            throw $this->createNotFoundException('Reclamación no encontrada');
        }
        
        $deleteForm = $this->createCustomForm($claims->getId(), 'DELETE', 'gs_claims_delete');
        
        return $this->render('GSUserBundle:Claims:view.html.twig', array('claims'=>$claims, 'delete_form'=>$deleteForm->createView()));
        
    }
    
    public function deleteAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        $claims= $gs->getRepository('GSUserBundle:Claims')->find($id);
        
        if(!$claims){
            throw $this->createNotFoundException('Reclamación no encontrada');
        }
        
        
        $form= $this->createCustomForm($claims->getId(), 'DELETE', 'gs_claims_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res= $this->deleteClaims($gs, $claims);
                return new Response(
                        json_encode(array('removed' => $res['removed'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
                
            }
            
            $res = $this->deleteClaims($gs, $claims);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_claims_index');
        }
    }
    
    private function deleteClaims($gs, $claims)
    {
        $gs->remove($claims);
        $gs->flush();
        $message = 'La reclamación se ha eliminado correctamente.';
        $removed = 1;
        $alert = 'mensaje';
        return array('removed'=>$removed, 'message'=>$message, 'alert'=>$alert);
    }
    
    private function createCustomForm($id, $method, $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id'=>$id)))
            ->setMethod($method)
            ->getForm();
    } 
    
    public function searchclaimsAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $claimss = $gs->getRepository('GSUserBundle:Claims')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($claimss){
            $data = $this->render('GSUserBundle:Claims:ajax_template.html.twig', array(
                'claimss' => $claimss,
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
