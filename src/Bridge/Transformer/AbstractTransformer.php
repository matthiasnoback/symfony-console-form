<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormView;

/**
 * Reusable code for FormToQuestionTransformers
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    protected function questionFrom(FormView $formView)
    {
        $question = isset($formView->vars['label']) ? $formView->vars['label'] : $formView->vars['name'];

        return $this->formattedQuestion($question, $this->defaultValueFrom($formView));
    }

    protected function defaultValueFrom(FormView $formView)
    {
        return isset($formView->vars['data']) ? $formView->vars['data'] : null;
    }

    protected function formattedQuestion($question, $defaultValue)
    {
        $default = $defaultValue ? strtr(
            ' [<info>{defaultValue}</info>]',
            ['{defaultValue}' => $defaultValue]
        ) : '';

        return strtr(
            '<question>{question}</question>{default}: ',
            [
                '{question}' => $question,
                '{default}' => $default
            ]
        );
    }
}
