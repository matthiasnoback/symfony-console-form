<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

class DateTimeTransformer extends TextTransformer
{
    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }
}
