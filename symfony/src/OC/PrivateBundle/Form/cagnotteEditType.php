<?php

namespace OC\PrivateBundle\Form;

use OC\LeetchifakeBundle\Form\cagnotteType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class cagnotteEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
       ->remove('save')
        ->remove('sommetotal')
        ->remove('types')
        
        ->add('save',SubmitType::class, array('label'=>'modifier'))
        ;
    }
    

    public function getParent()
    {
        return cagnotteType::class;
    }
    
}
