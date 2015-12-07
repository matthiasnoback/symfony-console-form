<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Matthias\SymfonyConsoleForm\LegacyFormHelper;
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
            LegacyFormHelper::getType(TextType::class),
            [
                'label' => 'Your name',
                'data' => 'Matthias',
                'constraints' => array(
                    new Length(array('min' => 4)),
                ),
            ]
        )->add(
            'submit',
            LegacyFormHelper::getType(SubmitType::class),
            [
                'label' => 'Submit',
            ]
        );
    }

    public function getName()
    {
        return 'name';
    }
}
