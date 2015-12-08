<?php

namespace Matthias\SymfonyConsoleForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

final class LegacyFormHelper
{
    private static $map = [
        FormType::class => 'form',
        TextType::class => 'text',
        DateType::class => 'date',
        ChoiceType::class => 'choice',
        RepeatedType::class => 'repeated',
        PasswordType::class => 'password',
        ButtonType::class => 'button',
        SubmitType::class => 'submit',
    ];

    public static function getType($fqcn, $name = null)
    {
        return self::isLegacy() ?
            array_key_exists($fqcn, self::$map) ?
                self::$map[$fqcn] :
                $name :
            $fqcn;
    }

    public static function getName($formType)
    {
        if ($formType instanceof ResolvedFormTypeInterface) {
            return self::isLegacy() ?
                $formType->getName() :
                get_class($formType->getInnerType());
        }

        if ($formType instanceof FormTypeInterface) {
            return self::isLegacy() ?
                $formType->getName() :
                get_class($formType);
        }
    }

    public static function getCompound(FormInterface $form)
    {
        return self::isLegacy() ?
            $form->getConfig()->getOption('compound') :
            $form->getConfig()->getCompound();
    }

    public static function isLegacy()
    {
        return !method_exists(AbstractType::class, 'getBlockPrefix');
    }

    public static function isSymfony3()
    {
        return !method_exists(AbstractType::class, 'getName');
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
