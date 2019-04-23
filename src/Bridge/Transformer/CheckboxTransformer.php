<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

class CheckboxTransformer extends AbstractTransformer
{
    /**
     * @param FormInterface $form
     *
     * @return Question
     */
    public function transform(FormInterface $form)
    {
        return new ConfirmationQuestion($this->questionFrom($form), $this->defaultValueFrom($form));
    }
}
