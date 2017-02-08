<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Reusable code for FormToQuestionTransformers.
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    /** @var TranslatorInterface */
    private $translator;

    /**
     * NumberTransformer constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param FormInterface $form
     *
     * @return string
     */
    protected function questionFrom(FormInterface $form)
    {
        $question = $this->translator->trans(FormUtil::label($form));

        return $this->formattedQuestion($question, $this->defaultValueFrom($form));
    }


    /**
     * @param FormInterface $form
     *
     * @return mixed
     */
    protected function defaultValueFrom(FormInterface $form)
    {
        $defaultValue = $form->getData();
        if (is_array($defaultValue)) {
            $defaultValue = implode(',', $defaultValue);
        }

        return $defaultValue;
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
