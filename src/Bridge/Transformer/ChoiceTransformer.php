<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\AlwaysReturnKeyOfChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;

final class ChoiceTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form): Question
    {
        $formView = $form->createView();

        $question = new AlwaysReturnKeyOfChoiceQuestion($this->questionFrom($form), $formView->vars['choices'], $this->defaultValueFrom($form));

        if ($form->getConfig()->getOption('multiple')) {
            $question->setMultiselect(true);
        }

        return $question;
    }

    protected function defaultValueFrom(FormInterface $form)
    {
        $defaultValue = parent::defaultValueFrom($form);

        // $defaultValue could be an object
        // Let's find out what form computed to be its view representation
        $formView = $form->createView();
        $defaultValueFromChoiceView = \array_reduce(
            $formView->vars['choices'],
            static fn(
                ?string $carry,
                ChoiceView $choiceView
            ): ?string => (null === $carry && $choiceView->data === $defaultValue) ? $choiceView->value : $carry
        );
        return $defaultValueFromChoiceView ?? $defaultValue;
    }
}
