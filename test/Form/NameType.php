<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class NameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            [
                'label' => 'Your name',
                'data' => 'Matthias',
                'constraints' => array(
                    new Length(array('min' => 4))
                )
            ]
        )->add(
            'submit',
            'submit',
            [
                'label' => 'Submit'
            ]
        );
    }

    public function getName()
    {
        return 'name';
    }
}
