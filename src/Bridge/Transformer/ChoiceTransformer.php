<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\RawChoiceQuestion;
use Symfony\Component\Form\Form;

class ChoiceTransformer extends AbstractTransformer
{
    public function transform(Form $form)
    {
        $formView = $form->createView();

        $choices = [];
        foreach ($formView->vars['choices'] as $choiceView) {
            $choices[$choiceView->value] = $choiceView->label;
        }

        $question = new RawChoiceQuestion($this->questionFrom($form), $choices, $this->defaultValueFrom($form));

        if ($form->getConfig()->getOption('multiple')) {
            $question->setMultiselect(true);
        }

        return $question;
    }
}
