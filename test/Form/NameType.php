<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class NameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'Your name',
                'data' => 'Matthias',
                'constraints' => [
                    new Length(['min' => 4]),
                ],
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
