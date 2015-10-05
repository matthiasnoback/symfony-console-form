<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\AlwaysReturnKeyOfChoiceQuestion;
use Symfony\Component\Form\Form;

class ChoiceTransformer extends AbstractTransformer
{
    /**
     * @param Form $form
     *
     * @return Question
     */
    public function transform(Form $form)
    {
        $formView = $form->createView();

        $question = new AlwaysReturnKeyOfChoiceQuestion($this->questionFrom($form), $formView->vars['choices'], $this->defaultValueFrom($form));

        if ($form->getConfig()->getOption('multiple')) {
            $question->setMultiselect(true);
        }

        return $question;
    }
}
