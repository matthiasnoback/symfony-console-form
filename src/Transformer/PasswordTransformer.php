<?php

namespace Matthias\SymfonyConsoleForm\Transformer;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

class PasswordTransformer extends TextTransformer
{
    public function transform(Form $form, FormView $formView)
    {
        $question = parent::transform($form, $formView);
        $question->setHidden(true);

        return $question;
    }
}
