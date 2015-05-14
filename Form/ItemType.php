<?php

namespace Striide\InventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
    
class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('description')
            ->add('type', 'text',array(
              'attr' => array('class' => 'type autocomplete')
              )
            )
            ->add('photo','file', array('required' => false, 'data_class' => null) )
        ;
    }

    public function getName()
    {
        return 'striide_inventorybundle_itemtype';
    }
}
