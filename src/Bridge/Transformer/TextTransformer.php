<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;

class TextTransformer extends AbstractTransformer
{
    /**
     * @param Form $form
     *
     * @return Question
     */
    public function transform(Form $form)
    {
        return new Question($this->questionFrom($form), $this->defaultValueFrom($form));
    }
}
