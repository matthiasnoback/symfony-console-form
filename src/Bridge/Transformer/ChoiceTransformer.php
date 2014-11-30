<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\RawChoiceQuestion;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class ChoiceTransformer extends AbstractTransformer
{
    public function transform(Form $form, FormView $formView)
    {
        $choices = [];
        foreach ($formView->vars['choices'] as $choiceView) {
            $choices[$choiceView->value] = $choiceView->label;
        }

        $question = new RawChoiceQuestion($this->questionFrom($formView), $choices, $this->defaultValueFrom($formView));

        if ($form->getConfig()->getOption('multiple')) {
            $question->setMultiselect(true);
        }

        return $question;
    }
}
