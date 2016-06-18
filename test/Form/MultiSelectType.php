<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class MultiSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'choices',
                ChoiceType::class,
                [
                    'label' => 'Select values',
                    'multiple' => true,
                    'required' => true,
                    'choices' => $this->getChoices(),
                    'choices_as_values' => true,
                    'data' => [1, 2],
                ]
            )
        ;
    }

    private function getChoices()
    {
        return [
            'AA' => 1,
            'BB' => 2,
            'CC' => 3,
        ];
    }
}
