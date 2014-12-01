<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;

/**
 * Reusable code for FormToQuestionTransformers
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    protected function questionFrom(FormInterface $form)
    {
        $question = FormUtil::label($form);

        return $this->formattedQuestion($question, $this->defaultValueFrom($form));
    }

    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getData();
    }

    protected function formattedQuestion($question, $defaultValue)
    {
        return Format::forQuestion($question, $defaultValue);
    }
}
