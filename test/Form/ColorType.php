<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class ColorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $flipChoices = function ($choices) {
            return LegacyFormHelper::isLegacy() ?
                $choices :
                array_flip($choices);
        };

        $builder
            ->add('color', LegacyFormHelper::getType(ChoiceType::class), array(
                'label' => 'Select color',
                'choices' => $flipChoices(array(
                    'red' => 'Red',
                    'blue' => 'Blue',
                    'yellow' => 'Yellow',
                )),
                'data' => 'red',
            ));
    }

    public function getName()
    {
        return 'color';
    }
}
