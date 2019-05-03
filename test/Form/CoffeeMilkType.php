<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Demonstrates use of CheckboxType.
 */
class CoffeeMilkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('milk', CheckboxType::class, [
                'label' => 'Do you want milk in your coffee?',
            ]);
    }
}
