<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

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

    /**
     * @param FormInterface $form
     *
     * @return mixed|string
     */
    public function getFakeData(FormInterface $form)
    {
        if ($form->getViewData()) {
            return $form->getViewData();
        }

        return 'dummy data';
    }
}
