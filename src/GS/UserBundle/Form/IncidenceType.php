<?php

namespace GS\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class IncidenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', 'choice',array('choices'=>array('Parado'=>'Parado', 'Cambio de contador'=>'Cambio de contador', 'Avería fontanero'=>'Avería fontanero', 'Consumo elevado'=>'Consumo elevado', 'Manipulado'=>'Manipulado', 'Consumo negativo'=>'Consumo negativo', 'Cambio de dirección'=>'Cambio de dirección'), 'placeholder'=>'Selecciona tipo'))
            ->add('gravedad', 'choice',array('choices'=>array('Alta'=>'Alta', 'Media'=>'Media', 'Baja'=>'Baja'), 'placeholder'=>'Selecciona gravedad'))
            
            ->add('informacion', 'textarea', array('attr' => array('class' => 'tinymce')))
            ->add('estado','choice', array('choices'=>array('Pendiente'=>'Pendiente','Resuelto'=>'Resuelto'), 'choices_as_values'=>true,'multiple'=>false,'expanded'=>true))
            ->add('resolucion', 'textarea', array('attr' => array('class' => 'tinymce')))
            ->add('save', 'submit', array('label'=>'Crear Incidencia'))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GS\UserBundle\Entity\Incidence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gs_userbundle_incidence';
    }
}
