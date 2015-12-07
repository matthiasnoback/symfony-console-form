<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Matthias\SymfonyConsoleForm\Form\EventListener\UseInputOptionsAsEventDataEventSubscriber;
use Matthias\SymfonyConsoleForm\LegacyFormHelper;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsoleFormTypeExtension extends AbstractTypeExtension
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new UseInputOptionsAsEventDataEventSubscriber());
    }

    /**
     * @return string
     */
    public function getExtendedType()
    {
        return LegacyFormHelper::getType(FormType::class);
    }
}
