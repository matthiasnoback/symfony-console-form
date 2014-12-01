<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Matthias\SymfonyConsoleForm\Form\EventListener\UseInputOptionsAsEventDataEventSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

class ConsoleFormTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new UseInputOptionsAsEventDataEventSubscriber());
    }

    public function getExtendedType()
    {
        return 'form';
    }
}
