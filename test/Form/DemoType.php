<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Country;
use Symfony\Component\Validator\Constraints\Email;

class DemoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Your name',
                    'required' => true,
                    'data' => 'Matthias',
                ]
            )
            ->add(
                'addresses',
                CollectionType::class,
                [
                    'entry_type' => AddressType::class,
                    'allow_add' => true,
                    'label' => 'Addresses',
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Your email address',
                    'constraints' => [
                        new Email(),
                    ],
                ]
            )
            ->add(
                'country',
                CountryType::class,
                [
                    'label' => 'Where do you live?',
                    'constraints' => [
                        new Country(),
                    ],
                ]
            )
            ->add(
                'dateOfBirth',
                DateType::class,
                [
                    'label' => 'Your date of birth',
                    'data' => new \DateTime('1879-03-14'),
                    'widget' => 'single_text',
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Matthias\SymfonyConsoleForm\Tests\Form\Data\Demo',
            ]
        );
    }
}
