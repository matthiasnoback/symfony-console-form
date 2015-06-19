<?php

namespace Matthias\SymfonyConsoleForm\Console\Helper\Question;

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
            if (!method_exists($this, 'isAssoc')) {
                // for Symfony < 2.7 $value represents the selected label(s) so we need to find out the selected key(s)
                $choices = array_flip($this->getChoices());
                if (is_array($value)) {
                    return array_intersect_key($choices, $value);
                }

                return $choices[$value];
            }

            return $value;
        };
    }
}
