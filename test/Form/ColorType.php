<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ColorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('color', ChoiceType::class, [
                'label' => 'Select color',
                'choices' => [
                    'Red' => 'red',
                    'Blue' => 'blue',
                    'Yellow' => 'yellow',
                ],
                'data' => 'red',
            ]);
    }
}
