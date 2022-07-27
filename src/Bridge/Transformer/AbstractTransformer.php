<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Formatter\Format;
use Matthias\SymfonyConsoleForm\Form\FormUtil;
use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Reusable code for FormToQuestionTransformers.
 */
abstract class AbstractTransformer implements FormToQuestionTransformer
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    abstract protected function defaultValueFrom(FormInterface $form);

    protected function questionFrom(FormInterface $form): string
    {
        $translationDomain = $this->translationDomainFrom($form);
        $question = $this->translator->trans(FormUtil::label($form), [], $translationDomain);
        $help = FormUtil::help($form);
        if ($help !== null) {
            $help = $this->translator->trans($help, FormUtil::helpTranslationParameters($form), $translationDomain);
        }

        return $this->formattedQuestion($question, $this->defaultValueFrom($form), $help);
    }

    protected function translationDomainFrom(FormInterface $form): ?string
    {
        while ((null === $domain = $form->getConfig()->getOption('translation_domain')) && $form->getParent()) {
            $form = $form->getParent();
        }

        return $domain;
    }

    /**
     * @param mixed $defaultValue
     * @return string
     */
    protected function formattedQuestion(string $question, $defaultValue, ?string $help = null): string
    {
        return Format::forQuestion($question, $defaultValue, $help);
    }
}
