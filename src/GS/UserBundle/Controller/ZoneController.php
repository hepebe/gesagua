<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Zone;
use GS\UserBundle\Form\ZoneType;

class ZoneController extends Controller
{
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $zones = $gs->getRepository('GSUserBundle:Zone')->findAll();
        
        $deleteFormAjax = $this->createCustomForm(':ZONE_ID', 'DELETE', 'gs_zone_delete');
        
        return $this->render('GSUserBundle:Zone:index.html.twig', array('zones' => $zones, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }
    
    public function addAction()
    {
        $zone = new Zone();
        $form = $this->createCreateForm($zone);
        
        return $this->render('GSUserBundle:Zone:add.html.twig', array('form'=>$form->createView()));
    }
    
    private function createCreateForm(Zone $entity)
    {
        $form = $this->createForm(new ZoneType(), $entity, array(
            'action' => $this->generateUrl('gs_zone_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $zone = new Zone();
        $form = $this->createCreateForm($zone);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $gs-> persist($zone);
            $gs-> flush();
            
            $this->addFlash('mensaje','La zona se ha creado correctamente.');
            
            return $this->redirectToRoute('gs_zone_index');
        }
        
        return $this->render('GSUserBundle:Zone:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $zone = $gs->getRepository('GSUserBundle:Zone')->find($id);
        
        if(!$zone)
        {
            throw $this->createNotFoundException('Zona no encontrada');
        }
        
        $form = $this->createEditForm($zone);
        return $this->render('GSUserBundle:Zone:edit.html.twig', array('zone' => $zone, 'form' => $form->createView()));
    }
    
    private function createEditForm(Zone $entity)
    {
         $form = $this->createForm(new ZoneType(), $entity, array('action' => $this->generateUrl('gs_zone_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $zone = $gs->getRepository('GSUserBundle:Zone')->find($id);
        
        if(!$zone)
        {
            throw $this->createNotFoundException('Zona no encontrada');
        }
        
        $form = $this->createEditForm($zone);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $gs->flush();
            $this->addFlash('mensaje','La zona se ha editado correctamente.');
            return $this->redirectToRoute('gs_zone_edit', array('id'=> $zone->getId()));
        }
        
        return $this->render('GSUserBundle:Zone:edit.html.twig', array('zone'=>$zone, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Zone');
        $zone = $repository->find($id);
        
        if(!$zone)
        {
            throw $this->createNotFoundException('Zona no encontrada');
        }
        
        $deleteForm = $this->createCustomForm($zone->getId(), 'DELETE', 'gs_zone_delete');
        
        return $this->render('GSUserBundle:Zone:view.html.twig', array('zone'=>$zone, 'delete_form'=>$deleteForm->createView()));
        
    }
    
    public function deleteAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        $zone= $gs->getRepository('GSUserBundle:Zone')->find($id);
        
        if(!$zone){
            throw $this->createNotFoundException('Zona no encontrada');
        }
        
        
        $form= $this->createCustomForm($zone->getId(), 'DELETE', 'gs_zone_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res= $this->deleteZone($gs, $zone);
                return new Response(
                        json_encode(array('removed' => $res['removed'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
                
            }
            
            $res = $this->deleteZone($gs, $zone);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_zone_index');
        }
    }
    
    private function deleteZone($gs, $zone)
    {
        $gs->remove($zone);
        $gs->flush();
        $message = 'La zona se ha eliminado correctamente.';
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
    
    public function searchzoneAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $zones = $gs->getRepository('GSUserBundle:Zone')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($zones){
            $data = $this->render('GSUserBundle:Zone:ajax_template.html.twig', array(
                'zones' => $zones,
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
