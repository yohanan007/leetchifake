<?php

namespace OC\LeetchifakeBundle\Form;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class cagnotteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom', TextType::class, array('label' => 'nom'))
        ->add('sommetotal', TextType::class)
        ->add('image', ImageType::class)
        ->add('types', EntityType::class, 
        array('class'=> 'OCLeetchifakeBundle:type',
        'choice_label'=>'nom',
        'multiple'=>'true'
        
            ))
        ->add('save', SubmitType::class, array('label' => 'Create Cagnotte'))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\LeetchifakeBundle\Entity\cagnotte'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_leetchifakebundle_cagnotte';
    }


}
