<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

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
            ->add('fAlta','date', array('data' => new \DateTime(), 'format'=>'dd MM yyyy'))
            ->add('fBaja','date', array('widget'=>'choice', 'format'=>'dd MM yyyy', 'years'=>range(1950,2016), 'placeholder'=>array('year'=>'Año','month'=>'Mes','day'=>'Día')))
            ->add('contract','entity', array(
                'class' => 'GSUserBundle:Contract',
                'query_builder' => function (EntityRepository $gs) {
                    return $gs->createQueryBuilder('c')
                        ->where('c.activo = :only')
                        ->setParameter('only', 0);
                },
                'choice_label' => 'getfullcontract'
                ))
            ->add('save', 'submit', array('label'=>'Crear Contador'))
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
