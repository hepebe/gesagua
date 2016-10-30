<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ClaimsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user','entity', array(
                'class' => 'GSUserBundle:User',
                'query_builder' => function (EntityRepository $gs) {
                    return $gs->createQueryBuilder('u')
                        ->where('u.tipo = :only')
                        ->setParameter('only', 'Auxiliar');
                },
                'choice_label' => 'getfulluser'
                ))
            ->add('client', 'entity', array(
                'class' => 'GSUserBundle:Client',
                'choice_label' => 'getfullclient'
                ))
            
            ->add('titulo')
            ->add('informacion','textarea', array('attr' => array('class' => 'tinymce')))
            ->add('estado', 'choice', array('choices'=>array('Pendiente'=>'Pendiente','Resuelto'=>'Resuelto'), 'choices_as_values'=>true,'multiple'=>false,'expanded'=>true))
            ->add('resolucion','textarea', array('attr' => array('class' => 'tinymce')))
            ->add('save', 'submit', array('label'=>'Crear Cliente'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\UserBundle\Entity\Claims'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gs_userbundle_claims';
    }
}
