<?php

declare(strict_types=1);

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

abstract class AbstractTextInputBasedTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form): Question
    {
        return new Question($this->questionFrom($form), $this->defaultValueFrom($form));
    }

    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }
}
