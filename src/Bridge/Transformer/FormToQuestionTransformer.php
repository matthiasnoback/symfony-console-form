<?php

namespace Matthias\SymfonyConsoleForm\Bridge\Transformer;

use Symfony\Component\Console\Question\Question;
use Symfony\Component\Form\FormInterface;

/**
 * Transform the given form (field) to a Question used by the Console Component to interact with the user.
 */
interface FormToQuestionTransformer
{
    public function transform(FormInterface $form): Question;
}
