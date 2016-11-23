<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContractType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nVivienda')
            ->add('street', 'entity', array(
                'class' => 'GSUserBundle:Street',
                'choice_label' => 'getfullstreet'
                ))
            ->add('client', 'entity', array(
                'class' => 'GSUserBundle:Client',
                'choice_label' => 'getfullclient'
                ))
            ->add('tarifa','choice',array('choices'=>array('Consumo doméstico'=>'Consumo doméstico', 'Consumo industrial'=>'Consumo industrial', 'Consumo construcciones'=>'Consumo construcciones', 'Consumo municipal'=>'Consumo municipal'), 'placeholder'=>'Selecciona tarifa'))
            ->add('save', 'submit', array('label'=>'Crear Contrato'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\UserBundle\Entity\Contract'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gs_userbundle_contract';
    }
}
