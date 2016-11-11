<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\Counter;
use GS\UserBundle\Form\CounterType;

class CounterController extends Controller
{
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        
        $counters = $gs->getRepository('GSUserBundle:Counter')->findAll();
        
        $deleteFormAjax = $this->createCustomForm(':COUNTER_ID', 'PUT', 'gs_counter_update');
        
        return $this->render('GSUserBundle:Counter:index.html.twig', array('counters' => $counters, 'delete_form_ajax'=>$deleteFormAjax->createView()));
    }
    
    public function addAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $counter = new Counter();
        $form = $this->createCreateForm($counter);
        $contracts = $gs->getRepository('GSUserBundle:Contract')->findAll();
        
        return $this->render('GSUserBundle:Counter:add.html.twig', array('contracts'=>$contracts, 'form'=>$form->createView()));
    }
    
    private function createCreateForm(Counter $entity)
    {
        $form = $this->createForm(new CounterType(), $entity, array(
            'action' => $this->generateUrl('gs_counter_create'),
            'method' => 'POST'
            ));
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $counter = new Counter();
        $form = $this->createCreateForm($counter);
        $form -> handleRequest($request);
        
        if($form->isValid())
        {
           /* $idContrato = $counter->getContract();
            $fechaBaja = $counter->getFBaja();
            
            if($idContrato && $fechaBaja == null){
                $this->addFlash('mensaje','El contrato ya tiene un contador registrado.');
            }else{*/
                $gs = $this->getDoctrine()->getManager();
                $gs-> persist($counter);
                $gs-> flush();
                
                $this->addFlash('mensaje','El contador se ha creado correctamente.');
                
                return $this->redirectToRoute('gs_counter_index');
            
            
        }
        
        return $this->render('GSUserBundle:Counter:add.html.twig', array('form'=>$form->createView()));
    }
    
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:Counter');
        $counter = $repository->find($id);
        
        if(!$counter)
        {
            throw $this->createNotFoundException('Contador no encontrada');
        }
        
        $deleteForm = $this->createCustomForm($counter->getNContador(), 'PUT', 'gs_counter_update');
        
        return $this->render('GSUserBundle:Counter:view.html.twig', array('counter'=>$counter, 'delete_form'=>$deleteForm->createView()));
        
    }
    
    public function updateAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        $counter= $gs->getRepository('GSUserBundle:Counter')->find($id);
        
        if(!$counter){
            throw $this->createNotFoundException('Contador no encontrado');
        }
        
        $form= $this->createCustomForm($counter->getNContador(), 'PUT', 'gs_counter_update');
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest())
            {
                $res=$this->updateCounter($gs, $counter);
                return new Response(
                        json_encode(array('updated' => $res['updated'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
                
            }
            
            $res = $this->updateCounter($gs, $counter);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_counter_index');
        }
    }
    
    private function updateCounter($gs, $counter)
    {
        $counter->setFBaja(new \DateTime());
        $counter->setinactivoValue();
        $gs->flush();
        $message = 'Se ha dado de baja al contador correctamente.';
        $updated = 1;
        $alert = 'mensaje';
        return array('updated'=>$updated, 'message'=>$message, 'alert'=>$alert);
    }
    
    private function createCustomForm($id, $method, $route)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl($route, array('id'=>$id)))
            ->setMethod($method)
            ->getForm();
    } 
    
    public function searchcounterAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        $searchParameter = $request->request->get('id');
        $counters = $gs->getRepository('GSUserBundle:Counter')
                     ->findByLetters($searchParameter);
        
        $status = 'error';
        $html = '';
        if($counters){
            $data = $this->render('GSUserBundle:Counter:ajax_template.html.twig', array(
                'counters' => $counters,
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
    
     public function selectcontractAction()
    {
        $gs = $this->getDoctrine()->getManager(); 
        $request = $this->get('request');
        
        $searchParameter = $request->request->get('text');
        $contracts = $gs->getRepository('GSUserBundle:Counter')
                     ->findContract($searchParameter);
        
        $status = 'error';
        $html = '';
        if($contracts){
            $data = $this->render('GSUserBundle:Counter:ajax_template_selectContract.html.twig', array(
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
