<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Symfony\Component\Form\FormInterface;

class FormUtil
{
    public static function typeAncestry(FormInterface $form)
    {
        $child = $form;
        $ancestorTypeNames = [
            self::type($child)
        ];

        while ($parent = $child->getParent()) {
            $ancestorTypeNames[] = self::type($parent);

            $child = $parent;
        }

        return $ancestorTypeNames;
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
