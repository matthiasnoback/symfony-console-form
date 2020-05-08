<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Matthias\SymfonyConsoleForm\Form\EventListener\UseInputOptionsAsEventDataEventSubscriber;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

class ConsoleFormTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventSubscriber(new UseInputOptionsAsEventDataEventSubscriber());
    }

    public function getExtendedType(): string
    {
        return FormType::class;
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}
