<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Street;
use GS\UserBundle\Form\StreetType;

class StreetController extends Controller
{
   public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $streets = $gs->getRepository('GSUserBundle:Street')->findAll();
        
        $deleteFormAjax = $this->createCustomForm(':STREET_ID', 'DELETE', 'gs_street_delete');
        
        return $this->render('GSUserBundle:Street:index.html.twig', array('streets' => $streets, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }
    
    public function addAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $street = new Street();
        $form = $this->createCreateForm($street);
        $zones = $gs->getRepository('GSUserBundle:Zone')->findAll();
        
        return $this->render('GSUserBundle:Street:add.html.twig', array('zones'=>$zones,'form'=>$form->createView()));
    }
    
    private function createCreateForm(Street $entity)
    {
        $form = $this->createForm(new StreetType(), $entity, array(
            'action' => $this->generateUrl('gs_street_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $street = new Street();
        $form = $this->createCreateForm($street);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $gs-> persist($street);
            $gs-> flush();
            
            $this->addFlash('mensaje','La calle se ha creado correctamente.');
            
            return $this->redirectToRoute('gs_street_index');
        }
        
        return $this->render('GSUserBundle:Street:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $street = $gs->getRepository('GSUserBundle:Street')->find($id);
        
        if(!$street)
        {
            throw $this->createNotFoundException('Calle no encontrada');
        }
        
        $form = $this->createEditForm($street);
        return $this->render('GSUserBundle:Street:edit.html.twig', array('street' => $street, 'form' => $form->createView()));
    }
    
    private function createEditForm(Street $entity)
    {
         $form = $this->createForm(new StreetType(), $entity, array('action' => $this->generateUrl('gs_street_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $street = $gs->getRepository('GSUserBundle:Street')->find($id);
        
        if(!$street)
        {
            throw $this->createNotFoundException('Calle no encontrada');
        }
        
        $form = $this->createEditForm($street);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $gs->flush();
            $this->addFlash('mensaje','La calle se ha editado correctamente.');
            return $this->redirectToRoute('gs_street_edit', array('id'=> $street->getId()));
        }
        
        return $this->render('GSUserBundle:Street:edit.html.twig', array('street'=>$street, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Street');
        $street = $repository->find($id);
        
        if(!$street)
        {
            throw $this->createNotFoundException('Calle no encontrada');
        }
        
        $deleteForm = $this->createCustomForm($street->getId(), 'DELETE', 'gs_street_delete');
        
        return $this->render('GSUserBundle:Street:view.html.twig', array('street'=>$street, 'delete_form'=>$deleteForm->createView()));
        
    }
    
    public function deleteAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        $street= $gs->getRepository('GSUserBundle:Street')->find($id);
        
        if(!$street){
            throw $this->createNotFoundException('Calle no encontrada');
        }
        
        
        $form= $this->createCustomForm($street->getId(), 'DELETE', 'gs_street_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res= $this->deleteStreet($gs, $street);
                return new Response(
                        json_encode(array('removed' => $res['removed'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
                
            }
            
            $res = $this->deleteStreet($gs, $street);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_street_index');
        }
    }
    
    private function deleteStreet($gs, $street)
    {
        $gs->remove($street);
        $gs->flush();
        $message = 'La calle se ha eliminado correctamente.';
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
    
    public function searchstreetAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $streets = $gs->getRepository('GSUserBundle:Street')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($streets){
            $data = $this->render('GSUserBundle:Street:ajax_template.html.twig', array(
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
    
    public function selectzoneAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('text');
        $zones = $gs->getRepository('GSUserBundle:Street')
                     ->findZone($searchParameter);
        
        $status = 'error';
        $html = '';
        if($zones){
            $data = $this->render('GSUserBundle:Street:ajax_template_selectZone.html.twig', array(
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