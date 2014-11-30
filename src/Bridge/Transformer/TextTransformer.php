<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class TextTransformer extends AbstractTransformer
{
    public function transform(Form $form, FormView $formView)
    {
        return new Question($this->questionFrom($formView), $this->defaultValueFrom($formView));
    }
}
