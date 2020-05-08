<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

final class CheckboxTransformer extends AbstractTransformer
{
    public function transform(FormInterface $form): Question
    {
        return new ConfirmationQuestion($this->questionFrom($form), $this->defaultValueFrom($form));
    }
}
