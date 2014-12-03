<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'street',
                'text',
                [
                    'label' => 'Street'
                ]
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Matthias\SymfonyConsoleForm\Tests\Form\Data\Address'
            ]
        );
    }

    public function getName()
    {
        return 'address';
    }
}
