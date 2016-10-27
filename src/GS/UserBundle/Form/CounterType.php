<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CounterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nContador')
            ->add('fAlta')
            ->add('fBaja')
            ->add('contract','entity', array(
                'class' => 'GSUserBundle:Contract',
                'choice_label' => 'getfullcontract'
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\UserBundle\Entity\Counter'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gs_userbundle_counter';
    }
}
