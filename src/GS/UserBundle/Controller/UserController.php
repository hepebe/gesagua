<?php

namespace GS\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;
use GS\UserBundle\Entity\User;
use GS\UserBundle\Form\UserType;

class UserController extends Controller
{
    public function homeAction(){
        return $this->render('GSUserBundle:User:home.html.twig');
    }
    
    public function indexAction()
    {
        $gs = $this->getDoctrine()->getManager();
        $users = $gs->getRepository('GSUserBundle:User')->findAll();
        
       /* $res = 'lista de usuarios: </br>';
        
        foreach($users as $user){
            $res .='Usuario: ' . $user->getNombre() . ' - Email: ' . $user->getEmail() . '</br>';
        }
        
        return new Response($res);*/
        
        $deleteFormAjax = $this->createCustomForm(':USER_ID', 'DELETE', 'gs_user_delete');
        
        return $this ->render('GSUserBundle:User:index.html.twig', array('users'=>$users, 'delete_form_ajax' => $deleteFormAjax->createView()));
        
    }
    
    public function addAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        
        return $this->render('GSUserBundle:User:add.html.twig', array('form'=>$form->createView()));
    }
    
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array('action'=>$this->generateUrl('gs_user_create'), 'method'=>'POST'));
        
        return $form;
    }
    
    public function createAction(Request $request)
    {
        $user= new User();
        $form= $this->createCreateForm($user);
        $form->handleRequest($request);
        
        if($form->isValid())
        {
            $password = $form->get('password')->getData();
            
            $passwordConstraint = new Assert\NotBlank(array('message'=>'Este campo es obligatorio'));
            $errorList = $this->get('validator')->validate($password, $passwordConstraint);
            
            if(count($errorList) == 0)
            {
                $encoder = $this->container->get('security.password_encoder');
                $encoded = $encoder->encodePassword($user,$password);
                
                $user->setPassword($encoded);
                
                $gs= $this->getDoctrine()->getManager();
                $gs->persist($user);
                $gs->flush();
                
                $this->addFlash('mensaje','El usuario se ha creado correctamente.');
                
                return $this->redirectToRoute('gs_user_index');
            }
            else
            {
                $errorMessage = new FormError($errorList[0]->getMessage());
                $form->get('password')->addError($errorMessage);
            }
        }
        
        return $this->render('GSUserBundle:User:add.html.twig', array('form'=>$form->createView()));
    }
    
    public function editAction($id)
    {
        $gs = $this->getDoctrine()->getManager();
        $user = $gs->getRepository('GSUserBundle:User')->find($id);
        
        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrado');
        }
        
        $form = $this->createEditForm($user);
        
        return $this->render('GSUserBundle:User:edit.html.twig', array('user'=> $user, 'form'=> $form->createView()));
    }
    
   private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array('action'=> $this->generateUrl('gs_user_update', array('id'=> $entity->getId())), "method"=>'PUT'));
        return $form;
    }
    
    public function updateAction($id, Request $request)
    {
        $gs = $this->getDoctrine()->getManager();
        $user = $gs->getRepository('GSUserBundle:User')->find($id);
        
        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrado');
        }
        
        $form = $this->createEditForm($user);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $password = $form->get('password')->getData();
            if(!empty($password))
            {
                $encoder= $this->container->get('security.password_encoder');
                $encoded= $encoder->encodePassword($user, $password);
                $user->setPassword($encoded);
            }
            else
            {
                $recoverPass= $this->recoverPass($id);
                $user->setPassword($recoverPass[0]['password']);
            }
            
            $gs->flush();
            $this->addFlash('mensaje','El usuario se ha editado correctamente.');
            return $this->redirectToRoute('gs_user_edit', array('id'=> $user->getId()));
        }
        return $this->render('GSUserBundle:User:edit.html.twig', array('user'=>$user, 'form'=>$form->createView()));
    }
    
    private function recoverPass($id)
    {
        $gs = $this->getDoctrine()->getManager();
        $query = $gs->createQuery(
            'SELECT u.password
            FROM GSUserBundle:User u
            WHERE u.id= :id'
        )->setParameter('id',$id);
        
        $currentPass= $query->getResult();
        return $currentPass;
    }
    
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('GSUserBundle:User'); 
        
        $user = $repository->find($id);
        
        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrado');
        }
        
        $deleteForm= $this->createCustomForm($user->getId(),'DELETE','gs_user_delete');
        
        return $this->render('GSUserBundle:User:view.html.twig', array('user'=>$user, 'delete_form'=>$deleteForm->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
        $gs= $this->getDoctrine()->getManager();
        
        $user= $gs->getRepository('GSUserBundle:User')->find($id);
        
        if(!$user){
            throw $this->createNotFoundException('Usuario no encontrado');
        }
        
        
        $form= $this->createCustomForm($user->getId(), 'DELETE', 'gs_user_delete');
        $form->handleRequest($request);
        
        if($form->isSubmitted() &&  $form->isValid())
        {
            if($request->isXMLHttpRequest()){
                $res = $this->deleteUser($user->getTipo(), $gs, $user);
                return new Response(
                        json_encode(array('removed' => $res['removed'], 
                                          'message' => $res['message'])),
                        200,
                        array('Content-Type' => 'application/json')
                    );
            }
            
            $res = $this->deleteUser($user->getTipo(), $gs, $user);
            $this->addFlash($res['alert'], $res['message']);
            return $this->redirectToRoute('gs_user_index');
        }
    }
    
    private function deleteUser($tipo, $gs, $user)
    {
        if($tipo == 'Gestor' || $tipo == 'Lecturista' || $tipo == 'Fontanero' || $tipo == 'Auxiliar'){
            $gs->remove($user);
            $gs->flush();
            $message = 'El usuario se ha eliminado correctamente.';
            $removed = 1;
            $alert = 'mensaje';
        }
        elseif($tipo == 'Administrador'){
             $message = 'El usuario no se ha eliminado.';
             $removed= 0;
             $alert = 'error';
        }
        
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
