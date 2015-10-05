<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ColorWithChoicesAsValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', 'choice', array(
                'label' => 'Select color',
                'choices' => array(
                    'Red' => 'red',
                    'Blue' => 'blue',
                    'Yellow' => 'yellow',
                ),
                'data' => 'red',
                'choices_as_values' => true,
            ));
    }

    public function getName()
    {
        return 'color_with_choices_as_values';
    }
}
