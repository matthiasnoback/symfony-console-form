<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ColorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', 'choice', array(
                'label' => 'Select color',
                'choices' => array(
                    'red' => 'Red',
                    'blue' => 'Blue',
                    'yellow' => 'Yellow',
                ),
                'data' => 'red',
            ));
    }

    public function getName()
    {
        return 'color';
    }
}
