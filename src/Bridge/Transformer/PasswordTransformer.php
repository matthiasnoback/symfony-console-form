<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class PasswordTransformer extends TextTransformer
{
    /**
     * @param Form $form
     *
     * @return Question
     */
    public function transform(Form $form)
    {
        $question = parent::transform($form);
        $question->setHidden(true);

        return $question;
    }

    /**
     * @param FormInterface $form
     *
     * @return string
     */
    public function getFakeData(FormInterface $form)
    {
        return 'password data';
    }
}
