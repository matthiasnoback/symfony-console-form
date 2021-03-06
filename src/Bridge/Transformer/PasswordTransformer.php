<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

final class PasswordTransformer extends AbstractTextInputBasedTransformer
{
    public function transform(FormInterface $form): Question
    {
        $question = parent::transform($form);
        $question->setHidden(true);

        return $question;
    }
}
