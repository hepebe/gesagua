<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('client','entity', array(
                'class' => 'GSUserBundle:Client',
                'choice_label' => 'getfullclient'
                ))
            ->add('contract','entity', array(
                'class' => 'GSUserBundle:Contract',
                'choice_label' => 'getfullcontract'
                ))
            ->add('tarifa','choice',array('choices'=>array('Consumo doméstico'=>'Consumo doméstico', 'Consumo industrial'=>'Consumo industrial', 'Consumo construcciones'=>'Consumo construcciones', 'Consumo municipal'=>'Consumo municipal'), 'placeholder'=>'Selecciona tarifa'))
            ->add('save', 'submit', array('label'=>'Crear Factura'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\UserBundle\Entity\Bill'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gs_userbundle_bill';
    }
}
