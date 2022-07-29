<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\AlwaysReturnKeyOfChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;

final class ChoiceTransformer extends AbstractChoiceTransformer
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

        /*
         * $defaultValue can be anything, since it's the form's (default) data. For the ChoiceType form type the default
         * value may be derived from the choice_label option, which transforms the data to a string. We look for the
         * choice matching the default data and return its calculated value.
         */
        $formView = $form->createView();
        foreach ($formView->vars['choices'] as $choiceView) {
            /** @var ChoiceView $choiceView */
            if ($choiceView->data == $defaultValue) {
                return $choiceView->value;
            }
        }

        return $defaultValue;
    }
}
