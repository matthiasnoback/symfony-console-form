<?php

namespace Matthias\SymfonyConsoleForm;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

final class LegacyFormHelper
{
    private static $map = [
        FormType::class => 'form',
    ];

    public static function getType($fqcn, $name = null)
    {
        return self::isLegacy() ?
            array_key_exists($fqcn, self::$map) ?
                self::$map[$fqcn] :
                $name :
            $fqcn;
    }

    public static function isLegacy()
    {
        return !method_exists(AbstractType::class, 'getBlockPrefix');
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}
