<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Matthias\SymfonyConsoleForm\Console\Helper\Question\AlwaysReturnKeyOfChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

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

    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        if ($choices = $form->getConfig()->getOption('choices')) {
            if (is_array($choices)) {
                reset($choices);

                return $choices[key($choices)];
            }
        }

        return 'Unknown choice';
    }
}
