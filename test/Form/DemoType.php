<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;

class DemoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                [
                    'label' => 'Your name',
                    'required' => true,
                    'data' => 'Matthias',
                ]
            )
            ->add(
                'addresses',
                'collection',
                [
                    'type' => new AddressType(),
                    'allow_add' => true,
                    'label' => 'Addresses',
                ]
            )
            ->add(
                'email',
                'email',
                [
                    'label' => 'Your email address',
                    'constraints' => [
                        new Email(),
                    ],
                ]
            )
            ->add(
                'country',
                'country',
                [
                    'label' => 'Where do you live?',
                    'constraints' => [
                        new Country(),
                    ],
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Matthias\SymfonyConsoleForm\Tests\Form\Data\Demo',
            ]
        );
    }

    public function getName()
    {
        return 'demo';
    }
}
