<?php

namespace Matthias\SymfonyConsoleForm\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ResolvedFormTypeInterface;

class FormUtil
{
    public static function typeAncestry(FormInterface $form): array
    {
        $types = [];
        self::typeAncestryForType($form->getConfig()->getType(), $types);

        return $types;
    }

    public static function typeAncestryForType(?ResolvedFormTypeInterface $formType, array &$types)
    {
        if (!($formType instanceof ResolvedFormTypeInterface)) {
            return;
        }

        $types[] = get_class($formType->getInnerType());

        self::typeAncestryForType($formType->getParent(), $types);
    }

    public static function isTypeInAncestry(FormInterface $form, string $type): bool
    {
        return in_array($type, self::typeAncestry($form));
    }

    public static function type(FormInterface $form): string
    {
        return get_class($form->getConfig()->getType()->getInnerType());
    }

    public static function label(FormInterface $form): string
    {
        $label = $form->getConfig()->getOption('label');

        if (!$label) {
            $label = self::humanize($form->getName());
        }

        return $label;
    }

    public static function help(FormInterface $form): ?string
    {
        return $form->getConfig()->getOption('help');
    }

    public static function helpTranslationParameters(FormInterface $form): array
    {
        return $form->getConfig()->getOption('help_translation_parameters');
    }

    public static function isCompound(FormInterface $form): bool
    {
        return $form->getConfig()->getCompound();
    }

    /**
     * Copied from Symfony\Component\Form method humanize.
     */
    private static function humanize($text): string
    {
        return ucfirst(trim(strtolower(preg_replace(array('/([A-Z])/', '/[_\s]+/'), array('_$1', ' '), $text))));
    }
}
