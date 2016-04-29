<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class AgeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'age',
                IntegerType::class,
                [
                    'data' => 25,
                    'label' => 'Age',
                ]
            );
    }
}
