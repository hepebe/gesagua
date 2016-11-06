<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Incidence;
use GS\UserBundle\Form\IncidenceType;

class IncidenceController extends Controller
{
   public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $incidences = $gs->getRepository('GSUserBundle:Incidence')->findAll();
        
        return $this->render('GSUserBundle:Incidence:index.html.twig', array('incidences' => $incidences));
    }
    
    public function addAction($id)
    {
        $incidence = new Incidence();
        $form = $this->createCreateForm($incidence, $id);
        
        return $this->render('GSUserBundle:Incidence:add.html.twig', array('form'=>$form->createView()));
    }
    
    private function createCreateForm(Incidence $entity, $id)
    {
        $form = $this->createForm(new IncidenceType(), $entity, array(
            'action' => $this->generateUrl('gs_incidence_create', array('id'=> $id)),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction($id, Request $request)
    {
        $incidence = new Incidence();
        $form = $this->createCreateForm($incidence, $id);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $incidence->setUserReg($user);
            $contract = $gs->getRepository('GSUserBundle:Contract')->find($id);
            $incidence->setContract($contract);
            $gs-> persist($incidence);
            $gs-> flush();
            
            $this->addFlash('mensaje','La incidencia se ha creado correctamente.');
            
            return $this->redirectToRoute('gs_reading_adminroutes');
        }
        
        return $this->render('GSUserBundle:Incidence:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $incidences = $gs->getRepository('GSUserBundle:Incidence')->find($id);
        
        if(!$incidences)
        {
            throw $this->createNotFoundException('Incidencia no encontrada');
        }
        
        $form = $this->createEditForm($incidences);
        return $this->render('GSUserBundle:Incidence:edit.html.twig', array('Incidences' => $incidences, 'form' => $form->createView()));
    }
    
    private function createEditForm(Incidence $entity)
    {
         $form = $this->createForm(new IncidenceType(), $entity, array('action' => $this->generateUrl('gs_incidence_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $incidences = $gs->getRepository('GSUserBundle:Incidence')->find($id);
        
        if(!$incidences)
        {
            throw $this->createNotFoundException('Incidencia no encontrada');
        }
        
        $form = $this->createEditForm($incidences);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $incidences->setUserRes($user);
            $gs-> persist($incidences);
            $gs->flush();
            $this->addFlash('mensaje','La incidencia se ha editado correctamente.');
            return $this->redirectToRoute('gs_incidence_index', array('id'=> $incidences->getId()));
        }
        
        return $this->render('GSUserBundle:Incidence:edit.html.twig', array('incidences'=>$incidences, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Incidence');
        $incidences = $repository->find($id);
        
        if(!$incidences)
        {
            throw $this->createNotFoundException('Incidencia no encontrada');
        }
        
        return $this->render('GSUserBundle:Incidence:view.html.twig', array('incidences'=>$incidences));
        
    }
    
    
    
    public function searchincidenceAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $incidences = $gs->getRepository('GSUserBundle:Incidence')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($incidences){
            $data = $this->render('GSUserBundle:Incidence:ajax_template.html.twig', array(
                'incidences' => $incidences,
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
