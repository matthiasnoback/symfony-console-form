<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MultiSelectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Enter title',
                    'required' => true,
                    'data' => 'Some title',
                ]
            )
            ->add(
                'choices',
                ChoiceType::class,
                [
                    'label' => 'Select values',
                    'multiple' => true,
                    'required' => true,
                    'choices' => $this->getChoices(),
                    // So how to pass data that default choices are selected???
                    //'data' => [1,2], // () at /home/wunder/projects/symfony-console-form/src/Console/Formatter/Format.php:21
                    //'data' => '1,2', // () at /home/wunder/projects/symfony-console-form/vendor/symfony/form/Extension/Core/DataTransformer/ChoicesToValuesTransformer.php:49
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Matthias\SymfonyConsoleForm\Tests\Form\Data\MultiSelect',
            ]
        );
    }

    private function getChoices()
    {
        return [
            'AA'    => 1,
            'BB'    => 2,
            'CC'    => 3,
        ];
    }
}