<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class GenericTransformer extends AbstractTransformer
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
     * @return mixed
     */
    protected function defaultValueFrom(FormInterface $form)
    {
        return $form->getViewData();
    }
}
