<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\Form;

/**
 * Transform the given form (field) to a Question used by the Console Component to interact with the user
 */
interface FormToQuestionTransformer
{
    /**
     * @return Question
     */
    public function transform(Form $form);
}
