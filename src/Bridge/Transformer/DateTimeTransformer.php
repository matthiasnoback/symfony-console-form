<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

final class DateTimeTransformer extends AbstractTextInputBasedTransformer
{
    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }
}
