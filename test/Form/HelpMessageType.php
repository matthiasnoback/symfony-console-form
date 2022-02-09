<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class HelpMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'fieldCompany',
                TextType::class,
                [
                    'label' => 'Company',
                    'help' => 'help_message_one',
                    'help_translation_parameters' => [
                        '%company%' => 'ACME Inc.',
                    ],
                    'translation_domain' => 'parent_domain'
                ]
            );
    }
}
