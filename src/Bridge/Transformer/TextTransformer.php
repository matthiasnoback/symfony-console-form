<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

class TextTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form): Question
    {
        return new Question($this->questionFrom($form), $this->defaultValueFrom($form));
    }
}
