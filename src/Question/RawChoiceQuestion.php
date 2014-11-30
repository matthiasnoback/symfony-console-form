<?php

namespace Matthias\SymfonyConsoleForm\Question;

use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * Inherits default behavior of ChoiceQuestion, but returns the value of a choice instead of its label
 */
class RawChoiceQuestion extends ChoiceQuestion
{
    public function getValidator()
    {
        $originalValidator = parent::getValidator();
        return function ($selected) use ($originalValidator) {
            $value = $originalValidator($selected);
            $choices = array_flip($this->getChoices());
            if (is_array($value)) {
                return array_intersect_key($choices, $value);
            } else {
                return $choices[$value];
            }
        };
    }
}
