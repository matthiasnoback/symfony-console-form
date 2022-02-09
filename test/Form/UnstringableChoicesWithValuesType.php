<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Demonstrates handling of choice data which does not support conversion to string (Address has no __toString())
 */
class UnstringableChoicesWithValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', ChoiceType::class, [
                'label' => 'Select address',
                'choices' => [
                    new Address('10 Downing Street'),
                    new Address('1600 Pennsylvania Ave NW'),
                    new Address('55 Rue du Faubourg Saint-Honoré'),
                ],
                'choice_value' => function (Address $address) {
                    return \strtolower(\str_replace(' ', '-', $address->street));
                },
                'choice_label' => function (Address $address) {
                    return $address->street;
                },
                'data' => new Address('10 Downing Street')
            ]);
    }
}
