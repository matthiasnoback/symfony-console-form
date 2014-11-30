<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class PasswordTransformer extends TextTransformer
{
    public function transform(Form $form)
    {
        $question = parent::transform($form);
        $question->setHidden(true);

        return $question;
    }
}
