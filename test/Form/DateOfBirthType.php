<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class DateOfBirthType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dateOfBirth',
                DateType::class,
                [
                    'label' => 'Your date of birth',
                    'data' => new \DateTime('1987-03-14', new \DateTimeZone('UTC')),
                    'widget' => 'single_text',
                    'model_timezone' => 'UTC',
                    'view_timezone' => 'UTC'
                ]
            )->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Submit',
                ]
            );
    }
}
