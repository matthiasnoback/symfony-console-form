<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\Tests\Form\Data\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlockedAddressesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'addresses',
                CollectionType::class,
                [
                    'entry_type' => AddressType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'label' => 'Blocked addresses',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data' => [
                    'addresses' => [
                        new Address('first street'),
                        new Address('second street'),
                        new Address('third street'),
                    ],
                ],
            ]
        );
    }
}
