<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

class FormUtil
{
    public static function typeAncestry(FormInterface $form)
    {
        $types = [];
        self::typeAncestryForType($form->getConfig()->getType(), $types);

        return $types;
    }

    public static function typeAncestryForType(ResolvedFormTypeInterface $formType = null, array &$types)
    {
        if (!($formType instanceof ResolvedFormTypeInterface)) {
            return;
        }

        $types[] = $formType->getName();

        self::typeAncestryForType($formType->getParent(), $types);
    }

    public static function isTypeInAncestry(FormInterface $form, $type)
    {
        return in_array($type, self::typeAncestry($form));
    }

    public static function type(FormInterface $form)
    {
        return $form->getConfig()->getType()->getName();
    }

    public static function label(FormInterface $form)
    {
        return $form->getConfig()->getOption('label', $form->getName());
    }

    public static function isCompound(FormInterface $form)
    {
        return $form->getConfig()->getOption('compound');
    }
}
