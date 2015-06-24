<?php

namespace Matthias\SymfonyConsoleForm\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RepeatedPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('password', 'repeated', [
            'type' => 'password',
            'invalid_message' => 'The password fields must match.',
            'first_options' => array('label' => 'Admin Password'),
            'second_options' => array('label' => 'Repeat Password'),
        ]);
    }

    public function getName()
    {
        return 'repeated_password';
    }
}
