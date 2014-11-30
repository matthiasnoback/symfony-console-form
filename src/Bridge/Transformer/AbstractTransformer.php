<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\FormInterface;

/**
 * Reusable code for FormToQuestionTransformers
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    protected function questionFrom(FormInterface $form)
    {
        $question = $form->getConfig()->getOption('label', $form->getName());

        return $this->formattedQuestion($question, $this->defaultValueFrom($form));
    }

    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getData();
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
