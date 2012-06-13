<?php

namespace Striide\InventoryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('quantity')
            ->add('description')
            ->add('type', 'text',array(
              'attr' => array('class' => 'type autocomplete')
              )
            )
            ->add('photo','file', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'striide_inventorybundle_itemtype';
    }
}
