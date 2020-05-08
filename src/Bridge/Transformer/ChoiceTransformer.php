<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\AlwaysReturnKeyOfChoiceQuestion;
use Symfony\Component\Console\Question\Question;
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
}
