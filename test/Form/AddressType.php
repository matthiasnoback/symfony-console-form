<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'street',
                TextType::class,
                [
                    'label' => 'Street',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Address::class,
            ]
        );
    }
}
