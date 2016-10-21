<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Client;
use GS\UserBundle\Form\ClientType;

class ClientController extends Controller
{
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $clients = $gs->getRepository('GSUserBundle:Client')->findAll();
        //$res = 'Lista de Clientes: </br>';
        
        $deleteFormAjax = $this->createCustomForm(':CLIENT_ID', 'DELETE', 'gs_client_delete');
        
        return $this->render('GSUserBundle:Client:index.html.twig', array('clients' => $clients, 'delete_form_ajax' => $deleteFormAjax->createView()));
    }
    
    public function addAction()
    {
        $client = new Client();
        $form = $this->createCreateForm($client);
        
        return $this->render('GSUserBundle:Client:add.html.twig', array('form'=>$form->createView()));
    }
    
    private function createCreateForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('gs_client_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $client = new Client();
        $form = $this->createCreateForm($client);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
            $gs = $this->getDoctrine()->getManager();
            $gs-> persist($client);
            $gs-> flush();
            
            $this->addFlash('mensaje','El usuario se ha creado correctamente.');
            
            return $this->redirectToRoute('gs_client_index');
        }
        
        return $this->render('GSUserBundle:Client:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this ->getDoctrine()->getManager();
        $client = $gs->getRepository('GSUserBundle:Client')->find($id);
        
        if(!$client)
        {
            throw $this->createNotFoundException('Cliente no encontrado');
        }
        
        $form = $this->createEditForm($client);
        return $this->render('GSUserBundle:Client:edit.html.twig', array('client' => $client, 'form' => $form->createView()));
    }
    
    private function createEditForm(Client $entity)
    {
         $form = $this->createForm(new ClientType(), $entity, array('action' => $this->generateUrl('gs_client_update', array('id'=> $entity->getId())), 'method' => 'PUT')); 
    
        return $form;   
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this ->getDoctrine()->getManager();
        $client = $gs->getRepository('GSUserBundle:Client')->find($id);
        
        if(!$client)
        {
            throw $this->createNotFoundException('Cliente no encontrado');
        }
        
        $form = $this->createEditForm($client);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $gs->flush();
            $this->addFlash('mensaje','El cliente se ha editado correctamente.');
            return $this->redirectToRoute('gs_client_edit', array('id'=> $client->getId()));
        }
        
        return $this->render('GSUserBundle:Client:edit.html.twig', array('client'=>$client, 'form'=>$form->createView()));
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Client');
        $client = $repository->find($id);
        
        if(!$client)
        {
            throw $this->createNotFoundException('Cliente no encontrado');
        }
        
        $deleteForm = $this->createCustomForm($client->getId(), 'DELETE', 'gs_client_delete');
        
        return $this->render('GSUserBundle:Client:view.html.twig', array('client'=>$client, 'delete_form'=>$deleteForm->createView()));
        
    }
    
    public function deleteAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        $client= $gs->getRepository('GSUserBundle:Client')->find($id);
        
        if(!$client){
            throw $this->createNotFoundException('Cliente no encontrado');
        }
        
        
        //$form = $this->createDeleteForm($client);
        $form= $this->createCustomForm($client->getId(), 'DELETE', 'gs_client_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res= $this->deleteClient($gs, $client);
                return new Response(
                        json_encode(array('removed' => $res['removed'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
                
            }
            
            $res = $this->deleteClient($gs, $client);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_client_index');
        }
    }
    
    private function deleteClient($gs, $client)
    {
        $gs->remove($client);
        $gs->flush();
        $message = 'El cliente se ha eliminado correctamente.';
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
 
}
