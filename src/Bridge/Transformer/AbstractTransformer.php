<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;

/**
 * Reusable code for FormToQuestionTransformers.
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    /**
     * @param FormInterface $form
     *
     * @return string
     */
    protected function questionFrom(FormInterface $form)
    {
        $question = FormUtil::label($form);

        return $this->formattedQuestion($question, $this->defaultValueFrom($form));
    }

    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getData();
    }

    /**
     * @param string $question
     * @param string $defaultValue
     *
     * @return string
     */
    protected function formattedQuestion($question, $defaultValue)
    {
        return Format::forQuestion($question, $defaultValue);
    }
}
