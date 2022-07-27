<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractChoiceTransformer extends AbstractTransformer
{
    protected function defaultValueFrom(FormInterface $form)
    {
        $defaultValue = $form->getData();
        if (is_array($defaultValue)) {
            $defaultValue = implode(',', $defaultValue);
        }

        return $defaultValue;
    }
}
