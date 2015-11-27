<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DateOfBirthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dateOfBirth',
                'date',
                [
                    'label' => 'Your date of birth',
                    'data' => new \DateTime('1879-03-14'),
                    'widget' => 'single_text',
                ]
            )->add(
                'submit',
                'submit',
                [
                    'label' => 'Submit',
                ]
            );
    }

    public function getName()
    {
        return 'date_of_birth';
    }
}
